<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class subcity extends Model
{
    use CrudTrait;

    protected $fillable = [
        'region_id',
        'city_id',
        'subcity',
    ];
    // public function people()
    // {
    //  return $this->belongsToMany(person::class, 'person_addresses');
    // }
    public function people()
    {
     return $this->hasmany(person::class, 'person_id');
    }
    public function subcities()
    {
    return $this->hasmany(person_address::class);
    }
    public function region()
    {
        return $this->belongsTo(region::class);
    }
    // public function city()
    // {
    //     return $this->belongsTo(city::class);
    // }
}
