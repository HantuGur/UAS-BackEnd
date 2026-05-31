<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model {
    use HasFactory;
    protected $hidden = ['password'];
    protected $fillable = ['name', 'role', 'phone', 'username', 'password', 'branch_id'];

    public function branch() {
        return $this->belongsTo(Branch::class);
    }
}