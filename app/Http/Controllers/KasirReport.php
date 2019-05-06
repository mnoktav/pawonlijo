<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PL_Transaksi;
use App\PL_Stok;
use App\PL_Detail;
use App\PL_Note;
use App\PL_Booth;
use App\Top_Product;
use Illuminate\Support\Facades\DB;

class KasirReport extends Controller
{
    public function __construct()
    {
        $this->middleware('cekstatus');

    }
    public function index()
    {
    	$id = session('login')['id_booth'];
        $ts = PL_Transaksi::whereDate('created_at',date('Y-m-d'))
                                ->where('id_booth', $id)
                                ->where('status',1)
                                ->count();
        $tb = PL_Transaksi::whereDate('created_at',date('Y-m-d'))
                                ->where('id_booth', $id)
                                ->where('status',0)
                                ->count();
        $total = PL_Transaksi::whereDate('created_at',date('Y-m-d'))
                                ->where('id_booth', $id)
                                ->where('status',1)
                                ->sum('total');

        $builder = Top_Product::query();
        $builder->select(DB::raw('sum(jumlah) as jumlah, nama_makanan, id_booth'));
		$builder->where('id_booth',session('login')['id_booth']);
		$jh = $builder->whereDate('created_at',date('Y-m-d'))
                            ->groupBy('nama_makanan')
                            ->orderBy('jumlah','desc')
                            ->get();

    	return view('kasir/report', [
    		'ts' => $ts,
            'tb' => $tb,
            'total' => $total,
            'jh' => $jh
    	]);
    }
}
