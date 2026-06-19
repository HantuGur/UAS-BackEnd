<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    // Eksplisit nama tabel agar tidak ada ambiguitas
    protected $table = 'feedbacks';

    protected $fillable = ['customer_id', 'subject', 'message'];

    // Feedback bisa dikirim oleh seorang pelanggan (atau anonim)
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}