<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'customer_id'      => 'required|exists:customers,id',
            'items'            => 'required|array|min:1',
            'items.*.menu_id'  => 'nullable|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }
    public function messages(): array {
        return [
            'customer_id.required'      => 'Pelanggan harus dipilih.',
            'customer_id.exists'        => 'Pelanggan yang dipilih tidak ditemukan.',
            'items.required'            => 'Minimal satu item menu harus dipilih.',
            'items.*.menu_id.exists'    => 'Menu yang dipilih tidak valid.',
            'items.*.quantity.required' => 'Jumlah item harus diisi.',
            'items.*.quantity.min'      => 'Jumlah item minimal 1.',
        ];
    }
}