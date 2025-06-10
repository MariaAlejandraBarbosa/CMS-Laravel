<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'products_stock';
    protected $hidden = ['created_at', 'update_at'];

    public function getProduct(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function getVariants(){
        return $this->hasMany(Variant::class, 'stock_id', 'id');
    }
}
