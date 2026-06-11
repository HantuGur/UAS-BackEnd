<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'branch_id' => 'required|exists:branches,id',
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|max:100|unique:employees,username',
            'password'  => 'required|string|min:6',
            'role'      => 'required|in:admin,kasir,manager',
        ];
    }
    public function messages(): array {
        return [
            'username.unique'   => 'Username sudah digunakan oleh karyawan lain.',
            'password.min'      => 'Password minimal 6 karakter.',
            'branch_id.exists'  => 'Cabang yang dipilih tidak ditemukan.',
        ];
    }
}