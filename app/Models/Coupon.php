<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'tbl_coupon';

    // Thêm vào đây các trường mới để có thể lưu trữ chúng
    protected $fillable = [
        'coupon_name',
        'coupon_code',
        'coupon_type',
        'coupon_value',
        'coupon_time',
        'category_id',
        'status',
        'coupon_start_date',  // Thêm trường ngày bắt đầu
        'coupon_end_date',    // Thêm trường ngày kết thúc
    ];
    public $timestamps = false; // Tắt Eloquent timestamps
}
