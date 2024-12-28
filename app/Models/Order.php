<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'products',
        'total_amount',
        'payment_method', // Add the payment_method field
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}