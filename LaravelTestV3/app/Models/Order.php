<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Payment;
use App\Models\User;
use App\Models\Address;

class Order extends Model
{

    use HasFactory;
    protected $fillable = ['user_id','payment_id','address_id','order_date','total_price','order_ship_date'];
  
}