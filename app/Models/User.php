<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    use Notifiable; // Sử dụng trait Notifiable để gửi thông báo

    protected $table = 'users'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'id'; // Khóa chính mặc định là 'id'

    // Cột được phép gán giá trị
    protected $fillable = [
        'name', 
        'email', 
        'password',
    ];

    // Tự động quản lý timestamps (created_at và updated_at)
    public $timestamps = true;

    // Mã hóa mật khẩu khi lưu vào cơ sở dữ liệu
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password); // Mã hóa mật khẩu
    }
}
