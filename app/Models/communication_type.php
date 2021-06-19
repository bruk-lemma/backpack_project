<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
class communication_type extends Model
{
    protected $fillable = [
        'type',
      
    ];
    use CrudTrait;
    
    public function Communications()
    {
        return $this->hasmany(Communication::class);
    }
}
