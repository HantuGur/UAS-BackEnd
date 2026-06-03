<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'username' => 'nullable|string|max:255|unique:employees,username,' . ($this->employee ? $this->employee->id : 'NULL'),
            'password' => 'nullable|string|min:6',
            'branch_id' => 'nullable|integer'
        ];
    }
}