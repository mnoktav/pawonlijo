<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PL_Note extends Model
{
    protected $table = "pl_note";
    protected $fillable = [
    	'id',
    	'judul',
    	'pesan',
        'id_booth',
        'status'
    ];
    public $timestamps = true;
}
