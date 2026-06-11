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
    public function messages(): array {
        return [
            'reservation_time.after' => 'Waktu reservasi harus lebih dari waktu sekarang.',
            'guests_count.min'       => 'Jumlah tamu minimal 1 orang.',
        ];
    }
}