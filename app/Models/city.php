<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class city extends Model
{
    use CrudTrait;

    protected $fillable = [
        'region_id',
        'city',
    ];
    public function people()
    {
     return $this->hasmany(person::class, 'person_id');
    }    
    public function region()
    {
        return $this->belongsTo(region::class, 'region_id');
    }
    // public function cities()
//     {
//      return $this->hasMany(city::class);
//     }
}
