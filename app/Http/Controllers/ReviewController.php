<?php
namespace App\Http\Controllers;
use App\Models\Review;
use App\Models\Menu;
use App\Http\Requests\StoreReviewRequest;

class ReviewController extends Controller
{
    public function index() {
        $reviews = Review::with(['customer', 'menu'])->latest()->get();
        return view('reviews.index', compact('reviews'));
    }
    public function create() {
        $menus = Menu::all();
        $customers = \App\Models\Customer::all();
        return view('reviews.create', compact('menus', 'customers'));
    }
    public function store(StoreReviewRequest $request) {
        Review::create([
            'customer_id' => $request->customer_id,
            'menu_id'     => $request->menu_id,
            'rating'      => $request->rating,
            'comment'     => $request->comment,
        ]);
        return redirect()->route('reviews.index')->with('success', 'Ulasan berhasil dikirimkan, terima kasih!');
    }
    public function destroy(Review $review) {
        $review->delete();
        return redirect()->route('reviews.index')->with('success', 'Ulasan berhasil dihapus.');
    }
}