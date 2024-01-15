<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSeller extends Model
{
    use HasFactory;
    protected $table = 'notification_sellers';
    protected $guarded = [];
    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id');
    }
}
