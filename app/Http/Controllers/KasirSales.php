<?php

namespace App\Http\Controllers;

use App\PL_Product;
use App\PL_Transaksi;
use App\PL_Stok;
use App\PL_Detail;
use App\PL_Booth;
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
    	$booth = PL_Booth::where('id_booth',$id)->first();
    	$sales = PL_Transaksi::whereDate('created_at',date('Y-m-d'))
    						->where('id_booth', $id)
                            ->where('status',1)
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
    	$sale = PL_Transaksi::find($id);
    	$booth = PL_Booth::where('id_booth',$sale->id_booth)->first();
    	$detail = PL_Detail::join('pl_produk', 'pl_produk.id', '=', 'pl_detail_transaksi.id_produk')
    						->select('pl_detail_transaksi.*','pl_produk.nama_makanan')
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

            $cek_detail = PL_Detail::where('id_transaksi',$request->id)->get();

            foreach ($cek_detail as $a) {
                PL_Stok::whereDate('created_at', date('Y-m-d'))
                        ->where('id_produk',$a->id_produk)
                        ->increment('sisa_stok',$a->jumlah);
            }

            $sale = PL_Transaksi::find($request->id);
            $sale->status = 0;
            $sale->keterangan = $request->keterangan;
            $sale->save();
            
    		Alert::success('Berhasil Dibatalkan', 'Berhasil');
            return redirect()->back();
    	}
    }
    public function StockProduct()
    {
        $id = session('login')['id_booth'];

        $booth = PL_Booth::where('id_booth',$id)->first();
        $products = PL_Product::where('id_booth',$id)
                    ->where('status',1)
                    ->get();
        $stocks = PL_Stok::whereDate('created_at',date('Y-m-d'))
                        ->where('id_booth',$id)
                        ->get();
        $terjual = PL_Detail::join('pl_produk', 'pl_produk.id', '=', 'pl_detail_transaksi.id_produk')
                            ->select(DB::raw('pl_detail_transaksi.id_produk, sum(pl_detail_transaksi.jumlah) as jumlah, pl_detail_transaksi.created_at, pl_produk.id_booth'))
                            ->where('id_booth',$id)
                            ->whereDate('pl_detail_transaksi.updated_at', date('Y-m-d'))
                            ->groupBy('id_produk')
                            ->get();
        return view('kasir/product-stock', [
            'products' => $products,
            'booth' => $booth,
            'stocks' => $stocks,
            'terjual' => $terjual
        ]);
    }
    public function SalesPesanan()
    {
        $id = session('login')['id_booth'];
        $booth = PL_Booth::where('id_booth',$id)->first();
        $sales = PL_Transaksi::whereDate('created_at',date('Y-m-d'))
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

        PL_Detail::where('id_transaksi',$id)->update(['updated_at' => NOW()]);

        Alert::success('Transaksi Selesai', 'Berhasil');
        return redirect()->back();
    }
}
