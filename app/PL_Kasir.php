<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PL_Kasir extends Model
{
    protected $table = "pl_kasir";
    protected $fillable = [
    	'id',
    	'nama_kasir',
        'alamat_kasir',
        'telp_kasir',
        'id_booth'
    ];
    public $timestamps = true;
}
