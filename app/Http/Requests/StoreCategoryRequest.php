<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'name'        => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string',
        ];
    }
    public function messages(): array {
        return [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique'   => 'Nama kategori sudah ada, gunakan nama lain.',
        ];
    }
}