<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'item_name' => 'required|string|max:255',
            'stock_quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50'
        ];
    }
    public function messages(): array {
        return [
            'supplier_id.required' => 'Supplier wajib dipilih.',
            'item_name.required'   => 'Nama bahan baku wajib diisi.',
            'quantity.min'         => 'Stok tidak boleh negatif.',
        ];
    }
}

