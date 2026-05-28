<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller {
    public function index(): View {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }
    public function create(): View {
        return view('customers.create');
    }
    public function store(StoreCustomerRequest $request): RedirectResponse {
        Customer::create($request->validated());
        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil ditambahkan.');
    }
    public function show(Customer $customer): View {
        return view('customers.show', compact('customer'));
    }
    public function edit(Customer $customer): View {
        return view('customers.edit', compact('customer'));
    }
    public function update(Request $request, Customer $customer): RedirectResponse {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);
        $customer->update($validated);
        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }
    public function destroy(Customer $customer): RedirectResponse {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil dihapus.');
    }
}