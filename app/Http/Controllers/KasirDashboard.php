<?php

namespace App\Http\Controllers;

use App\PL_Produk;
use App\PL_Transaksi;
use App\View_Transaksi;
use App\PL_Transaksi_Jenis;
use App\PL_Produk_Stok;
use App\PL_Transaksi_Detail;
use App\PL_Catatan;
use App\PL_Cabang;
use App\PL_Pajak;
use App\View_Produk_Kasir;
use App\View_Stok_Produk;

use Illuminate\Http\Request;
use Validator;  
use Alert;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;


class KasirDashboard extends Controller
{
    public function __construct()
    {
        $this->middleware('cekstatus');

    }
    public function index()
    {
        $id = session('login')['id_booth'];
        $notes = PL_Catatan::where('id_booth', $id)->get();
        $stok = View_Stok_Produk::whereDate('created_at',date('Y-m-d'))
                        ->where('id_booth',$id)
                        ->count();
        $jenis = PL_Transaksi_Jenis::where('id_booth', $id)
                                ->where('status', 1)
                                ->get();    

    	return view('kasir/dashboard',[
             'notes' => $notes,
             'stok' => $stok,
             'jenis' => $jenis,
             'id' => $id
        ]);
    }

    public function KasirProduct(Request $request)
    {
        $id_jenis = $request->id;
        $jenis = $request->jenis;
        $id = session('login')['id_booth'];
        $products = View_Produk_Kasir::where('id_booth', $id)
                                ->where('status',1)
                                ->where('id_jenis_transaksi',$id_jenis)
                                ->where('harga','!=',0)
                                ->get();
        $stok = View_Stok_Produk::whereDate('created_at',date('Y-m-d'))
                        ->where('id_booth',$id)
                        ->get();
       
    	return view('kasir/product', [
            'products' => $products,
            'id' => $id,
            'stok' => $stok,
            'jenis' => $jenis,
            'id_jenis' => $id_jenis
        ]);
    }

    //add to cart
    public function AddToCart(Request $request)
    {

        if ($request->pesan != null) {
            if($request->jumlah == null){

                Alert::warning('Masukkan Jumlah Terlebih Dahulu', 'Gagal');
                return redirect()->back();
            }
            elseif($request->jumlah > $request->sisa && $request->jenis != 'Pesanan'){

                Alert::warning('Stok Tidak Mencukupi', 'Gagal');
                return redirect()->back();
            }
            elseif(isset(session('cart')[$request->id_product]['jumlah']) && $request->jumlah+session('cart')[$request->id_product]['jumlah'] > $request->sisa && $request->jenis != 'Pesanan'){
                    Alert::warning('Stok Tidak Mencukupi Untuk Ditambahkan', 'Gagal');
                    return redirect()->back();  
            }
            else{
                $id = $request->id_product;
                $id_jenis = $request->id_jenis;
                $cart = session()->get('cart');
                $product = View_Produk_Kasir::where('id_produk', $id)
                                            ->where('id_jenis_transaksi',$id_jenis)
                                            ->first();
                if(!$cart){
                    $cart = [
                            $id => [
                                "nama_produk" => $product->nama_makanan,
                                "jumlah" => $request->jumlah,
                                "harga" => $request->harga
                            ]
                    ];

                    session()->put('cart', $cart);

                    Alert::success('Berhasil Ditambahkan', 'Berhasil');
                    return redirect()->back();
                }
                elseif(isset($cart[$id])){
                    $cart[$id]['jumlah']+=$request->jumlah;

                    session()->put('cart', $cart);

                    Alert::success('Berhasil Ditambahkan', 'Berhasil');
                    return redirect()->back();
                }
                else{
                    $cart[$id] = [
                        "nama_produk" => $product->nama_makanan,
                        "jumlah" => $request->jumlah,
                        "harga" => $request->harga
                    ];

                    session()->put('cart', $cart);

                    Alert::success('Berhasil Ditambahkan', 'Berhasil');
                    return redirect()->back();
                }
            }
        }
    }

