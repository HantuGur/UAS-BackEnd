<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi secara massal (mass assignment)
    protected $fillable = [
        'customer_id',
        'total_price',
        'discount_amount',
        'promo_id',
        'status',
        'order_type',
        'table_id',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi ke promo/voucher yang digunakan pada pesanan ini
    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }

    // Relasi ke meja
    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }
}