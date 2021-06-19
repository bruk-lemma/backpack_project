<?php

namespace App\Models;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class personlandline extends Person
{
    public function getcompany()
    {
        return $this->attributes['id'];
    }

    
}
