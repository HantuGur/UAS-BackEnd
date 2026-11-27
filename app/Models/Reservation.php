<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'table_id', 'reservation_time', 'guests_count', 'status'];

    // Reservasi ini dibuat oleh satu pelanggan
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Reservasi ini untuk satu meja tertentu
    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}