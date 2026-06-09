<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'name'        => 'required|string|max:255',
            'price'       => 'required|integer|min:0',
            'category'    => 'required|string|max:100',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
        ];
    }
}