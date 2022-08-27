<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    protected $fillable = ['good_name', 'unit', 'description', 'b_price', 's_price','r_price', 'd_price', 'kategori', 'stok', 'foto'];
}
