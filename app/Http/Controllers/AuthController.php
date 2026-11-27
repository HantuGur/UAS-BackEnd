<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
// Tampilkan form login customer
public function showCustomerLogin()
{
    if (session()->has('customer_id')) {
        return redirect()->route('customer.shop');
    }
    return view('auth.customer_login');
}

// Proses login / register customer secara otomatis
public function customerLogin(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
    ]);

    // Cari atau buat customer baru berdasarkan email
    $customer = Customer::where('email', $request->email)->first();

    if (!$customer) {
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);
    }

    // Set session login customer
    session([
        'customer_id' => $customer->id,
        'customer_name' => $customer->name,
        'customer_email' => $customer->email,
    ]);

    return redirect()->route('customer.shop')->with('success', 'Selamat datang, ' . $customer->name . '!');
}

// Tampilkan form login admin
public function showAdminLogin()
{
    if (session()->has('employee_id')) {
        return redirect()->route('orders.index');
    }
    return view('auth.admin_login');
}

// Proses login admin
public function adminLogin(Request $request)
{
    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    $employee = Employee::where('username', $request->username)->first();

    if (!$employee) {
        return back()->withErrors(['username' => 'Kredensial login admin tidak valid!'])->withInput();
    }

    // Verifikasi password dengan dukungan hash bcrypt dan fallback plain text
    $isPasswordCorrect = false;
    $dbPassword = $employee->password;
    if (str_starts_with($dbPassword, '$2y$') || str_starts_with($dbPassword, '$2a$') || str_starts_with($dbPassword, '$2b$')) {
        $isPasswordCorrect = Hash::check($request->password, $dbPassword);
    } else {
        $isPasswordCorrect = ($request->password === $dbPassword);
    }

    if (!$isPasswordCorrect) {
        return back()->withErrors(['username' => 'Kredensial login admin tidak valid!'])->withInput();
    }

    // Set session login admin
    session([
        'employee_id' => $employee->id,
        'employee_name' => $employee->name,
        'employee_role' => $employee->role,
    ]);

    return redirect()->route('orders.index')->with('success', 'Berhasil login sebagai ' . $employee->name . ' (' . ucfirst($employee->role) . ')');
}

// Proses logout
public function logout(Request $request)
{
    if ($request->type === 'admin') {
        session()->forget(['employee_id', 'employee_name', 'employee_role']);
        return redirect()->route('admin.login')->with('success', 'Berhasil keluar dari panel admin.');
    }

    session()->forget(['customer_id', 'customer_name', 'customer_email']);
    return redirect()->route('customer.login')->with('success', 'Berhasil keluar.');
}
}