<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    // 'Table' adalah reserved word PHP, eksplisit nama tabel diperlukan
    protected $table = 'tables';

    protected $fillable = ['table_number', 'capacity', 'status'];

    // Satu meja bisa punya banyak riwayat reservasi
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
