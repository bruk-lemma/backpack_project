<?php

namespace App\Models;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class conversion_history extends Model
{
    use CrudTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'converted_from',
    //     'converted_to',
    // ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    
    protected $fillable = [
        'person_id',
        'converted_to',
        'converted_from',
        'user_id',
        
        
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
