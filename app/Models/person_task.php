<?php

namespace App\Models;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class person_task extends Model
{
    
use CrudTrait;
protected $fillable = [
    'task_name',
    'user_id',
    'person_id',
    'due_date',
    'task_desc',
    'priority',
    'repeat',
    'user_id',
    'person_id',
    'type_id',
    
];

public function person()
{
    return $this->belongsTo(Person::class, 'person_id', 'id');
}
// public function type()
// {
//     return $this->belongsTo(Person::class);
// }
public function user()
{
    return $this->belongsTo(User::class);
}
}

