<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;

use Illuminate\Database\Eloquent\Model;

class person_address extends Model
{
    protected $fillable = [
        'person_id',
        'region',
        'city',
        'subcity',
        'locaton_pin',
  
    ];
    protected $casts = [
        // 'region' => 'array', 
        // 'city' => 'array', 
        // 'subcity'=> 'array',
        // 'location_pin' => 'array',
           
    ];
  
use CrudTrait;

public function person()
{
    return $this->belongsTo(person::class);
}
public function city()
{
    return $this->belongsTo(city::class);
}
public function region()
{
    return $this->belongsTo(region::class);
}
public function subcity()
{
    return $this->belongsTo(subcity::class);
}
}
