<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Menampilkan isi keranjang belanja
    public function index()
    {
        $carts = Cart::with('menu')->get();
        $total = $carts->sum(fn($item) => $item->menu->price * $item->quantity);
        return view('carts.index', compact('carts', 'total'));
    }

    // Simpan item ke keranjang, gabungkan jika menu sudah ada
    public function store(StoreCartRequest $request)
    {
        $existing = Cart::where('customer_id', $request->customer_id)
                        ->where('menu_id', $request->menu_id)
                        ->first();
        if ($existing) {
            $existing->increment('quantity', $request->quantity);
        } else {
            Cart::create($request->validated());
        }
        return redirect()->route('carts.index')->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    // Hapus satu item dari keranjang
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return redirect()->route('carts.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}
