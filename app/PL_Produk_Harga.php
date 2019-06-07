<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PL_Produk_Harga extends Model
{
    protected $table = "pl_produk_harga";
    protected $fillable = [
    	'id',
    	'id_produk',
    	'id_jenis_transaksi',
    	'harga'
    ];
    public $timestamps = false;
}
