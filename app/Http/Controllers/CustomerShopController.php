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
}