    public function UpdateCart(Request $request)
    {
        if ($request->update_cart != null) {
            
            $cart = session()->get('cart');
            for ($i=0; $i < count($request->id_product) ; $i++) { 

                if($request->jumlah[$i] == 0){

                     unset($cart[$request->id_product[$i]]);
                     session()->put('cart', $cart);
                }
                else{
                    $id = session('login')['id_booth'];
                    $stok[$i] = PL_Produk_Stok::whereDate('created_at',date('Y-m-d'))
                        ->where('id_produk',$request->id_product[$i])
                        ->sum('sisa_stok');
                    if($request->jenis == 'Pesanan'){
                        $cart[$request->id_product[$i]]['jumlah'] = $request->jumlah[$i];
                        session()->put('cart', $cart); 
                    }
                    elseif($request->jumlah[$i] > $stok[$i]){
                        Alert::warning('Stok Produk Tidak Mencukupi', 'Gagal');
                        return redirect()->back();
                    }
                    else{
                        $cart[$request->id_product[$i]]['jumlah'] = $request->jumlah[$i];
                        session()->put('cart', $cart); 
                    }
                    
                }
                  
            }
            
            Alert::success('Berhasil Diupdate', 'Berhasil');
            return redirect()->back();
        }
    }

    public function RemoveFromCart(Request $request)
    {

        if ($request->id_product != null) {
            $cart = session()->get('cart');

            unset($cart[$request->id_product]);
            session()->put('cart', $cart);

        }
        Alert::success('Berhasil Diupdate', 'Berhasil');
        return redirect()->back();

    }

    public function RemoveCart()
    {
        $cart = session()->get('cart');
        session()->forget('cart');
        Alert::success('Keranjang Berhasil Direset', 'Berhasil');
        return redirect()->back();
    }

    public function RemoveCartBack()
    {
        $cart = session()->get('cart');
        session()->forget('cart');

        return redirect()->back();
    }
    
    //checkout
    public function Checkout(Request $request)
    {
        $jenis = $request->jenis;
        $id_jenis = $request->id;
    	return view('kasir/checkout',[
            'jenis' => $jenis,
            'id_jenis' => $id_jenis
        ]);
    }

    public function SaveCheckout(Request $request)
    {
        if (!is_null($request->simpan_cetak)) {
            $cart = session()->get('cart');

            if(is_null($cart)){
                Alert::warning('Sesi Berakhir', 'Gagal');
                return redirect()->back();
            }
            elseif(Nominal($request->bayar) < Nominal($request->total)){
                Alert::warning('Uang Pembayaran Kurang', 'Gagal');
                return redirect()->back();
            }
            elseif(Nominal($request->potongan) > Nominal($request->subtotal) ){
                Alert::warning('Potongan Terlalu Besar', 'Gagal');
                return redirect()->back();
            }
            else{
                $nilai_max = View_Transaksi::where('id_booth', $request->id_booth)->max('id'); //nilai max
                $max = strpos($nilai_max, '-')+1;
                $max = substr($nilai_max, $max);
                
                $id = $max + 1;
                $id = str_pad($id,11,'0',STR_PAD_LEFT); //nilai max plus 1

                $id_transaksi =  $request->id_booth.'-'.$id; //id_save


                if($request->jenis == 'Pesanan'){
                    PL_Transaksi::create([
                        'id' =>  $id_transaksi,
                        'subtotal' => Nominal($request->subtotal),
                        'potongan' => Nominal($request->potongan),
                        'total' => Nominal($request->total),
                        'bayar' => Nominal($request->bayar),
                        'kembali' => Nominal($request->kembali),
                        'nama_pembeli' => $request->nama,
                        'status' => 2, 
                        'id_jenis_transaksi' => $request->id_jenis,
                        'keterangan' => $request->keterangan
                    ]);

                    foreach(session('cart') as $id => $detail){
                        PL_Transaksi_Detail::create([
                            'id_produk' => $id,
                            'id_transaksi' => $id_transaksi,
                            'harga_satuan' => $detail['harga'],
                            'jumlah' => $detail['jumlah']
                        ]);
                    }
                    
                    $pajak = PajakTrans($request->jenis,$request->id_booth);
                    PL_Pajak::create([
                        'id_transaksi' => $id_transaksi,
                        'id_jenis_transaksi' => $request->id_jenis,
                        'pajak' => $pajak->pajak,
                        'total_pajak' => $pajak->pajak/100*Nominal($request->subtotal)
                    ]);
                }
                else{
                    PL_Transaksi::create([
                        'id' =>  $id_transaksi,
                        'subtotal' => Nominal($request->subtotal),
                        'potongan' => Nominal($request->potongan),
                        'total' => Nominal($request->total),
                        'kode' => $request->kode,
                        'bayar' => Nominal($request->bayar),
                        'kembali' => Nominal($request->kembali),
                        'nama_pembeli' => $request->nama,
                        'status' => 1, 
                        'id_jenis_transaksi' => $request->id_jenis,
                    ]);

                    foreach(session('cart') as $id => $detail){
                        PL_Transaksi_Detail::create([
                            'id_produk' => $id,
                            'id_transaksi' => $id_transaksi,
                            'harga_satuan' => $detail['harga'],
                            'jumlah' => $detail['jumlah']
                        ]);
                        PL_Produk_Stok::whereDate('created_at',date('Y-m-d'))
                                ->where('id_produk',$id)
                                ->decrement('sisa_stok',$detail['jumlah']);
                    }

                    $pajak = PajakTrans($request->jenis,$request->id_booth);
                    PL_Pajak::create([
                        'id_transaksi' => $id_transaksi,
                        'id_jenis_transaksi' => $request->id_jenis,
                        'pajak' => $pajak->pajak,
                        'total_pajak' => $pajak->pajak/100*Nominal($request->subtotal)
                    ]);
                }
                

                session()->forget('cart');
                
                return redirect()->route('kasir.print-nota', $id_transaksi);
            } 
        }
            
    }

