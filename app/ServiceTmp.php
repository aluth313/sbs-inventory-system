<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ServiceTmp extends Model
{
    protected $table = "service_tmp";
    protected $fillable = ['kategori', 'item_cd', 'item_name', 'uom', 'quantity', 'price', 'total'];
}
