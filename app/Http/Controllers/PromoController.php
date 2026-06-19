<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Http\Requests\StorePromoRequest;

class PromoController extends Controller
{
    // Menampilkan semua data voucher promo
    public function index()
    {
        $promos = Promo::latest()->get();
        return view('promos.index', compact('promos'));
    }

    // Form tambah voucher promo baru
    public function create()
    {
        return view('promos.create');
    }

    // Simpan promo baru ke database
    public function store(StorePromoRequest $request)
    {
        Promo::create($request->validated());
        return redirect()->route('promos.index')->with('success', 'Promo baru berhasil ditambahkan.');
    }

    // Form edit promo
    public function edit(Promo $promo)
    {
        return view('promos.edit', compact('promo'));
    }

    // Update data promo
    public function update(StorePromoRequest $request, Promo $promo)
    {
        $promo->update($request->validated());
        return redirect()->route('promos.index')->with('success', 'Promo berhasil diperbarui.');
    }

    // Hapus promo
    public function destroy(Promo $promo)
    {
        $promo->delete();
        return redirect()->route('promos.index')->with('success', 'Promo berhasil dihapus.');
    }
}