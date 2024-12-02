<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandProduct extends Model
{
    protected $table = 'tbl_brand'; 
    protected $primaryKey = 'brand_id'; 

    protected $fillable = [
        'brand_name',     
        'brand_slug',     
        'brand_desc',      
        'brand_status',   
    ];

    public $timestamps = true; 
    // Quan hệ với Product
    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }
}