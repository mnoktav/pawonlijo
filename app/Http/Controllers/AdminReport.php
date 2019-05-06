<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PL_Product;
use App\PL_Transaksi;
use App\View_Transaksi;
use App\PL_Stok;
use App\PL_Detail;
use App\PL_Booth;
use App\Top_Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Alert;
use PDF;
use Excel;
use App\Exports\ReportExcel;

class AdminReport extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $booth = $request->id_booth;
        $awal = $request->awal;
        $akhir = $request->akhir;

    	$booths = PL_Booth::all();
        $nb = PL_Booth::where('id_booth',$booth)->first();
        $sales = null;
        $pj = null;
    	$pjk = null;
    	$detail = PL_Detail::join('pl_produk', 'pl_produk.id', '=', 'pl_detail_transaksi.id_produk')
    						->select('pl_detail_transaksi.*','pl_produk.nama_makanan')
    						->get();

        $builder = View_Transaksi::query();
        $builder3 = View_Transaksi::query();
        $builder2 = Top_Product::query();

        $builder2->select(DB::raw('sum(jumlah) as jumlah, nama_makanan, id_booth'));
        $builder3->select(DB::raw('count(id) as trans, jenis, sum(total_bersih) as total_b, sum(total_pajak) as t_pajak'));

    	if(!empty($request->cari)){
            if($awal>$akhir && !empty($awal) && !empty($akhir)){
                Alert::warning('Format Tanggal Salah', 'Gagal');
                return redirect()->back();
            }

            if(empty($booth)){
                $builder->where('id_booth','like','%'.$request->id_booth.'%');
                $builder2->where('id_booth','like','%'.$request->id_booth.'%');
                $builder3->where('id_booth','like','%'.$request->id_booth.'%');
            }
            if(!empty($booth)){
                $builder->where('id_booth',$request->id_booth);
                $builder2->where('id_booth',$request->id_booth);
                $builder3->where('id_booth',$request->id_booth);
            }
    		if(empty($request->akhir) || $awal==$akhir){
            $builder->whereDate('created_at', date('Y-m-d', strtotime($request->awal)));
            $builder2->whereDate('created_at', date('Y-m-d', strtotime($request->awal)));
    		$builder3->whereDate('created_at', date('Y-m-d', strtotime($request->awal)));
                            
	    	}
	    	if(!empty($awal) && !empty($akhir)){
	    		$builder->whereDate('created_at','>=', date('Y-m-d', strtotime($request->awal)))
	    				->whereDate('created_at','<=',date('Y-m-d', strtotime($request->akhir)));
                $builder2->whereDate('created_at','>=', date('Y-m-d', strtotime($request->awal)))
                        ->whereDate('created_at','<=',date('Y-m-d', strtotime($request->akhir)));
                $builder3->whereDate('created_at','>=', date('Y-m-d', strtotime($request->awal)))
                        ->whereDate('created_at','<=',date('Y-m-d', strtotime($request->akhir)));
                               
	    	}
            $sales = $builder->where('status',1)
                            ->orderBy('created_at','desc')
                            ->get();
            $pj = $builder2->groupBy('nama_makanan')
                            ->orderBy('jumlah','desc')
                            ->get();
            $pjk = $builder3->where('status',1)
                            ->groupBy('jenis')
                            ->get();           
            if(count($sales) == null){
                Alert::message('Tidak Ada Data Transaksi');
                return redirect()->back();
            }

           
    	}
    	
    	return view('admin/report', [
    		'booths' => $booths,
    		'sales' => $sales,
    		'detail' => $detail,
            'id_booth' => $booth,
            'awal' => $awal,
            'akhir' => $akhir,
            'nb' => $nb,
            'pj' => $pj,
            'pjk'=> $pjk
    	]);
    }

    public function DownloadPdf(Request $request)
    {
        $booth = $request->id_booth;
        $awal = $request->awal;
        $akhir = $request->akhir;

        $nb = PL_Booth::where('id_booth',$booth)->first();
        $sales = null;
        $pj = null;
        $pjk = null;
        $detail = PL_Detail::join('pl_produk', 'pl_produk.id', '=', 'pl_detail_transaksi.id_produk')
                            ->select('pl_detail_transaksi.*','pl_produk.nama_makanan')
                            ->get();

        $builder = View_Transaksi::query();
        $builder3 = View_Transaksi::query();
        $builder2 = Top_Product::query();

        $builder2->select(DB::raw('sum(jumlah) as jumlah, nama_makanan, id_booth'));
        $builder3->select(DB::raw('count(id) as trans, jenis, sum(total_bersih) as total_b, sum(total_pajak) as t_pajak'));

        if(empty($booth)){
            $builder->where('id_booth','like','%'.$request->id_booth.'%');
            $builder2->where('id_booth','like','%'.$request->id_booth.'%');
            $builder3->where('id_booth','like','%'.$request->id_booth.'%');
        }
        if(!empty($booth)){
            $builder->where('id_booth',$request->id_booth);
            $builder2->where('id_booth',$request->id_booth);
            $builder3->where('id_booth',$request->id_booth);
        }
        if(empty($request->akhir) || $awal==$akhir){
        $builder->whereDate('created_at', date('Y-m-d', strtotime($request->awal)));
        $builder2->whereDate('created_at', date('Y-m-d', strtotime($request->awal)));
        $builder3->whereDate('created_at', date('Y-m-d', strtotime($request->awal)));
                        
        }
        if(!empty($awal) && !empty($akhir)){
            $builder->whereDate('created_at','>=', date('Y-m-d', strtotime($request->awal)))
                    ->whereDate('created_at','<=',date('Y-m-d', strtotime($request->akhir)));
            $builder2->whereDate('created_at','>=', date('Y-m-d', strtotime($request->awal)))
                    ->whereDate('created_at','<=',date('Y-m-d', strtotime($request->akhir)));
            $builder3->whereDate('created_at','>=', date('Y-m-d', strtotime($request->awal)))
                    ->whereDate('created_at','<=',date('Y-m-d', strtotime($request->akhir)));
                           
        }
        $sales = $builder->where('status',1)
                        ->orderBy('created_at','desc')
                        ->get();
        $pj = $builder2->groupBy('nama_makanan')
                        ->orderBy('jumlah','desc')
                        ->get();
        $pjk = $builder3->where('status',1)
                        ->groupBy('jenis')
                        ->get();           

        $pdf = PDF::loadView('admin/report-pdf',[
            'id_booth' => $booth,
            'awal' => $awal,
            'akhir' => $akhir,
            'sales' => $sales,
            'detail' => $detail,
            'nb' => $nb,
            'pj' => $pj,
            'pjk'=> $pjk
        ]);
        $pdf->setPaper('A4', 'Landscape');
        
        return $pdf->stream($awal.'-'.$akhir.' '.$booth.'.pdf');
    }

    public function DownloadExcel(Request $request)
    {
        return (new ReportExcel)->Awal($request->awal)->Akhir($request->akhir)->Id($request->id_booth)->download('LP.xlsx');
    }
}
