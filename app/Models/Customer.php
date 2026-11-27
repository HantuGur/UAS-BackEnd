<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi secara massal (mass assignment)
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * Mendapatkan semua order/pesanan yang dimiliki oleh customer ini.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}