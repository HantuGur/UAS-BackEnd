<?php
namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showCustomerLogin() {
        if (session()->has('customer_id')) return redirect()->route('customer.shop');
        return view('auth.customer_login');
    }
    public function customerLogin(Request $request) {
        $request->validate(['name' => 'required|string|max:255', 'email' => 'required|email|max:255']);
        $customer = Customer::where('email', $request->email)->first();
        if (!$customer) {
            $customer = Customer::create(['name' => $request->name, 'email' => $request->email]);
        }
        session(['customer_id' => $customer->id, 'customer_name' => $customer->name, 'customer_email' => $customer->email]);
        return redirect()->route('customer.shop')->with('success', 'Selamat datang, ' . $customer->name . '!');
    }
    public function showAdminLogin() {
        if (session()->has('employee_id')) return redirect()->route('orders.index');
        return view('auth.admin_login');
    }
    public function adminLogin(Request $request) {
        $request->validate(['username' => 'required|string', 'password' => 'required|string']);
        $employee = Employee::where('username', $request->username)->first();
        if (!$employee) return back()->withErrors(['username' => 'Kredensial login admin tidak valid!'])->withInput();

        $dbPassword = $employee->password;
        $isPasswordCorrect = (str_starts_with($dbPassword, '$2y$') || str_starts_with($dbPassword, '$2a$'))
            ? Hash::check($request->password, $dbPassword)
            : ($request->password === $dbPassword);

        if (!$isPasswordCorrect) return back()->withErrors(['username' => 'Kredensial login admin tidak valid!'])->withInput();
        session(['employee_id' => $employee->id, 'employee_name' => $employee->name, 'employee_role' => $employee->role]);
        return redirect()->route('orders.index')->with('success', 'Berhasil login sebagai ' . $employee->name);
    }
    public function logout(Request $request) {
        if ($request->type === 'admin') {
            session()->forget(['employee_id', 'employee_name', 'employee_role']);
            return redirect()->route('admin.login')->with('success', 'Berhasil keluar dari panel admin.');
        }
        session()->forget(['customer_id', 'customer_name', 'customer_email']);
        return redirect()->route('customer.login')->with('success', 'Berhasil keluar.');
    }
}