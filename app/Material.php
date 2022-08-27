<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['material_name', 'unit', 'description', 'b_price', 'kategori', 'stok'];
}
