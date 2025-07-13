<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\User;

class Order extends Model
{
    // Menentukan field yang boleh diisi secara massal
    // KOLOM BARU DITAMBAHKAN DI SINI
    protected $fillable = [
        'user_id', 
        'total_amount', 
        'status',
        'shipping_address', 
        'shipping_service', 
        'shipping_cost',
        'payment_proof', 
        'payment_status',
    ];

    // Relasi: Satu Order memiliki banyak OrderItem
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi: Satu Order dimiliki oleh satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
