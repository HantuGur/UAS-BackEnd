<?php
namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Promo;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request) {
        $orders = Order::with(['customer', 'items', 'promo'])->orderBy('created_at', 'desc')->get();
        if ($request->wantsJson()) return response()->json($orders);
        return view('orders.index', compact('orders'));
    }
    public function create(): View {
        $customers = Customer::orderBy('name')->get();
        $menus     = Menu::orderBy('category')->orderBy('name')->get();
        $tables    = Table::where('status', 'available')->get();
        $promos    = Promo::where('status', 'active')->where('expired_at', '>=', date('Y-m-d'))->get();
        return view('orders.create', compact('customers', 'menus', 'tables', 'promos'));
    }
    public function store(Request $request) {
        $request->validate([
            'customer_type'      => 'required|in:existing,new',
            'customer_id'        => 'required_if:customer_type,existing|nullable|exists:customers,id',
            'new_customer_name'  => 'required_if:customer_type,new|nullable|string|max:255',
            'new_customer_email' => 'nullable|email|max:255',
            'order_type'         => 'required|in:dine_in,take_away',
            'table_id'           => 'required_if:order_type,dine_in|nullable|exists:tables,id',
            'promo_id'           => 'nullable|exists:promos,id',
            'payment_method'     => 'required|in:cash,qris',
            'items'              => 'required|array|min:1',
            'items.*.menu_id'    => 'required|exists:menus,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        $order = DB::transaction(function () use ($request) {
            if ($request->customer_type === 'new') {
                $email = $request->new_customer_email;
                if (empty($email)) {
                    $email = 'walkin_' . strtolower(str_replace(' ', '', $request->new_customer_name)) . '_' . rand(1000, 9999) . '@resto3d.com';
                }
                $customer = Customer::firstOrCreate(['email' => $email], ['name' => $request->new_customer_name]);
            } else {
                $customer = Customer::findOrFail($request->customer_id);
            }

            $subtotal = 0;
            $itemsToCreate = [];
            foreach ($request->items as $itemData) {
                if (empty($itemData['menu_id'])) continue;
                $menu = Menu::findOrFail($itemData['menu_id']);
                $qty = (int) $itemData['quantity'];
                $subtotal += $menu->price * $qty;
                $itemsToCreate[] = ['menu' => $menu, 'quantity' => $qty];
            }

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
                'customer_id'     => $customer->id,
                'total_price'     => $totalPrice,
                'discount_amount' => $discountAmount,
                'promo_id'        => $request->promo_id ?: null,
                'status'          => 'pending',
                'order_type'      => $request->order_type,
                'table_id'        => $request->order_type === 'dine_in' ? $request->table_id : null,
            ]);

            foreach ($itemsToCreate as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id'  => $item['menu']->id,
                    'name'     => $item['menu']->name,
                    'price'    => $item['menu']->price,
                    'quantity' => $item['quantity'],
                ]);
            }

            if ($request->order_type === 'dine_in' && $request->table_id) {
                Table::find($request->table_id)?->update(['status' => 'occupied']);
            }
            return $order;
        });

        if ($request->wantsJson()) {
            $order->load(['customer', 'items', 'promo']);
            return response()->json($order, 201);
        }
        if ($request->payment_method === 'cash') {
            return redirect()->route('payments.create', ['order_id' => $order->id])->with('success', 'Pesanan berhasil dibuat. Silakan proses pembayaran tunai.');
        }
        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat.');
    }

    public function show(Request $request, Order $order) {
        $order->load(['customer', 'items', 'promo']);
        if ($request->wantsJson()) return response()->json($order);
        return view('orders.show', compact('order'));
    }
    public function edit(Order $order): View { return view('orders.edit', compact('order')); }
    public function update(Request $request, Order $order) {
        $validated = $request->validate(['status' => 'required|string|in:pending,completed']);
        $order->update($validated);
        if ($request->wantsJson()) return response()->json($order);
        return redirect()->route('orders.show', $order)->with('success', 'Status pesanan berhasil diperbarui.');
    }
    public function destroy(Request $request, Order $order) {
        $order->delete();
        if ($request->wantsJson()) return response()->json(['message' => 'Success']);
        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }
    public function getByStatus(Request $request, string $status) {
        if (!in_array($status, ['pending', 'completed'])) abort(404);
        $orders = Order::where('status', $status)->with(['customer', 'items', 'promo'])->orderBy('created_at', 'desc')->get();
        if ($request->wantsJson()) return response()->json($orders);
        $currentStatus = $status;
        return view('orders.index', compact('orders', 'currentStatus'));
    }
}