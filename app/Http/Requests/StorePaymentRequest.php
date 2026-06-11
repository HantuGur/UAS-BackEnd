<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'order_id'       => 'required|exists:orders,id',
            'payment_method' => 'required|in:cash,qris',
            'amount'         => 'required|integer|min:0',
            'cash_received'  => 'nullable|integer|min:0',
            'promo_id'       => 'nullable|exists:promos,id',
        ];
    }
    public function messages(): array {
        return [
            'order_id.required'       => 'ID pesanan wajib ada.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
            'amount.required'         => 'Jumlah pembayaran wajib diisi.',
        ];
    }
}