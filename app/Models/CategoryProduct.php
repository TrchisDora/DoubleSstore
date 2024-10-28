<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    
    protected $table = 'tbl_category_product'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'category_id'; // Khóa chính của bảng
    protected $fillable = [
        'meta_keywords',
        'category_name',
        'slug_category_product',
        'category_desc',
        'category_status',
        'category_icon_admin',
        'category_icon_user',
    ];

    public $timestamps = true; // Laravel sẽ tự động thêm và cập nhật created_at và updated_at
}
