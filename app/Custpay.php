<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Custpay extends Model
{
    protected $fillable = ['payment_no', 'service_id', 'customer_id', 'customer_name', 'nilai_pembayaran', 'description'];
}