    public function PrintNota($id)
    {
        $nota = View_Transaksi::find($id);
        $detail = PL_Transaksi_Detail::where('id_transaksi',$id)->get();
        $booth = PL_Cabang::where('id_booth',session('login')['id_booth'])->first();
        $produk = PL_Produk::whereIn('id',$detail->pluck('id_produk'))->get();

        $pdf = PDF::loadView('kasir/print-nota-p',[
            'nota' => $nota,
            'detail' => $detail,
            'booth' => $booth,
            'produk' => $produk
        ]);
        $filename = $id.'.pdf';
        Storage::put($filename, $pdf->output());

        return view('kasir/print-nota',[
            'nota' => $nota,
            'detail' => $detail,
            'booth' => $booth,
            'produk' => $produk
        ]);

    }

    public function Nota($id)
    {
        $file_path = '/storage/'.$id.'.pdf';
        return redirect($file_path);

    }

    //update stok
    public function StockProduct()
    {
        $id = session('login')['id_booth'];

        $booth = PL_Cabang::where('id_booth',$id)->first();
        $products = PL_Produk::where('id_booth',$id)
                    ->where('status',1)
                    ->get();
        $stocks = View_Stok_Produk::whereDate('created_at',date('Y-m-d'))
                        ->where('id_booth',$id)
                        ->get();

        return view('kasir/product-stock', [
            'products' => $products,
            'booth' => $booth,
            'stocks' => $stocks
        ]);
    }
    public function StockUpdate(Request $request)
    {
        if($request->update != null){
            if(count(array_filter($request->update_stok)) < 1){
                Alert::warning('Isi Kolom Update Stok Terlebih Dahulu', 'Gagal');
                return redirect()->back();
            }
            else{
                for ($i=0; $i < count($request->update_stok); $i++) { 
                    $stok[] = View_Stok_Produk::where('id_produk', $request->id_produk[$i])
                            ->whereDate('created_at',date('Y-m-d'))
                            ->count();
                    
                    $val[] = intval($request->update_stok[$i]);
      
                    if($stok[$i] <= 0){
                        PL_Produk_Stok::create([
                            'total_stok' => $val[$i],
                            'sisa_stok' => $val[$i], 
                            'id_produk' => $request->id_produk[$i]
                        ]);
                    }
                    else{
                        View_Stok_Produk::where('id_produk', $request->id_produk[$i])
                            ->whereDate('created_at',date('Y-m-d'))
                            ->update([
                                    'total_stok' => DB::raw('total_stok + '.$val[$i].''),
                                    'sisa_stok' => DB::raw('sisa_stok + '.$val[$i].'')
                            ]);
                    }
                }
            }
        }

        Alert::success('Produk Berhasil Update Stok Produk', 'Berhasil');
        return redirect()->back();
        
    }

    public function StatusBooth($id_booth)
    {
        $booth = PL_Cabang::where('id_booth',$id_booth)->first();
        if($booth->status != 1){
            $session = 0;
        }
        elseif(date('H:i') < date('H:i',strtotime($booth->jam_buka)) || date('H:i') > date('H:i',strtotime($booth->jam_tutup))){
            $session = 0;
        }
        else{
            $session = 1;
        }
        return response()->json($session);
    }
}


