<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $table = 'tbl_shipping'; // Tên bảng trong cơ sở dữ liệu

    protected $fillable = [
        'shipping_name',
        'shipping_phone',
        'shipping_email',
        'shipping_notes',
        'shipping_method',
        'shipping_address',
    ];
}
