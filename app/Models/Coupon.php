<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'tbl_coupon'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'coupon_id'; // Khóa chính là coupon_id

    public $timestamps = false; // Tắt timestamps nếu không có trường created_at và updated_at

    // Các cột có thể mass assign
    protected $fillable = [
        'coupon_name',
        'coupon_time',
        'coupon_condition',
        'coupon_number',
        'coupon_code',
        'coupon_start_date',
        'coupon_end_date',
    ];

    // Nếu cần thiết, có thể chỉ định kiểu dữ liệu cho một số trường
    protected $casts = [
        'coupon_start_date' => 'date',
        'coupon_end_date' => 'date',
        'coupon_condition' => 'integer',
    ];
}
