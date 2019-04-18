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
        'jenis',
        'kode',
        'bayar',
        'kembali',
        'nama_pembeli',
        'status',
        'id_booth',
        'keterangan'
    ];
    public $timestamps = true;
    public $incrementing = false;
}
