<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    // Assuming the table name is 'cart_items'
    protected $table = 'cart_items'; 
    
    // Define the fillable attributes (to mass-assign data)
    protected $fillable = ['user_id', 'product_id', 'quantity', 'price'];

    // Define the relationship to the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Define the relationship to the User model (if applicable)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
