<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $table = 'subscriptions';
    protected $guarded = [];

    public function seller_subscriptions()
    {
        return $this->hasMany(sellerSubscription::class,'subscription_id');
    }
}
