<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PL_Product;
use App\PL_Transaksi;
use App\PL_Stok;
use App\PL_Detail;
use App\PL_Booth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class AdminReport extends Controller
{
    public function index(Request $request)
    {
    	$booths = PL_Booth::all();
    	$sales = null;
    	$detail = PL_Detail::join('pl_produk', 'pl_produk.id', '=', 'pl_detail_transaksi.id_produk')
    						->select('pl_detail_transaksi.*','pl_produk.nama_makanan')
    						->get();

    	if(!empty($request->cari)){
    		if(empty($request->akhir)){
    		$sales = PL_Transaksi::where('status',1)
    						->where('id_booth','like','%'.$request->id_booth.'%')
    						->whereDate('created_at', date('Y-m-d', strtotime($request->awal)))
    						->paginate(5)
    						->appends(Input::except('page'));
	    	}
	    	else{
	    		$sales = PL_Transaksi::where('status',1)
	    						->where('id_booth','like','%'.$request->id_booth.'%')
	    						->whereDate('created_at','>=', date('Y-m-d', strtotime($request->awal)))
	    						->whereDate('created_at','<=',date('Y-m-d', strtotime($request->akhir)))
	    						->paginate(5)
	    						->appends(Input::except('page'));
	    	}
    	}
    	
    	
    	return view('admin/report', [
    		'booths' => $booths,
    		'sales' => $sales,
    		'detail' => $detail
    	]);
    }
}
