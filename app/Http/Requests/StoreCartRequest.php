<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreCartRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string'
        ];
    }
}