<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PL_Pajak extends Model
{
    protected $table = "pl_pajak";
    protected $fillable = [
    	'id',
    	'id_transaksi',
    	'jenis_transaksi',
        'pajak',
        'total_pajak'
    ];
    public $timestamps = false;
}
