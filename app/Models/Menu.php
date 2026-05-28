<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model {
    use HasFactory;
    protected $fillable = ['name', 'price', 'category'];

    // Menghubungkan Menu ke tabel Order Items
    public function orderItems(): HasMany {
        return $this->hasMany(OrderItem::class);
    }
}