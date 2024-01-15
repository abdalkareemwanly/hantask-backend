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
    public function posts()
    {
        return $this->hasMany(Post::class,'buyer_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class,'seller_id');
    }
    public function reports()
    {
        return $this->hasMany(Report::class,'seller_id');
    }
    public function postApprovs()
    {
        return $this->hasMany(PostApprov::class,'buyer_id');
    }
    public function profileVerify()
    {
        return $this->hasMany(ProfileVerify::class,'seller_id');
    }
    public function notification_sellers()
    {
        return $this->hasMany(NotificationSeller::class,'seller_id');
    }
    public function notification_buyers()
    {
        return $this->hasMany(NotificationBuyer::class,'buyer_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class,'buyer_id');
    }
}
