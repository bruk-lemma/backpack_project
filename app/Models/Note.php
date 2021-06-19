<?php

namespace  App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;

    protected $fillable = [
        'user_id',
        'person_id',
        'descrription',
      
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
