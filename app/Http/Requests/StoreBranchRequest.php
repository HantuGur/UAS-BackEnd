<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreBranchRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'name'    => 'required|string|max:255',
            'address' => 'required|string',
            'phone'   => 'nullable|string|max:20',
        ];
    }
}