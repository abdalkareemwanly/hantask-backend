<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;
class User extends Authenticatable
{
    use HasFactory,HasApiTokens,Notifiable,Billable;
    protected $table = 'users';
    protected $guarded = [];

    public function services()
    {
        return $this->hasMany(Service::class,'seller_id');
    }
    public function seller_subscriptions()
    {
        return $this->hasMany(sellerSubscription::class,'seller_id');
    }
    public function chats()
    {
        return $this->hasMany(Chat::class,'recipient_id');
    }
    public function buyerJobs()
    {
        return $this->hasMany(BuyerJob::class,'buyer_id');
    }
    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class,'user_id');
    }
    public function routeNotificationForFcm($notification = null)
    {
        return $this->deviceTokens()->pluck('token')->toArray();
    }
}
