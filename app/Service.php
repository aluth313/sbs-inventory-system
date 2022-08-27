<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
 	protected $fillable = ['invoice', 'ttno', 'cust_id', 'tech_id', 'note','fak_no','do_no','po_no', 'total','created_at'];   //
}