<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Branch;
use App\Http\Requests\StoreEmployeeRequest;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    // Menampilkan daftar semua karyawan beserta cabangnya
    public function index()
    {
        $employees = Employee::with('branch')->latest()->get();
        return view('employees.index', compact('employees'));
    }

    // Form tambah karyawan baru
    public function create()
    {
        $branches = Branch::all();
        return view('employees.create', compact('branches'));
    }

    // Simpan karyawan baru, password di-hash untuk keamanan
    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->validated();
        $data['role'] = strtolower($data['role']);
        $data['phone'] = $data['phone'] ?? '-';
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']); // enkripsi password sebelum disimpan
        }
        Employee::create($data);
        return redirect()->route('employees.index')->with('success', 'Karyawan baru berhasil ditambahkan.');
    }

    // Form edit karyawan
    public function edit(Employee $employee)
    {
        $branches = Branch::all();
        return view('employees.edit', compact('employee', 'branches'));
    }

    // Update data karyawan, password hanya diupdate jika diisi
    public function update(StoreEmployeeRequest $request, Employee $employee)
    {
        $data = $request->validated();
        $data['role'] = strtolower($data['role']);
        $data['phone'] = $data['phone'] ?? '-';
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // abaikan password jika dikosongkan
        }
        $employee->update($data);
        return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    // Hapus karyawan dari sistem
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}