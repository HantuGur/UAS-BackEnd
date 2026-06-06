<?php
namespace App\Http\Controllers;
use App\Models\Payment;
use App\Models\Order;
use App\Http\Requests\StorePaymentRequest;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index() {
        $payments = Payment::with('order.customer')->latest()->get();
        return view('payments.index', compact('payments'));
    }
    public function create(Request $request) {
        $order = null;
        $promos = [];
        if ($request->order_id) {
            $order = Order::with(['items.menu', 'customer', 'promo'])->findOrFail($request->order_id);
            $promos = \App\Models\Promo::where('status', 'active')->where('expired_at', '>=', date('Y-m-d'))->get();
        }
        return view('payments.create', compact('order', 'promos'));
    }
    public function store(StorePaymentRequest $request) {
        // Logic kompleks akan ditambahkan pada Hari 7
        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil diproses!');
    }
    public function show(Payment $payment) {
        $payment->load('order.customer');
        return view('payments.show', compact('payment'));
    }
}