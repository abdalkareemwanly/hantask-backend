<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table = 'countries';
    protected $guarded = [];
    public function user()
    {
        return $this->hasMany(User::class,'country_id');
    }
    public function servicecities()
    {
        return $this->hasMany(ServiceCity::class,'country_id');
    }
    public function serviceareas()
    {
        return $this->hasMany(ServiceArea::class,'country_id');
    }
    public function taxs()
    {
        return $this->hasMany(Tax::class,'country_id');
    }
    public function buyerJobs()
    {
        return $this->hasMany(BuyerJob::class,'country_id');
    }
    public function posts()
    {
        return $this->hasMany(Post::class,'country_id');
    }
}
