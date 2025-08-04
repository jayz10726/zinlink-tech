<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'address', 'city', 'postal_code',
        'status', 'subtotal', 'tax', 'shipping', 'total', 'payment_method', 'payment_status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
