<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Payment_detail;
use App\Models\Order;


class payment extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','payment_amount','payment_date','delevery_cost'];
    
    public function Payment_details():HasMany {
        return $this->HasMany(Payment_detail::class,'Payment_id','id');
    }

    public function Orders():HasOne {
        return $this->HasOne(Order::class,'payment_id','id');
    }
}
