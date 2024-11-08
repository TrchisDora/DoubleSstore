<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'tbl_customers';
    protected $primaryKey = 'customer_id';


    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_password',
        'customer_phone',
    ];


    public $timestamps = true;


    public static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
          
            $customer->customer_password = bcrypt($customer->customer_password);
        });
    }
}
