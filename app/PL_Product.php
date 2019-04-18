<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PL_Product extends Model
{
    protected $table = "pl_produk";
    protected $fillable = [
    	'id',
    	'nama_makanan',
    	'kategori',
        'harga_reguler',
        'harga_gojek',
        'harga_grab',
        'gambar',
        'id_booth',
        'status'
    ];
    public $timestamps = true;
}
