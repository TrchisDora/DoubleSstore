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

<<<<<<< HEAD
    // Định nghĩa quan hệ nếu cần thiết
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }
=======
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'shipping_id', 'id');
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_code', 'order_code');
    }

    public function isAvailable()
    {
        foreach ($this->orderDetails as $detail) {
            $product = Product::find($detail->product_id);

            if (!$product || $product->product_quantity < $detail->product_sales_quantity) {
                return false; 
            }
        }
        return true; 
        
    }
    public function getTotalAmountAttribute()
    {
        $total = 0;
    
        foreach ($this->orderDetails as $detail) {
            $total += $detail->product_price * $detail->product_sales_quantity;
        }
    
        return $total;
    }
    
>>>>>>> d97843cdb195b8e1c481d724187343e9507331a5
}
