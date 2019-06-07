<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PL_Transaksi extends Model
{
    protected $table = "pl_transaksi";
    protected $fillable = [
    	'id',
    	'subtotal',
    	'potongan',
        'total',
        'id_jenis_transaksi',
        'kode',
        'bayar',
        'kembali',
        'nama_pembeli',
        'status',
        'keterangan'
    ];
    public $timestamps = true;
    public $incrementing = false;
}
