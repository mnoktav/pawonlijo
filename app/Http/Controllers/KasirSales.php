<?php

namespace App\Http\Controllers;

use App\Top_Product;
use App\PL_Produk_Stok;
use App\PL_Transaksi;
use App\PL_Transaksi_Detail;
use App\PL_Cabang;
use App\View_Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;  
use Alert;

class KasirSales extends Controller
{
    public function __construct()
    {
        $this->middleware('cekstatus');

    }
    public function index()
    {
    	$id = session('login')['id_booth'];
    	$booth = PL_Cabang::where('id_booth',$id)->first();
    	$sales = View_Transaksi::whereDate('created_at',date('Y-m-d'))
    						->where('id_booth', $id)
                            ->whereIn('status',[0,1])
    						->orderBy('created_at','desc')
    						->get();
    	// dd($sales);	
    	return view('kasir/sales', [
    		'sales' => $sales,
    		'booth' => $booth
    	]);
    }

    public function Detail(Request $request)
    {
    	$id = $request->id;
    	$sale = View_Transaksi::find($id);
    	$booth = PL_Cabang::where('id_booth',$sale->id_booth)->first();

    	$detail = PL_Transaksi_Detail::join('pl_produk', 'pl_produk.id', '=', 'pl_transaksi_detail.id_produk')
    						->select('pl_transaksi_detail.*','pl_produk.nama_makanan')
    						->where('id_transaksi',$id)
    						->get();


    	return view('kasir/sales-detail', [
    		'sale' => $sale,
    		'detail' => $detail,
    		'booth' => $booth
    	]);
    }
    public function TransaksiBatal(Request $request)
    {
    	if(!is_null($request->batal)){

            $sale = View_Transaksi::find($request->id);
            $sale->status = 0;
            $sale->keterangan = $request->keterangan;
            $sale->save();
            
            if($sale->jenis != 'Pesanan'){
                $cek_detail = PL_Transaksi_Detail::where('id_transaksi',$request->id)->get();
            
                foreach ($cek_detail as $a) {
                    PL_Produk_Stok::whereDate('created_at', date('Y-m-d'))
                            ->where('id_produk',$a->id_produk)
                            ->increment('sisa_stok',$a->jumlah);
                }
            }

    		Alert::success('Berhasil Dibatalkan', 'Berhasil');
            return redirect()->back();
    	}
    }
    
    public function SalesPesanan()
    {
        $id = session('login')['id_booth'];
        $booth = PL_Cabang::where('id_booth',$id)->first();
        $sales = View_Transaksi::whereDate('created_at',date('Y-m-d'))
                            ->where('id_booth', $id)
                            ->where('jenis','Pesanan')
                            ->where('status',2)
                            ->orderBy('created_at','desc')
                            ->get();
        // dd($sales);  
        return view('kasir/sales-pesanan', [
            'sales' => $sales,
            'booth' => $booth
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
