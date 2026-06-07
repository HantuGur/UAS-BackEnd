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
        $order = Order::findOrFail($request->order_id);
        $amount = $request->amount;

        if ($request->promo_id) {
            $promo = \App\Models\Promo::findOrFail($request->promo_id);
            $subtotal = $order->items->sum(fn($i) => $i->price * $i->quantity);
            $discountAmount = 0;
            if ($promo->discount_type === 'percent') {
                $rawDiscount = (int) round($subtotal * $promo->discount_amount / 100);
                $discountAmount = $promo->max_discount ? min($rawDiscount, $promo->max_discount) : $rawDiscount;
            } else {
                $discountAmount = $promo->discount_amount;
            }
            $amount = max(0, $subtotal - $discountAmount);
            $order->update(['promo_id' => $promo->id, 'discount_amount' => $discountAmount, 'total_price' => $amount]);
        }

        $changeAmount = 0;
        if ($request->payment_method === 'cash') {
            if ($request->cash_received < $amount) {
                return back()->withErrors(['cash_received' => 'Uang yang diterima kurang dari total tagihan!'])->withInput();
            }
            $changeAmount = $request->cash_received - $amount;
        }

        // Proteksi double payment
        $payment = Payment::where('order_id', $order->id)->first();
        $paymentData = [
            'payment_method' => $request->payment_method,
            'amount'         => $amount,
            'cash_received'  => $request->cash_received,
            'change_amount'  => $changeAmount,
            'status'         => 'success',
        ];
        if ($payment) {
            $payment->update($paymentData);
        } else {
            $paymentData['order_id'] = $order->id;
            Payment::create($paymentData);
        }

        $order->update(['status' => 'completed']);
        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil diproses!');
    }
    public function show(Payment $payment) {
        $payment->load('order.customer');
        return view('payments.show', compact('payment'));
    }
}