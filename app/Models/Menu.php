<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi secara massal (mass assignment)
    protected $fillable = [
        'name',
        'price',
        'category',
    ];

    /**
     * Mendapatkan semua item pesanan (order items) yang terasosiasi dengan menu ini.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Mendapatkan kategori terasosiasi dengan menu ini.
     */
    public function categoryRelation()
    {
        return $this->belongsTo(Category::class, 'category', 'name');
    }
}