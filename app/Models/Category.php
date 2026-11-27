<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // Satu kategori bisa memiliki banyak menu (relasi menggunakan nama kategori)
    public function menus()
    {
        return $this->hasMany(Menu::class, 'category', 'name');
    }
}