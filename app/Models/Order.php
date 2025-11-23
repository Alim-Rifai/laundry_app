<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name', 'phone', 'service_id',
        'weight', 'status', 'payment_status'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // accessor untuk total price
    public function getTotalPriceAttribute()
    {
        if (!$this->service) return 0;
        return $this->weight * $this->service->price_per_kg;
    }
}
