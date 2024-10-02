<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Payment_detail;
use App\Models\Order_item;
use App\Models\Shopping_cart;
use App\Models\rating;


class Product extends Model
{
    use HasFactory;
    Protected $fillable  = ['category_id','name','category_name','price','product_image','description','is_discount','discount'];
    public function Payment_details():HasMany {
        return $this->HasMany(Category::class,'product_id','id');
    }
   
    public function Order_products():HasMany {
        return $this->HasMany(Order_item::class,'product_id','id');
    }
    public function Shopping_carts():HasMany {
        return $this->HasMany(Shopping_cart::class,'product_id','id');
    }
}