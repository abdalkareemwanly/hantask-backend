<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCity extends Model
{
    use HasFactory;
    protected $table = 'service_cities';
    protected $guarded = [];
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
    public function serviceareas()
    {
        return $this->hasMany(ServiceArea::class,'service_city_id');
    }

}
