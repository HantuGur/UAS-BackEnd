<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'menu_id', 'quantity', 'note'];

    // Satu item keranjang dimiliki oleh satu pelanggan
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Satu item keranjang merujuk ke satu menu
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}