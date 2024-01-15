<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostApprov extends Model
{
    use HasFactory;
    protected $table = 'post_approvs';
    protected $guarded = [];
    public function buyer()
    {
        return $this->belongsTo(User::class,'buyer_id');
    }
    public function post()
    {
        return $this->belongsTo(Post::class,'post_id');
    }
    public function comment()
    {
        return $this->belongsTo(Comment::class,'comment_id');
    }
    public function reports()
    {
        return $this->hasMany(Report::class,'postApprove_id');
    }
}
