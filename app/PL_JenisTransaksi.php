<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PL_JenisTransaksi extends Model
{
    protected $table = "pl_jenis_transaksi";
    protected $fillable = [
    	'id',
    	'jenis_transaksi',
        'pajak',
        'status',
        'id_booth'
    ];
    public $timestamps = false;
}
