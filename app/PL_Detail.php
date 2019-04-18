<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PL_Detail extends Model
{
    protected $table = "pl_detail_transaksi";
    protected $fillable = [
    	'id',
    	'id_transaksi',
    	'id_produk',
        'harga_satuan',
        'jumlah'
    ];
    public $timestamps = true;
}
