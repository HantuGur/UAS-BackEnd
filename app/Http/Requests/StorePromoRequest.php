<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StorePromoRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'code'            => 'required|string|max:50',
            'discount_type'   => 'required|in:fixed,percent',
            'discount_amount' => 'required|integer|min:0',
            'max_discount'    => 'nullable|integer|min:0',
            'expired_at'      => 'required|date',
            'status'          => 'required|in:active,inactive',
            'is_public'       => 'required|boolean',
        ];
    }
}