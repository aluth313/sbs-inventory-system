<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['invoice', 'supplier_id', 'description', 'user_id', 'total'];
}
