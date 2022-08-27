<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['cost_date', 'cost_id', 'description', 'cost_value'];
}
