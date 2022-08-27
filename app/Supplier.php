<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['supplier_name', 'supplier_contact', 'supplier_address', 'supplier_city', 'supplier_phone', 'supplier_email', 'supplier_fax'];
}
