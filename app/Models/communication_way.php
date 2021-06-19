<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
class communication_way extends Model
{
    protected $fillable = [
        'way',
      
    ];
    use CrudTrait;
    
    public function Communications()
    {
        return $this->hasmany(Communication::class);
    }

}
