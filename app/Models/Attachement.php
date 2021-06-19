<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Attachement extends Model
{
    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
