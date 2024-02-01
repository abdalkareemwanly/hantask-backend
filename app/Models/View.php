<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;
    protected $table = 'views';
    protected $guarded = [];
    public function post()
    {
        return $this->belongsTo(Post::class,'post_id');
    }
}
