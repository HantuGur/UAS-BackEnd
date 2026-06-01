<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model {
    use HasFactory;
    protected $fillable = ['code', 'discount_type', 'discount_amount', 'max_discount', 'is_public', 'expired_at', 'status'];
}