<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    protected $table ='cashes';
    protected $fillable = ['cash_number', 'trans_date', 'category', 'description', 'cash_value'];
}
