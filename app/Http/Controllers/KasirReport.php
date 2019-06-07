<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\View_Transaksi;
use App\PL_Produk_Stok;
use App\PL_Transaksi_Detail;
use App\PL_Transaksi_Jenis;
use App\PL_Cabang;
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
        $ts = View_Transaksi::whereDate('created_at',date('Y-m-d'))
                                ->where('id_booth', $id)
                                ->where('status',1)
                                ->count();
        $tb = View_Transaksi::whereDate('created_at',date('Y-m-d'))
                                ->where('id_booth', $id)
                                ->where('status',0)
                                ->count();
        $total = View_Transaksi::whereDate('created_at',date('Y-m-d'))
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

        $jenis = PL_Transaksi_Jenis::groupBy('jenis_transaksi')->get();
        $jt =  View_Transaksi::select(DB::raw('count(id) as jumlah, jenis'))
                            ->whereDate('created_at',date('Y-m-d'))
                            ->where('status',1)
                            ->where('id_booth', $id)
                            ->groupBy('jenis')
                            ->get();


    	return view('kasir/report', [
    		'ts' => $ts,
            'tb' => $tb,
            'total' => $total,
            'jh' => $jh,
            'jenis' => $jenis,
            'jt' => $jt
    	]);
    }
}
