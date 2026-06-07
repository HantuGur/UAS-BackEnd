<?php
namespace App\Http\Controllers;
use App\Models\Reservation;
use App\Models\Customer;
use App\Models\Table;
use App\Http\Requests\StoreReservationRequest;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index() {
        $reservations = Reservation::with(['customer', 'table'])->latest()->get();
        return view('reservations.index', compact('reservations'));
    }
    public function create() {
        $customers = Customer::all();
        $tables = Table::where('status', 'available')->get();
        return view('reservations.create', compact('customers', 'tables'));
    }
    public function store(StoreReservationRequest $request) {
        \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
            $data = $request->validated();
            $data['status'] = 'approved';
            Reservation::create($data);
            Table::find($request->table_id)?->update(['status' => 'occupied']);
        });
        return redirect()->route('reservations.index')->with('success', 'Reservasi berhasil dibuat dan langsung disetujui.');
    }
    public function edit(Reservation $reservation) {
        $customers = Customer::all();
        $tables = Table::all();
        return view('reservations.edit', compact('reservation', 'customers', 'tables'));
    }
    public function update(Request $request, Reservation $reservation) {
        $validated = $request->validate([
            'customer_id'      => 'required|exists:customers,id',
            'table_id'         => 'required|exists:tables,id',
            'reservation_time' => 'required|date',
            'guests_count'     => 'required|integer|min:1',
            'status'           => 'required|string|in:approved,cancelled',
        ]);
        \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $reservation) {
            $oldTableId = $reservation->table_id;
            $oldStatus  = $reservation->status;
            $reservation->update($validated);
            if ($oldStatus === 'approved') {
                Table::find($oldTableId)?->update(['status' => 'available']);
            }
            if ($validated['status'] === 'approved') {
                Table::find($validated['table_id'])?->update(['status' => 'occupied']);
            } else {
                Table::find($validated['table_id'])?->update(['status' => 'available']);
            }
        });
        return redirect()->route('reservations.index')->with('success', 'Reservasi berhasil diperbarui.');
    }
    public function destroy(Reservation $reservation) {
        \Illuminate\Support\Facades\DB::transaction(function () use ($reservation) {
            if ($reservation->status === 'approved') {
                Table::find($reservation->table_id)?->update(['status' => 'available']);
            }
            $reservation->delete();
        });
        return redirect()->route('reservations.index')->with('success', 'Reservasi berhasil dihapus.');
    }
}