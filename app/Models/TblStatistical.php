<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblStatistical extends Model
{
    use HasFactory;

    // Đặt tên bảng tương ứng
    protected $table = 'tbl_statistical';

    // Nếu bạn sử dụng các trường tự động cập nhật timestamp, tắt trường này đi
    public $timestamps = false;

    // Đặt các trường có thể gán hàng loạt
    protected $fillable = [
        'order_date',
        'sales',
        'profit',
        'quantity',
        'total_order'
    ];

    // Đặt khóa chính nếu khác khóa chính mặc định (id)
    protected $primaryKey = 'id_statistical';

    // Nếu khóa chính là auto increment, không cần khai báo thêm gì
    protected $keyType = 'int';
}
