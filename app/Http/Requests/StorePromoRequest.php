<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StorePromoRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'code'            => 'required|string|max:50|unique:promos,code',
            'discount_type'   => 'required|in:percent,fixed',
            'discount_amount' => 'required|integer|min:1',
            'max_discount'    => 'nullable|integer|min:0',
            'is_public'       => 'required|boolean',
            'status'          => 'required|in:active,inactive',
            'expired_at'      => 'required|date|after:today',
        ];
    }
}