<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class position extends Model
{
    //use HasFactory;
    use CrudTrait;
    protected $fillable = [

        'address-input',


    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function communication_type()
    {
        return $this->belongsTo(communication_type::class, 'communication_types_id');
    }
    public function communication_way()
    {
        return $this->belongsTo(communication_way::class, 'communication_ways_id');
    }
  public function getcasenumber()
{
    return $this->concatenateNom();
}

public function concatenateNom()
{
    return $this->typ . ' ' .'/' .' ' .$this->created_at->format('d M y') . ' ' .'/' .' ' . $this->id;
}
}
