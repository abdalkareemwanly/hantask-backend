<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $table = 'chats';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'recipient_id');
    }
}
