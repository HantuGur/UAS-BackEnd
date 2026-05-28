<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller {
    public function index(): View {
        $orders = Order::with(['customer', 'items'])->orderBy('created_at', 'desc')->get();
        return view('orders.index', compact('orders'));
    }

    public function create(): View {
        $customers = Customer::all();
        $menus = Menu::all();
        return view('orders.create', compact('customers', 'menus'));
    }

    public function store(StoreOrderRequest $request): RedirectResponse {
        $validated = $request->validated();

        $order = DB::transaction(function () use ($validated) {
            // Buat Order Induk dengan total harga sementara 0
            $order = Order::create([
                'customer_id' => $validated['customer_id'],
                'total_price' => 0,
                'status'      => 'pending',
            ]);

            $totalPrice = 0;

            // Proses Item-item Rincian Pesanan
            foreach ($validated['items'] as $itemData) {
                if (empty($itemData['menu_id'])) {
                    continue;
                }

                $menu     = Menu::findOrFail($itemData['menu_id']);
                $subtotal = $menu->price * $itemData['quantity'];
                $totalPrice += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id'  => $menu->id,
                    'name'     => $menu->name,   // Snapshot nama menu
                    'price'    => $menu->price,  // Snapshot harga menu
                    'quantity' => $itemData['quantity'],
                ]);
            }

            // Update Total Harga Setelah Selesai Kalkulasi
            $order->update(['total_price' => $totalPrice]);
            return $order;
        });

        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat.');
    }

    public function show(Order $order): View {
        $order->load(['customer', 'items']);
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order): View {
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order): RedirectResponse {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,completed',
        ]);
        $order->update($validated);
        return redirect()->route('orders.show', $order)->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function destroy(Order $order): RedirectResponse {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }

    public function getByStatus(string $status): View {
        if (!in_array($status, ['pending', 'completed'])) {
            abort(404);
        }
        $orders = Order::where('status', $status)
            ->with(['customer', 'items'])
            ->orderBy('created_at', 'desc')
            ->get();
        $currentStatus = $status;
        return view('orders.index', compact('orders', 'currentStatus'));
    }
}