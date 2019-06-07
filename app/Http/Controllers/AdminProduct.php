<?php

namespace App\Http\Controllers;

use App\PL_Cabang;
use App\PL_Produk;
use App\PL_Produk_Harga;
use App\PL_Produk_Stok;
use App\View_Stok_Produk;
use App\PL_Transaksi_Detail;
use App\PL_Transaksi_Jenis;
use App\Top_Product;
use Illuminate\Http\Request;
use Validator;  
use Alert;
use Illuminate\Support\Facades\DB;

class AdminProduct extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //product
    public function index()
    {
        $booths = PL_Cabang::all();
    	return view('admin/product-booth',[
            'booths' => $booths
        ]);
    }
    public function ProductAdd()
    {
        $booths = PL_Cabang::all();
        $p = PL_Produk::groupBy('nama_makanan')
                        ->pluck('nama_makanan')
                        ->toArray();
        $j = PL_Transaksi_Jenis::groupBy('jenis_transaksi')
                                ->orderBy('jenis_transaksi','desc')
                                ->get();

        return view('admin/product-add',[
            'booths' => $booths,
            'p' => $p,
            'j' => $j
        ]);
    }
    public function ProductSave(Request $request)
    {
        if($request->simpan != null){

            $validator = Validator::make($request->all(), [
                'id_booth' => 'required',
                'nama_makanan' => 'required',
                'gambar' => 'mimes:jpeg,jpg,png|max:1000'
            ], [
                'id_booth.required' => 'Pilih terlebih dahulu nama booth.',
                'nama_makanan.required' => 'Nama makanan tidak boleh kosong.',
                'gambar.mimes' => 'Gambar harus berekstensi jpeg, jpg atau png.',
                'gambar.max' => 'Ukuran gambar maksimum 1 MB'
            ])->validate();

            if (count(array_filter($request->harga)) < 1) {
                Alert::warning('Isi minimal satu harga produk', 'Gagal');
                return redirect()->back();
            }
            else{
                if(!isset($request->gambar)){
                    for ($i=0; $i < count($request->id_booth) ; $i++) { 
                        $c = PL_Produk::max('id');
                        PL_Produk::create([
                            'id' => $c+1,
                            'nama_makanan' => $request->nama_makanan,
                            'kategori' => $request->kategori,
                            'id_booth' => $request->id_booth[$i],
                            'status' => 1
                        ]);
                        $p[$i] = PL_Transaksi_Jenis::where('id_booth', $request->id_booth[$i])
                                            ->orderBy('jenis_transaksi','desc')
                                            ->pluck('id');
                        
                        for ($a=0; $a < count($request->harga); $a++) { 
                            PL_Produk_Harga::create([
                                'id_produk' => $c+1,
                                'id_jenis_transaksi' => $p[$i][$a],
                                'harga' => $request->harga[$a]
                            ]);
                        }
                        
                    }
                }
                else{
                    $gambar = $request->gambar;
                    $ext = $gambar->getClientOriginalExtension();
                    $nama = date('dmYhis').'.'.$gambar->getClientOriginalExtension();
                    $path = 'assets/img/daftar-menu/';
                    $gambar->move($path,$nama);

                    for ($i=0; $i < count($request->id_booth) ; $i++) { 
                        $c = PL_Produk::max('id');
                        PL_Produk::create([
                            'id' => $c+1,
                            'nama_makanan' => $request->nama_makanan,
                            'kategori' => $request->kategori,
                            'id_booth' => $request->id_booth[$i],
                            'status' => 1,
                            'gambar' => $path.$nama
                        ]);
                        $p[$i] = PL_Transaksi_Jenis::where('id_booth', $request->id_booth[$i])
                                            ->orderBy('jenis_transaksi','desc')
                                            ->pluck('id');
                        
                        for ($a=0; $a < count($request->harga); $a++) { 
                            PL_Produk_Harga::create([
                                'id_produk' => $c+1,
                                'id_jenis_transaksi' => $p[$i][$a],
                                'harga' => $request->harga[$a]
                            ]);
                        }
                        
                    }

                    
                }
                Alert::success('Berhasil Tambah Data Produk', 'Berhasil');
                return redirect()->back();
            }
        }
    }

    public function ProductBooth(Request $request)
    {
        $id = $request->id_booth;
        $booth = PL_Cabang::where('id_booth',$id)->first();
        $menus = PL_Produk::where('id_booth',$id)
                            ->where('status',1)
                            ->get();
        $harga = PL_Produk_Harga::join('pl_transaksi_jenis', 'pl_produk_harga.id_jenis_transaksi', '=', 'pl_transaksi_jenis.id')
                ->select('pl_produk_harga.*', 'pl_transaksi_jenis.jenis_transaksi')
                ->orderBy('jenis_transaksi','desc')
                ->get();
                            

        $menus_d = PL_Produk::where('id_booth',$id)
                            ->where('status',0)
                            ->get();
        $jumlah = PL_Produk::where('id_booth',$id)
            ->where('status', 1)
            ->count();
        return view('admin/product-booth-menu',[
            'booth' => $booth,
            'menus' => $menus,
            'harga' => $harga,
            'menus_d' => $menus_d,
            'jumlah' => $jumlah
        ]);
    }


    public function ProductStats(Request $request)
    {
        $builder = Top_Product::query();

        $builder->select(DB::raw('sum(jumlah) as jumlah, nama_makanan, id_booth'));

        if(!empty($request->id_booth)){
            $builder->where('id_booth',$request->id_booth);
        }

        else {
            $builder->where('id_booth','like','%'.$request->id_booth.'%');
        }

        if($request->waktu == 'minggu'){
            $ts = date('Y-m-d');
            $tsp = date('Y-m-d', strtotime('-6 days', strtotime($ts)));
            $jh = $builder ->whereDate('created_at','>=', $tsp)
                            ->whereDate('created_at','<=', $ts)
                            ->groupBy('nama_makanan')
                            ->orderBy('jumlah','desc')
                            ->limit(5)->get();

            $jl = $builder ->whereDate('created_at','>=', $tsp)
                            ->whereDate('created_at','<=', $ts)
                            ->whereNotIn('nama_makanan',$jh->pluck('nama_makanan'))
                            ->groupBy('nama_makanan')
                            ->orderBy('jumlah','desc')
                            ->get();

        }elseif($request->waktu == 'bulan'){
            $jh = $builder->whereMonth('created_at','>=', date('m'))
                            ->groupBy('nama_makanan')
                            ->orderBy('jumlah','desc')
                            ->limit(5)->get();
                            
            $jl = $builder->whereDate('created_at',date('Y-m-d'))
                            ->whereNotIn('nama_makanan',$jh->pluck('nama_makanan'))
                            ->groupBy('nama_makanan')
                            ->orderBy('jumlah','desc')
                            ->get();
        }
        else{
            $jh = $builder->whereDate('created_at',date('Y-m-d'))
                            ->groupBy('nama_makanan')
                            ->orderBy('jumlah','desc')
                            ->limit(5)->get();

            $jl = $builder->whereDate('created_at',date('Y-m-d'))
                            ->whereNotIn('nama_makanan',$jh->pluck('nama_makanan'))
                            ->groupBy('nama_makanan')
                            ->orderBy('jumlah','desc')
                            ->get();
        }
        

        $booths = PL_Cabang::where('status',1)->get();;

        return view('admin/product-stats',[
            'jh' => $jh->pluck('jumlah')->toArray(),
            'label' => $jh->pluck('nama_makanan')->toArray(),
            'jl' => $jl,
            'booths' => $booths,
            'waktu' => $request->waktu,
            'id_booth' => $request->id_booth
        ]);
    }
    public function ProductInfo(Request $request)
    {
        $id = $request->id_booth;
        $id_m = $request->id;
        $booth = PL_Cabang::where('id_booth',$id)->first();
        $menu = PL_Produk::where('id',$id_m)->first();
        $ph = ProdukTerjual($request->id,$request->id_booth,'produk');
        $pl = ProdukTerjual($request->id,$request->id_booth,'label');

        $pb = ProdukTerjualB($request->id,$request->id_booth);

        return view('admin/product-booth-menu-info',[
            'booth' => $booth,
            'menu' => $menu,
            'ph' => $ph,
            'pl' => $pl,
            'pb' => $pb
        ]);
    }
    public function ProductEdit(Request $request)
    {
        $id = $request->id_booth;
        $id_m = $request->id;
        $booth = PL_Cabang::where('id_booth',$id)->first();
        $menu = PL_Produk::where('id',$id_m)->first();

        $harga = PL_Produk_Harga::join('pl_transaksi_jenis', 'pl_produk_harga.id_jenis_transaksi', '=', 'pl_transaksi_jenis.id')
                ->select('pl_produk_harga.*', 'pl_transaksi_jenis.jenis_transaksi')
                ->where('id_produk',$id_m)
                ->orderBy('jenis_transaksi','desc')
                ->get();

        return view('admin/product-booth-menu-edit',[
            'booth' => $booth,
            'menu' => $menu,
            'harga' => $harga
        ]);
    }
    public function ProductUpdate(Request $request)
    {
        if($request->update != null){
           $validator = Validator::make($request->all(), [
                'id_booth' => 'required',
                'nama_makanan' => 'required',
                'gambar' => 'mimes:jpeg,jpg,png|max:1000'
            ], [
                
                'id_booth.required' => 'Pilih terlebih dahulu nama booth.',
                'nama_makanan.required' => 'Nama makanan tidak boleh kosong.',
                'gambar.max' => 'Ukuran gambar maksimum 1 MB',
                'gambar.mimes' => 'Gambar harus berekstensi jpeg, jpg atau png.'
               
            ])->validate();

           if(!isset($request->gambar)){

                PL_Produk::where('id_booth',$request->id_booth)
                        ->where('id',$request->id_makanan)
                        ->update([
                            'nama_makanan' => $request->nama_makanan,
                            'kategori' => $request->kategori,
                            'status' => 1
                        ]);
            }
            else{

                $gambar = $request->gambar;
                $ext = $gambar->getClientOriginalExtension();
                $nama = date('dmYhis').'.'.$gambar->getClientOriginalExtension();
                $path = 'assets/img/daftar-menu/';
                $gambar->move($path,$nama);

                PL_Produk::where('id_booth',$request->id_booth)
                        ->where('id',$request->id_makanan)
                        ->update([
                            'nama_makanan' => $request->nama_makanan,
                            'kategori' => $request->kategori,
                            'gambar' => $path.$nama,
                            'status' => 1
                        ]);

                
            }
            for ($i=0; $i < count($request->id_harga); $i++) { 
                    PL_Produk_Harga::where('id_produk',$request->id_makanan)    
                                    ->where('id',$request->id_harga[$i])
                                    ->update([
                                        'harga' => $request->harga[$i]
                                    ]);
            }
            Alert::success('Berhasil Update Data Produk', 'Berhasil');
            return redirect()->back();
        }
    }
    public function ProductDelete(Request $request)
    {
        $id = $request->id;
        $produk = PL_Produk::find($id);
        $produk->status = 0;
        $produk->save();

        Alert::success('Produk Berhasil Dinonaktifkan', 'Berhasil');
        return redirect()->back();

    }
    public function ProductDeletePer($id)
    {
        $produk = PL_Produk::find($id);
        $produk->status = 3;
        $produk->save();

        Alert::success('Produk Berhasil Dihapus', 'Berhasil');
        return redirect()->back();

    }
    
    public function ProductBack(Request $request)
    {
        $id = $request->id;
        $produk = PL_Produk::find($id);
        $produk->status = 1;
        $produk->save();

        Alert::success('Produk Berhasil Aktifkan', 'Berhasil');
        return redirect()->back();

    }
    //stock-product
    public function StockProduct()
    {
        $booths = PL_Cabang::where('status',1)->get();
    	return view('admin/product-stock', [
            'booths' => $booths
        ]);
    }
    public function StockProductBooth(Request $request)
    {
        $id = $request->id_booth;

        $booth = PL_Cabang::where('id_booth',$id)->first();
        $products = PL_Produk::where('id_booth',$id)
                    ->where('status',1)
                    ->get();
        $stocks = View_Stok_Produk::whereDate('created_at',date('Y-m-d'))
                        ->where('id_booth',$id)
                        ->get();

        return view('admin/product-stock-booth', [
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
                    $stok[] = PL_Produk_Stok::where('id_produk', $request->id_produk[$i])
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
                        PL_Produk_Stok::where('id_produk', $request->id_produk[$i])
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
    public function StockProductHistory(Request $request)
    {
        $booth = PL_Cabang::where('id_booth',$request->id_booth)->first();
        $product = PL_Produk::find($request->id);

        $ph = StokProduct($request->id,'produk');
        $pl = StokProduct($request->id,'label');
        $pt = StokProductTerjual($request->id);

        return view('admin/product-stock-history',[
            'booth' => $booth,
            'p' => $product,
            'ph' => $ph,
            'pl' => $pl,
            'pt' => $pt

        ]);
    }
}
