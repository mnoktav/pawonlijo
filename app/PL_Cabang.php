<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PL_Cabang extends Model
{
    protected $table = "pl_cabang";
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
