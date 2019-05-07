<?php

namespace App\Http\Controllers;

use App\PL_Product;
use App\PL_Transaksi;
use App\PL_JenisTransaksi;
use App\PL_Stok;
use App\PL_Detail;
use App\PL_Note;
use App\PL_Booth;
use App\PL_Pajak;
use Illuminate\Http\Request;
use Validator;  
use Alert;
use PDF;
use Illuminate\Support\Facades\DB;


class KasirDashboard extends Controller
{
    public function __construct()
    {
        $this->middleware('cekstatus');

    }
    public function index()
    {
        $id = session('login')['id_booth'];
        $notes = PL_Note::where('id_booth', $id)->get();
        $stok = PL_Stok::whereDate('created_at',date('Y-m-d'))
                        ->where('id_booth',$id)
                        ->count();
        $jenis = PL_JenisTransaksi::where('id_booth', $id)
                                ->where('status', 1)
                                ->get();    

    	return view('kasir/dashboard',[
             'notes' => $notes,
             'stok' => $stok,
             'jenis' => $jenis
        ]);
    }

    public function KasirProduct(Request $request)
    {
        $jenis = $request->jenis;
        $id = session('login')['id_booth'];
        $products = PL_Product::where('id_booth', $id)
                                ->where('status',1)
                                ->get();
        $stok = PL_Stok::whereDate('created_at',date('Y-m-d'))
                        ->where('id_booth',$id)
                        ->get();
       
    	return view('kasir/product', [
            'products' => $products,
            'id' => $id,
            'stok' => $stok,
            'jenis' => $jenis
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
                $cart = session()->get('cart');
                $product = PL_Product::find($id);

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
                    $stok[$i] = PL_Stok::whereDate('created_at',date('Y-m-d'))
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

            Alert::success('Berhasil Dihapus Dari Keranjang', 'Berhasil');
            return redirect()->back();
        }
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

        return redirect()->route('kasir.dashboard');
    }
    
    //checkout
    public function Checkout(Request $request)
    {
        $jenis = $request->jenis;
    	return view('kasir/checkout',[
            'jenis' => $jenis
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
                $nilai_max = PL_Transaksi::where('id_booth', $request->id_booth)->max('id'); //nilai max
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
                        'jenis' => $request->jenis,
                        'bayar' => Nominal($request->bayar),
                        'kembali' => Nominal($request->kembali),
                        'nama_pembeli' => $request->nama,
                        'status' => 2, 
                        'id_booth' => $request->id_booth,
                        'keterangan' => $request->keterangan
                    ]);

                    foreach(session('cart') as $id => $detail){
                        PL_Detail::create([
                            'id_produk' => $id,
                            'id_transaksi' => $id_transaksi,
                            'harga_satuan' => $detail['harga'],
                            'jumlah' => $detail['jumlah']
                        ]);
                    }
                    
                    $pajak = PajakTrans($request->jenis,$request->id_booth);
                    PL_Pajak::create([
                        'id_transaksi' => $id_transaksi,
                        'jenis_transaksi' => $request->jenis,
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
                        'jenis' => $request->jenis,
                        'kode' => $request->kode,
                        'bayar' => Nominal($request->bayar),
                        'kembali' => Nominal($request->kembali),
                        'nama_pembeli' => $request->nama,
                        'status' => 1, 
                        'id_booth' => $request->id_booth
                    ]);

                    foreach(session('cart') as $id => $detail){
                        PL_Detail::create([
                            'id_produk' => $id,
                            'id_transaksi' => $id_transaksi,
                            'harga_satuan' => $detail['harga'],
                            'jumlah' => $detail['jumlah']
                        ]);
                        PL_Stok::whereDate('created_at',date('Y-m-d'))
                                ->where('id_produk',$id)
                                ->decrement('sisa_stok',$detail['jumlah']);
                    }

                    $pajak = PajakTrans($request->jenis,$request->id_booth);
                    PL_Pajak::create([
                        'id_transaksi' => $id_transaksi,
                        'jenis_transaksi' => $request->jenis,
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
        $nota = PL_Transaksi::find($id);
        $detail = PL_Detail::where('id_transaksi',$id)->get();
        $booth = PL_Booth::where('id_booth',session('login')['id_booth'])->first();
        $produk = PL_Product::whereIn('id',$detail->pluck('id_produk'))->get();

        return view('kasir/print-nota',[
            'nota' => $nota,
            'detail' => $detail,
            'booth' => $booth,
            'produk' => $produk
        ]);

    }

    public function Nota($id)
    {
        $nota = PL_Transaksi::find($id);
        $detail = PL_Detail::where('id_transaksi',$id)->get();
        $booth = PL_Booth::where('id_booth',session('login')['id_booth'])->first();
        $produk = PL_Product::whereIn('id',$detail->pluck('id_produk'))->get();

        $pdf = PDF::loadView('kasir/print-nota',[
            'nota' => $nota,
            'detail' => $detail,
            'booth' => $booth,
            'produk' => $produk
        ]);
        // $pdf->setPaper([0,0,164,200],'potrait');
        
        return $pdf->stream($id.'.pdf');

    }

    //update stok
    public function StockUpdate(Request $request)
    {
        if($request->update != null){
            if(count(array_filter($request->update_stok)) < 1){
                Alert::warning('Isi Kolom Update Stok Terlebih Dahulu', 'Gagal');
                return redirect()->back();
            }
            else{
                for ($i=0; $i < count($request->update_stok); $i++) { 
                    $stok[] = PL_Stok::where('id_produk', $request->id_produk[$i])
                            ->whereDate('created_at',date('Y-m-d'))
                            ->where('id_booth', $request->id_booth)
                            ->count();
                    
                    $val[] = intval($request->update_stok[$i]);
      
                    if($stok[$i] <= 0){
                        PL_Stok::create([
                            'total_stok' => $val[$i],
                            'sisa_stok' => $val[$i], 
                            'id_produk' => $request->id_produk[$i],
                            'id_booth' => $request->id_booth
                        ]);
                    }
                    else{
                        PL_Stok::where('id_produk', $request->id_produk[$i])
                            ->whereDate('created_at',date('Y-m-d'))
                            ->where('id_booth', $request->id_booth)
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
}


