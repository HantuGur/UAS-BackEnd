<?php
namespace App\Http\Controllers;
use App\Models\Promo;
use App\Http\Requests\StorePromoRequest;

class PromoController extends Controller
{
    public function index() {
        $promos = Promo::latest()->get();
        return view('promos.index', compact('promos'));
    }
    public function create() { return view('promos.create'); }
    public function store(StorePromoRequest $request) {
        Promo::create($request->validated());
        return redirect()->route('promos.index')->with('success', 'Promo baru berhasil ditambahkan.');
    }
    public function edit(Promo $promo) { return view('promos.edit', compact('promo')); }
    public function update(StorePromoRequest $request, Promo $promo) {
        $promo->update($request->validated());
        return redirect()->route('promos.index')->with('success', 'Promo berhasil diperbarui.');
    }
    public function destroy(Promo $promo) {
        $promo->delete();
        return redirect()->route('promos.index')->with('success', 'Promo berhasil dihapus.');
    }
    public function publicIndex() {
        $promos = Promo::where('status', 'active')
            ->where('is_public', true)
            ->where('expired_at', '>=', date('Y-m-d'))
            ->get();
        return response()->json($promos);
    }
}