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
        'product_status',
        'product_prominent', // Thêm vào đây
        'product_desc',      // Thêm trường này nếu có trong bảng
        'product_content'    // Thêm trường này nếu có trong bảng
    ];

    public $timestamps = true;

    public function categoryProduct()
    {
        return $this->belongsTo(CategoryProduct::class, 'category_id');
    }

    public function brandProduct()
    {
        return $this->belongsTo(BrandProduct::class, 'brand_id');
    }
}
