<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_resets'; // Tên bảng
    protected $fillable = ['email', 'token', 'created_at']; // Các trường được phép gán
    public $timestamps = false; // Không sử dụng created_at, updated_at mặc định
}
