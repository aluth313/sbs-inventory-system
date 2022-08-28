<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    protected $fillable = ['good_name', 'unit', 'description', 'co_number', 'colour', 'grade', 'hardness', 'b_price', 's_price','r_price', 'd_price', 'kategori', 'stok', 'foto'];
}
