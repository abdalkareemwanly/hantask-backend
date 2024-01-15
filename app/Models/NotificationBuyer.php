<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationBuyer extends Model
{
    use HasFactory;
    protected $table = 'notification_buyers';
    protected $guarded = [];
    public function buyer()
    {
        return $this->belongsTo(User::class,'buyer_id');
    }
}
