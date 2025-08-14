<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'razorpay_plan_id',
        'price',
        'limit',
        'currency',
        'duration'
    ];

    public function subscriptions() {
        return $this->hasMany(Subscription::class);
    }
}
