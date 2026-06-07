<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request) {
        $customers = Customer::all();
        if ($request->wantsJson()) return response()->json($customers);
        return view('customers.index', compact('customers'));
    }
    public function create(): View { return view('customers.create'); }
    public function store(StoreCustomerRequest $request) {
        $customer = Customer::create($request->validated());
        if ($request->wantsJson()) return response()->json($customer, 201);
        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil ditambahkan.');
    }
    public function show(Request $request, Customer $customer) {
        if ($request->wantsJson()) return response()->json($customer);
        return view('customers.show', compact('customer'));
    }
    public function edit(Customer $customer): View { return view('customers.edit', compact('customer')); }
    public function update(Request $request, Customer $customer) {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);
        $customer->update($validated);
        if ($request->wantsJson()) return response()->json($customer);
        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }
    public function destroy(Request $request, Customer $customer) {
        $customer->delete();
        if ($request->wantsJson()) return response()->json(['message' => 'Success']);
        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil dihapus.');
    }
}
// test commit json api
