<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class type extends Model
{
    use CrudTrait;

    protected $fillable = [
        'type',
    ];

    public function people()
    {
     return $this->hasmany(person::class, 'person_id');
    }
    public function person_task()
    {
     return $this->hasmany(person_task::class, 'person_id');
    }

}
