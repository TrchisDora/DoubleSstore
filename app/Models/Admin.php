<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'tbl_admin'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'admin_id'; // Khóa chính của bảng
    protected $fillable = [
        'admin_email',
        'admin_password',
        'admin_name',
    ];
    
    public $timestamps = false; // Tắt timestamps nếu bảng không có created_at và updated_at
}
