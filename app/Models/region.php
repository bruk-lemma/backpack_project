<?php

namespace App\Models;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class region extends Model
{
    use CrudTrait;
    protected $fillable = [
        'region',
    ];
    public function people()
    {
     return $this->hasmany(person::class, 'person_id');
    }
    public function cities()
    {
     return $this->hasMany(city::class);
    }
    
    public function subcities()
    {
     return $this->hasMany(subcity::class);
    }
}
