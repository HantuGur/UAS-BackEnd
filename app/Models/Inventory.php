<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';

    protected $fillable = ['item_name', 'stock_quantity', 'unit', 'supplier_id'];

    // Setiap bahan baku bersumber dari satu supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}