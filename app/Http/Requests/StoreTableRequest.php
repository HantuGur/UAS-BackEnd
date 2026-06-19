<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreTableRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        $tableId = $this->route('table') ? $this->route('table')->id : null;
        return [
            'table_number' => 'required|string|unique:tables,table_number,' . $tableId,
            'capacity'     => 'required|integer|min:1',
            'status'       => 'required|in:available,occupied',
        ];
    }
}