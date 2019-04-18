<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PL_Booth extends Model
{
    protected $table = "pl_booth";
    protected $fillable = [
    	'id_booth',
        'nama_booth',
        'alamat_booth',
        'kota_booth',
        'jam_buka',
        'jam_tutup',
        'telepon_booth',
        'username_booth',
        'password_booth',
        'status'
    ];
    public $timestamps = true;
}
