<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PL_Transaksi_Jenis extends Model
{
    protected $table = "pl_transaksi_jenis";
    protected $fillable = [
    	'id',
    	'jenis_transaksi',
        'pajak',
        'status',
        'id_booth'
    ];
    public $timestamps = false;
}
