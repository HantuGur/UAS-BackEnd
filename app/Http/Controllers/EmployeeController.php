<?php
namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Branch;
use App\Http\Requests\StoreEmployeeRequest;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index() {
        $employees = Employee::with('branch')->latest()->get();
        return view('employees.index', compact('employees'));
    }
    public function create() {
        $branches = Branch::all();
        return view('employees.create', compact('branches'));
    }
    public function store(StoreEmployeeRequest $request) {
        $data = $request->validated();
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        Employee::create($data);
        return redirect()->route('employees.index')->with('success', 'Karyawan baru berhasil ditambahkan.');
    }
    public function edit(Employee $employee) {
        $branches = Branch::all();
        return view('employees.edit', compact('employee', 'branches'));
    }
    public function update(StoreEmployeeRequest $request, Employee $employee) {
        $data = $request->validated();
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $employee->update($data);
        return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }
    public function destroy(Employee $employee) {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}