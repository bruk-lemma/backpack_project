<?php

namespace App\Models;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class person_meeting extends Model
{
    use CrudTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'person_id',
        'location',
        'start_date',
        'due_date',
        'participant',
        'all_day',
        'desciption',
        'type',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'id' => 'integer',
    // ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

