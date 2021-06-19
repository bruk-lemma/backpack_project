<?php

namespace App\Models;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class person_call extends Model
{
    use CrudTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
        'call_purpose',
        'call_type',
        'call_detail',
        'call_desc',
        'call_result',
        'type',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'id' => 'integer',
    ];


    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
