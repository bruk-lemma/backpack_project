<?php

namespace App\Models;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class status extends Model
{
    use CrudTrait;

    protected $fillable = [
        'status',
        
    ];
    public function people()
    {
     return $this->hasMany(person::class);
    }
}
