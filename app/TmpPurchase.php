<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmpPurchase extends Model
{
    protected $table = 'purchase_tmp';

    protected $fillable = ['item_cd', 'item_unit', 'item_price', 'quantity', 'item_total'];
}
