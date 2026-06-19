<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'menu_id', 'rating', 'comment'];

    // Ulasan ini ditulis oleh satu pelanggan
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Ulasan ini untuk satu menu makanan
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}