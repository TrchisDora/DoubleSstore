<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'tbl_product'; 
    protected $primaryKey = 'product_id'; 
    protected $fillable = [
        'product_name', 
        'product_quantity', 
        'product_slug', 
        'product_price', 
        'product_image', 
        'category_id', 
        'brand_id', 
        'product_status'
    ];

    public $timestamps = true;

        // Model Product
    public function categoryProduct()
    {
        return $this->belongsTo(categoryProduct::class, 'category_id');
    }

    public function brandProduct()
    {
        return $this->belongsTo(BrandProduct::class, 'brand_id');
    }

}
