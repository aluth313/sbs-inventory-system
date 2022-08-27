<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    protected $fillable = ['production_number', 'description', 'user_id', 'total'];
}
