<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class OrderItem extends Model
{
    // Menentukan field yang boleh diisi secara massal
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    // Relasi: Satu OrderItem terhubung ke satu Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
