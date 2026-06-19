<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Http\Requests\StoreFeedbackRequest;

class FeedbackController extends Controller
{
    // Menampilkan semua aduan untuk admin
    public function index()
    {
        $feedbacks = Feedback::with('customer')->latest()->get();
        return view('feedbacks.index', compact('feedbacks'));
    }

    // Form kirim aduan untuk pelanggan
    public function create()
    {
        $customers = \App\Models\Customer::all();
        return view('feedbacks.create', compact('customers'));
    }

    // Menyimpan aduan pelanggan ke database
    public function store(StoreFeedbackRequest $request)
    {
        Feedback::create([
            'customer_id' => $request->customer_id,
            'subject'     => $request->subject,
            'message'     => $request->message,
        ]);
        return redirect()->route('feedbacks.index')->with('success', 'Aduan berhasil disimpan.');
    }

    // Menghapus aduan (hanya admin)
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->route('feedbacks.index')->with('success', 'Aduan berhasil dihapus.');
    }
}