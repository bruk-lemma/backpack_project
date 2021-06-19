<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
class group extends Model
{
    use CrudTrait;
    protected $fillable = [
        'group_name',
      
    ];
    public function people()
        {
            return $this->belongsToMany(Person::class, 'group_people');
        }
    public function groups()
        {
            return $this->hasmany(group_person::class);
        }


}
