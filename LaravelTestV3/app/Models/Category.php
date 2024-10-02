<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function Items():HasMany {
        return $this->HasMany(Product::class,'Category_id','id');
    }
}