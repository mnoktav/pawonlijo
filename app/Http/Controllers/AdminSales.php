<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PL_Produk;
use App\Top_Product;
use App\PL_Transaksi;
use App\PL_Produk_Stok;
use App\PL_Transaksi_Detail;
use App\PL_Transaksi_Jenis;
use App\PL_Cabang;
use App\View_Transaksi;
use Alert;
use Illuminate\Support\Facades\DB;

class AdminSales extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request, PL_Transaksi $sales)
    {

        $booths = PL_Cabang::all();
        $sale_first = View_Transaksi::where('status',1)->first(); 
        $booths = PL_Cabang::get();
        $jenis = PL_Transaksi_Jenis::groupBy('jenis_transaksi')->get();
        $builder = View_Transaksi::query();
        $builder_j = View_Transaksi::query();
        $top = Top_Product::query();
        
        
        
        $k = 0;
        foreach ($booths as $booth) { 
            $chart_tahun[$k++] = ChartIncomeBooth($booth->id_booth,'income');
        }

        if (empty($request->bulan)) {
            $b = date('n');
            $t = date('Y');
        }
        else{
            $b = $request->bulan;
            $t = $request->tahun;
        }

        if($request->filter == null){
            $sales = View_Transaksi::where('status',1)
                                ->whereMonth('created_at',$b)
                                ->whereYear('created_at',$t)
                                ->orderBy('created_at','desc')
                                ->get();

            $jumlah_transaksi = View_Transaksi::select(DB::raw('jenis, count(id) as jumlah, sum(total_bersih) as total, sum(total_pajak) as t_pajak'))
                                ->whereMonth('created_at',$b)
                                ->whereYear('created_at',$t)
                                ->where('status',1)
                                ->groupBy('jenis')
                                ->get();

            $top = Top_Product::select(DB::raw('sum(jumlah) as jumlah, nama_makanan'))
                            ->whereMonth('created_at',$b)
                            ->whereYear('created_at',$t)
                            ->groupBy('nama_makanan')
                            ->orderBy('jumlah','desc')
                            ->orderBy('nama_makanan','asc');
        }
        elseif($request->filter != null){

            $builder_j->select(DB::raw('jenis, count(id) as jumlah, sum(total_bersih) as total, sum(total_pajak) as t_pajak'));
            $top->select(DB::raw('sum(jumlah) as jumlah, nama_makanan'));

            if(is_null($request->id_booth)){
                $builder->where('id_booth','like','%%');
                $builder_j->where('id_booth','like','%%');
                $top->where('id_booth','like','%%');
            }
            if(!is_null($request->id_booth)){
                $builder->where('id_booth',$request->id_booth);
                $builder_j->where('id_booth',$request->id_booth);
                $top->where('id_booth',$request->id_booth);
            }           
           
            if(!empty($request->bulan)){
                $builder->whereMonth('created_at',$b);
                $builder_j->whereMonth('created_at',$b);
                $top->whereMonth('created_at',$b);

            }
            if(!empty($request->tahun)){
                $builder->whereYear('created_at',$t);
                $builder_j->whereYear('created_at',$t);
                $top->whereYear('created_at',$t);

            }
        
            $sales = $builder->where('status',1)
                             ->orderBy('created_at','desc')->get();

            $jumlah_transaksi = $builder_j
                            ->where('status',1)
                            ->groupBy('jenis')
                            ->get();

            $top = $top->groupBy('nama_makanan')
                        ->orderBy('jumlah','desc')
                        ->orderBy('nama_makanan','asc');

        }

        return view('admin/sales',[
            'booths' => $booths,
            'jenis' => $jenis,
            'sales' => $sales,
            'id_booth' => $request->id_booth,
            'jumlah_t' => $jumlah_transaksi,
            'ct' => $chart_tahun,
            'b' => $b,
            't' => $t,
            'top_n' => $top->pluck('nama_makanan')->toArray(),
            'top_j' => $top->pluck('jumlah')->toArray()
        ]);
    }

    public function Detail($id)
    {
    	$sale = View_Transaksi::where('id',$id)->first();
    	$booth = PL_Cabang::where('id_booth',$sale->id_booth)->first();
    	$detail = PL_Transaksi_Detail::join('pl_produk', 'pl_produk.id', '=', 'pl_transaksi_detail.id_produk')
    						->select('pl_transaksi_detail.*','pl_produk.nama_makanan')
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
        $sales = View_Transaksi::where('jenis','Pesanan')
                            ->whereIn('status',[0,1,2])
                            ->orderBy('created_at','desc')
                            ->get();
        // dd($sales);  
        return view('admin/sales-pesanan', [
            'sales' => $sales
        ]);
    }
    public function PesananSelesai($id)
    {
        $sale = PL_Transaksi::find($id);
        $sale->status = 1;
        $sale->save();

        PL_Transaksi_Detail::where('id_transaksi',$id)->update(['updated_at' => NOW()]);

        Alert::success('Transaksi Selesai', 'Berhasil');
        return redirect()->back();
    }
}
