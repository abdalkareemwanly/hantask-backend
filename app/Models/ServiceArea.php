<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceArea extends Model
{
    use HasFactory;
    protected $table = 'service_areas';
    protected $guarded = [];
    public function serviceareas()
    {
        return $this->belongsTo(ServiceCity::class,'service_city_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

}
