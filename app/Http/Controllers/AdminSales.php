<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PL_Product;
use App\PL_Transaksi;
use App\PL_Stok;
use App\PL_Detail;
use App\PL_Booth;
use Illuminate\Support\Facades\DB;

class AdminSales extends Controller
{
    public function index(Request $request, PL_Transaksi $sales)
    {

        $booths = PL_Booth::all();
        $builder = PL_Transaksi::query();
        $builder_j = PL_Transaksi::query();
        $sale_first = PL_Transaksi::where('status',1)->first(); 
        
        //Chart
        if($request->chart == 't' || empty($request->chart)){
            $t = ChartTransaksi();
        }
        else{
            $t = ChartIncome();
        }

        if($request->filter == null){
            $sales = PL_Transaksi::where('status',1)
                                ->orderBy('created_at','desc')
                                ->get();

            $jumlah_transaksi = PL_Transaksi::select(DB::raw('jenis, count(id) as jumlah, sum(total) as total'))
                                ->where('status',1)
                                ->groupBy('jenis')
                                ->get();

            $jenis = null;
        }
        elseif($request->filter != null){
            foreach ($request->jenis as $key) {
                $jenis[] = $key; 
            }
            $builder_j->select(DB::raw('jenis, count(id) as jumlah, sum(total) as total'));
            if(is_null($request->id_booth)){
                $builder->where('id_booth','like','%%');
                $builder_j->where('id_booth','like','%%');
            }
            if(!is_null($request->id_booth)){
                $builder->where('id_booth',$request->id_booth);
                $builder_j->where('id_booth',$request->id_booth);
            }           
           
            if(!empty($request->t_awal) && !empty($request->t_akhir)){
                $builder->whereDate('created_at','>=', date('Y-m-d', strtotime($request->t_awal)));
                $builder->whereDate('created_at','<=', date('Y-m-d', strtotime($request->t_akhir)));
                $builder_j->whereDate('created_at','<=', date('Y-m-d', strtotime($request->t_akhir)));
                $builder_j->whereDate('created_at','<=', date('Y-m-d', strtotime($request->t_akhir)));

            }
            if(!empty($request->t_awal) && empty($request->t_akhir)){
                $builder->whereDate('created_at','=',date('Y-m-d', strtotime($request->t_awal)));
                $builder_j->whereDate('created_at','=',date('Y-m-d', strtotime($request->t_awal)));
            }
            if(!empty($request->jenis)){

                $builder->whereIn('jenis', $jenis);
                $builder_j->whereIn('jenis', $jenis);
                
            }
            $sales = $builder->where('status',1)->orderBy('created_at','desc')->get();
            $jumlah_transaksi = $builder_j
                            ->where('status',1)
                            ->groupBy('jenis')
                            ->get();
        }
        return view('admin/sales',[
            'booths' => $booths,
            'sales' => $sales,
            'id_booth' => $request->id_booth,
            't_awal' => $request->t_awal,
            't_akhir' => $request->t_akhir,
            'jenis' => $jenis,
            'jumlah_t' => $jumlah_transaksi,
            'chart' => $t,
            'rc' => $request->chart
        ]);
    }

    public function Detail($id)
    {
    	$sale = PL_Transaksi::find($id);
    	$booth = PL_Booth::where('id_booth',$sale->id_booth)->first();
    	$detail = PL_Detail::join('pl_produk', 'pl_produk.id', '=', 'pl_detail_transaksi.id_produk')
    						->select('pl_detail_transaksi.*','pl_produk.nama_makanan')
    						->where('id_transaksi',$id)
    						->get();
    	return view('admin/sales-detail',[
    		'sale' => $sale,
    		'detail' => $detail,
    		'booth' => $booth
    	]);
    }
    public function Pesanan()
    {
        $sales = PL_Transaksi::whereDate('created_at',date('Y-m-d'))
                            ->where('jenis','Pesanan')
                            ->whereIn('status',[0,1,2])
                            ->orderBy('created_at','desc')
                            ->get();
        // dd($sales);  
        return view('admin/sales-pesanan', [
            'sales' => $sales
        ]);
    }

}
