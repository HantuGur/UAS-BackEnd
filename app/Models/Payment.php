<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'payment_method', 'amount',
        'cash_received', 'change_amount', 'status'
    ];

    // Setiap pembayaran merujuk ke satu pesanan
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
