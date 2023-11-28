<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sellerSubscription extends Model
{
    use HasFactory;
    protected $table = 'seller_subscriptions';
    protected $guarded = [];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class,'subscription_id');
    }
    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id');
    }
}
