<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Order;

class Address extends Model
{
    use HasFactory;
    protected $fillable = ['first_name','last_name','phone','city','details','adress','user_id'];
    public function Orders():HasMany {
        return $this->HasMany(Order::class,'Address_id','id');
    }
}