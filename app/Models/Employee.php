<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    // Password tidak ditampilkan dalam response
    protected $hidden = ['password'];

    protected $fillable = ['name', 'role', 'phone', 'username', 'password', 'branch_id'];

    // Setiap karyawan bekerja di satu cabang
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}