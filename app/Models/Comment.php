<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $guarded = [];
    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id');
    }
    public function post()
    {
        return $this->belongsTo(Post::class,'post_id');
    }
    public function postApprove()
    {
        return $this->hasMany(PostApprov::class,'comment_id');
    }
}
