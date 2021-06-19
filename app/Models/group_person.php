<?php

namespace App\Models;


use Backpack\CRUD\app\Models\Traits\CrudTrait;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
class group_person extends pivot
{
    use CrudTrait;

      public function group()
    {
        return $this->belongsTo(group::class);
    }
    public function person()
    {
        return $this->belongsTo(person::class);
    }
 

   
}
