<?php

namespace Corewave\Subscription\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $table = 'subscription_plans';

    protected $fillable = ['product_id', 'duration', 'price', 'frequency'];

    public function product()
    {
        return $this->belongsTo(\Webkul\Product\Models\Product::class);
    }

}
