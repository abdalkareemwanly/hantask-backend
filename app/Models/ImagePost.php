<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagePost extends Model
{
    use HasFactory;
    protected $table = 'image_posts';
    protected $guarded = [];
    public function post()
    {
        return $this->belongsTo(Post::class,'post_id');
    }
}
