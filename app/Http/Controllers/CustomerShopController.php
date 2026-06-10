<?php
namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use App\Models\Promo;
use App\Models\Payment;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerShopController extends Controller
{
    public function index(Request $request) {
        $query = Menu::query();
        if ($request->category && $request->category !== 'semua') $query->where('category', $request->category);
        if ($request->search) $query->where('name', 'like', '%' . $request->search . '%');
        $menus = $query->get();
        $categories = Category::orderBy('name')->get();
        $cartCount = 0;
        if (session()->has('customer_id')) {
            $cartCount = Cart::where('customer_id', session('customer_id'))->sum('quantity');
        }
        return view('customer.shop', compact('menus', 'categories', 'cartCount'));
    }
    public function addToCart(Request $request) {
        if (!session()->has('customer_id')) return redirect()->route('customer.login')->with('error', 'Silakan login terlebih dahulu.');
        $request->validate(['menu_id' => 'required|exists:menus,id', 'quantity' => 'required|integer|min:1', 'note' => 'nullable|string|max:255']);
        $customerId = session('customer_id');
        $existing = Cart::where('customer_id', $customerId)->where('menu_id', $request->menu_id)->where('note', $request->note)->first();
        if ($existing) {
            $existing->increment('quantity', $request->quantity);
        } else {
            Cart::create(['customer_id' => $customerId, 'menu_id' => $request->menu_id, 'quantity' => $request->quantity, 'note' => $request->note]);
        }
        return redirect()->route('customer.shop')->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }
    public function cart() {
        if (!session()->has('customer_id')) return redirect()->route('customer.login');
        $carts = Cart::with('menu')->where('customer_id', session('customer_id'))->get();
        $total = $carts->sum(fn($item) => $item->menu->price * $item->quantity);
        return view('customer.cart', compact('carts', 'total'));
    }
    public function removeFromCart($id) {
        $cart = Cart::where('customer_id', session('customer_id'))->findOrFail($id);
        $cart->delete();
        return redirect()->route('customer.cart')->with('success', 'Menu berhasil dihapus dari keranjang.');
    }
    public function checkout() {
        if (!session()->has('customer_id')) return redirect()->route('customer.login');
        $carts = Cart::with('menu')->where('customer_id', session('customer_id'))->get();
        if ($carts->isEmpty()) return redirect()->route('customer.shop')->with('error', 'Keranjang belanja Anda masih kosong.');
        $total  = $carts->sum(fn($item) => $item->menu->price * $item->quantity);
        $tables = Table::where('status', 'available')->get();
        $promos = Promo::where('status', 'active')->where('is_public', true)->where('expired_at', '>=', date('Y-m-d'))->get();
        return view('customer.checkout', compact('carts', 'total', 'tables', 'promos'));
    }

    public function processCheckout(Request $request) {
        if (!session()->has('customer_id')) return redirect()->route('customer.login');
        $request->validate([
            'order_type'     => 'required|in:dine_in,take_away',
            'table_id'       => 'required_if:order_type,dine_in|nullable|exists:tables,id',
            'promo_id'       => 'nullable|exists:promos,id',
            'payment_method' => 'required|in:cash,qris',
        ]);
        $customerId = session('customer_id');
        $carts = Cart::with('menu')->where('customer_id', $customerId)->get();
        if ($carts->isEmpty()) return redirect()->route('customer.shop')->with('error', 'Keranjang belanja kosong.');

        $order = DB::transaction(function () use ($request, $customerId, $carts) {
            $subtotal = $carts->sum(fn($item) => $item->menu->price * $item->quantity);
            $discountAmount = 0;
            if ($request->promo_id) {
                $promo = Promo::find($request->promo_id);
                if ($promo) {
                    if ($promo->discount_type === 'percent') {
                        $rawDiscount = (int) round($subtotal * $promo->discount_amount / 100);
                        $discountAmount = $promo->max_discount ? min($rawDiscount, $promo->max_discount) : $rawDiscount;
                    } else {
                        $discountAmount = $promo->discount_amount;
                    }
                }
            }
            $totalPrice = max(0, $subtotal - $discountAmount);
            $order = Order::create([
                'customer_id'     => $customerId,
                'total_price'     => $totalPrice,
                'discount_amount' => $discountAmount,
                'promo_id'        => $request->promo_id ?: null,
                'status'          => 'pending',
                'order_type'      => $request->order_type,
                'table_id'        => $request->order_type === 'dine_in' ? $request->table_id : null,
            ]);
            foreach ($carts as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id'  => $cartItem->menu_id,
                    'name'     => $cartItem->menu->name,
                    'price'    => $cartItem->menu->price,
                    'quantity' => $cartItem->quantity,
                    'note'     => $cartItem->note,
                ]);
            }
            if ($request->order_type === 'dine_in') {
                Table::find($request->table_id)->update(['status' => 'occupied']);
            }
            Cart::where('customer_id', $customerId)->delete();
            Payment::create(['order_id' => $order->id, 'payment_method' => $request->payment_method, 'amount' => $totalPrice, 'status' => 'pending']);
            return $order;
        });

        if ($request->payment_method === 'qris') return redirect()->route('customer.qris', $order->id);
        return redirect()->route('customer.orders')->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran tunai di kasir.');
    }

    public function qrisPayment($id) {
        $order = Order::where('customer_id', session('customer_id'))->findOrFail($id);
        $payment = Payment::where('order_id', $order->id)->first();
        return view('customer.qris', compact('order', 'payment'));
    }

    public function confirmQris($id) {
        $order = Order::where('customer_id', session('customer_id'))->findOrFail($id);
        DB::transaction(function () use ($order) {
            Payment::where('order_id', $order->id)->update(['status' => 'success']);
            $order->update(['status' => 'completed']);
        });
        return redirect()->route('customer.orders')->with('success', 'Pembayaran QRIS berhasil! Pesanan Anda sedang diproses.');
    }

    public function myOrders() {
        if (!session()->has('customer_id')) return redirect()->route('customer.login');
        $orders = Order::with(['items', 'customer'])->where('customer_id', session('customer_id'))->latest()->get();
        return view('customer.orders', compact('orders'));
    }
    public function addReview($menu_id) {
        $menu = Menu::findOrFail($menu_id);
        return view('customer.reviews', compact('menu'));
    }
    public function storeReview(Request $request) {
        $request->validate(['menu_id' => 'required|exists:menus,id', 'rating' => 'required|integer|min:1|max:5', 'comment' => 'nullable|string']);
        Review::create(['customer_id' => session('customer_id'), 'menu_id' => $request->menu_id, 'rating' => $request->rating, 'comment' => $request->comment]);
        return redirect()->route('customer.orders')->with('success', 'Terima kasih atas ulasan Anda!');
    }
    public function addFeedback() {
        $cartCount = 0;
        if (session()->has('customer_id')) $cartCount = Cart::where('customer_id', session('customer_id'))->sum('quantity');
        return view('customer.feedback', compact('cartCount'));
    }
    public function storeFeedback(Request $request) {
        $request->validate(['subject' => 'required|string|max:255', 'message' => 'required|string']);
        \App\Models\Feedback::create(['customer_id' => session('customer_id'), 'subject' => $request->subject, 'message' => $request->message]);
        return redirect()->route('customer.feedback')->with('success', 'Aduan Anda berhasil dikirim dan akan segera diproses.');
    }
    public function validatePromo(Request $request) {
        $request->validate(['code' => 'required|string']);
        $promo = Promo::where('code', strtoupper($request->code))->where('status', 'active')->where('expired_at', '>=', date('Y-m-d'))->first();
        if (!$promo) {
            return response()->json(['success' => false, 'message' => 'Kode voucher tidak valid atau sudah kadaluarsa.']);
        }
        return response()->json([
            'success' => true,
            'promo'   => ['id' => $promo->id, 'code' => $promo->code, 'discount_type' => $promo->discount_type, 'discount_amount' => $promo->discount_amount, 'max_discount' => $promo->max_discount]
        ]);
    }
}