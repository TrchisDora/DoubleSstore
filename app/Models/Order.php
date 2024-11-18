<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'tbl_order';

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'customer_id',
        'shipping_id',
        'order_status',
        'order_code',
        'created_at',
        'updated_at'
    ];

    // Định nghĩa quan hệ nếu cần thiết
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }
}
