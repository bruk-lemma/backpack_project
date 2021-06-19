<?php

namespace App\Models;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class personphone extends Person
{
    public function getcompany()
    {
        return $this->attributes['id'];
    }

    
}
