<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuoteTmp extends Model
{
    protected $table = 'quote_tmp';

    protected $fillable = ['description', 'quantity', 'uom', 'price', 'total'];
}
