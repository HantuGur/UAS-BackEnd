<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'customer_id'      => 'required|exists:customers,id',
            'table_id'         => 'required|exists:tables,id',
            'reservation_time' => 'required|date|after:now',
            'guests_count'     => 'required|integer|min:1',
        ];
    }
}