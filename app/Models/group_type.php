<?php

namespace App\models;


use Backpack\CRUD\app\Models\Traits\CrudTrait;

use Illuminate\Database\Eloquent\Model;
   
class group_type extends Model
{
    use CrudTrait;

      public function groups()
    {
        return $this->hasMany(group::class);
    }
}
