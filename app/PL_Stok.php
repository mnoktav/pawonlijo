<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PL_Stok extends Model
{
    protected $table = "pl_stok";
    protected $fillable = [
    	'id',
    	'total_stok',
    	'sisa_stok',
        'id_produk',
        'id_booth'
    ];
    public $timestamps = true;
}
