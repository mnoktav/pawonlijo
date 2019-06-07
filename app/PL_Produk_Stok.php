<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PL_Produk_Stok extends Model
{
    protected $table = "pl_produk_stok";
    protected $fillable = [
    	'id',
    	'total_stok',
    	'sisa_stok',
        'id_produk'
    ];
    public $timestamps = true;
}
