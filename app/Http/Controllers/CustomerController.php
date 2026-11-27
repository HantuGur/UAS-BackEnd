<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Menampilkan daftar semua customer.
     */
    public function index(Request $request)
    {
        $customers = Customer::all();
        if ($request->wantsJson()) {
            return response()->json($customers);
        }
        return view('customer.index', compact('customers'));
    }

    /**
     * Menampilkan form untuk membuat customer baru.
     */
    public function create(): View
    {
        return view('customer.create');
    }

    /**
     * Menyimpan data customer baru ke database.
     */
    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->validated());

        if ($request->wantsJson()) {
            return response()->json($customer, 201);
        }

        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil ditambahkan.');
    }

    /**
     * Menampilkan rincian customer tertentu.
     */
    public function show(Request $request, Customer $customer)
    {
        if ($request->wantsJson()) {
            return response()->json($customer);
        }
        return view('customer.show', compact('customer'));
    }

    /**
     * Menampilkan form untuk mengubah data customer.
     */
    public function edit(Customer $customer): View
    {
        return view('customer.edit', compact('customer'));
    }

    /**
     * Memperbarui data customer di database.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $customer->update($validated);

        if ($request->wantsJson()) {
            return response()->json($customer);
        }

        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    /**
     * Menghapus data customer dari database.
     */
    public function destroy(Request $request, Customer $customer)
    {
        $customer->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Success']);
        }

        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil dihapus.');
    }
}
