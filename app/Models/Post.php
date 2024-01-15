<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $guarded = [];
    public function buyer()
    {
        return $this->belongsTo(User::class,'buyer_id');
    }
    public function images()
    {
        return $this->hasMany(ImagePost::class,'post_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class,'post_id');
    }

    public function postApprovs()
    {
        return $this->hasMany(PostApprov::class,'post_id');
    }
}
