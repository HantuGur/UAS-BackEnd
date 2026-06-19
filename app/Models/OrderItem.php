<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi secara massal (mass assignment)
    protected $fillable = [
        'order_id',
        'menu_id',
        'name',
        'price',
        'quantity',
        'note',
    ];

    /**
     * Mendapatkan data pesanan utama (order) dari item rincian ini.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Mendapatkan data menu asal yang terasosiasi dengan item pesanan ini.
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}