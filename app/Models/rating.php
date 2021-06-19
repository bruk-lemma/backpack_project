<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class rating extends Model
{
    use CrudTrait;

    protected $fillable = [
        'rating',
        
    ];
    public function people()
    {
     return $this->hasMany(person::class);
    }
}
