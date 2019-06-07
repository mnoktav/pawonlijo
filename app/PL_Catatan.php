<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PL_Catatan extends Model
{
    protected $table = "pl_catatan";
    protected $fillable = [
    	'id',
    	'judul',
    	'pesan',
        'id_booth',
        'status'
    ];
    public $timestamps = true;
}
