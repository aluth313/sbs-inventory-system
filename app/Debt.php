<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $fillable =['payment_no', 'id_purchase', 'nilai_pembayaran','description' ,'status'];
}