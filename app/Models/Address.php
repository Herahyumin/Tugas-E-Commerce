<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Menyesuaikan dengan nama kolom di database.
     */
    protected $fillable = [
        'user_id', 
        'label', 
        'recipient_name', 
        'phone_number', 
        'full_address', 
        'province',    // <-- DIUBAH DI SINI (sebelumnya province_id)
        'city',        // <-- DIUBAH DI SINI (sebelumnya city_id)
        'postal_code', 
        'is_default'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
