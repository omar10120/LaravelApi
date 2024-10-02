<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Product;
use App\Models\Payment;
use App\Models\User;


class Payment_detail extends Model
{
    use HasFactory;
   protected $fillable = ['user_id','product_id','payment_id'];
}
