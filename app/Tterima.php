<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tterima extends Model
{
    protected $table = "tanda_terima";
    protected $fillable= ['ttno','cust_id', 'item_name', 'tipe', 'sn', 'keterangan', 'keluhan', 'kelengkapan', 'estimasi_selesai'];
}
