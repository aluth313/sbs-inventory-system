<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teknisi extends Model
{
    protected $table ='teknisi';

    protected $fillable = ['nama', 'alamat', 'jenis_kelamin', 'tgl_lahir', 'hp', 'no_ktp','password', 'foto'];
}
