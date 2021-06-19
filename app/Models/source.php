<?php

namespace App\Models;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class source extends Model
{
    use CrudTrait;

    protected $fillable = [
        'source',
        
    ];
    public function people()
    {
     return $this->hasMany(person::class);
    }
}
