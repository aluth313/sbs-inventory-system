<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmpProduction extends Model
{
    protected $table = 'production_tmp';

    protected $fillable = ['item_cd', 'item_unit', 'item_price', 'quantity', 'item_total'];
}
