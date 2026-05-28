<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model {
    use HasFactory;
    protected $fillable = ['customer_id', 'total_price', 'status'];

    // Menghubungkan pesanan ke Customer
    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    // Menghubungkan pesanan ke detail items
    public function items(): HasMany {
        return $this->hasMany(OrderItem::class);
    }
}