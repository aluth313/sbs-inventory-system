<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    
    protected $fillable = ['customer_name', 'customer_address', 'jenis_kelamin', 'customer_phone', 'customer_foto'];
}
