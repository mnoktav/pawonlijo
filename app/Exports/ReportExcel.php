<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;
use App\PL_Produk;
use App\PL_Transaksi;
use App\View_Transaksi;
use App\PL_Porduk_Stok;
use App\PL_Transaksi_Detail;
use App\PL_Cabang;
use App\Top_Product;

class ReportExcel implements FromView
{
    use Exportable;

    public function Awal($awal)
    {
        $this->awal = $awal;
        return $this;
    }

    public function Akhir($akhir)
    {
        $this->akhir = $akhir;
        return $this;
    }

    public function Id($id)
    {
        $this->id = $id;
        return $this;
    }

    public function view(): View
    {

        $nb = PL_Cabang::where('id_booth',$this->id)->first();
        $sales = null;
        $pj = null;
        $pjk = null;
        $detail = PL_Transaksi_Detail::join('pl_produk', 'pl_produk.id', '=', 'pl_transaksi_detail.id_produk')
                            ->select('pl_transaksi_detail.*','pl_produk.nama_makanan')
                            ->get();

        $builder = View_Transaksi::query();
        $builder3 = View_Transaksi::query();
        $builder2 = Top_Product::query();

        $builder2->select(DB::raw('sum(jumlah) as jumlah, nama_makanan, id_booth'));
        $builder3->select(DB::raw('count(id) as trans, jenis, sum(total_bersih) as total_b, sum(total_pajak) as t_pajak'));

        if(empty($this->id)){
            $builder->where('id_booth','like','%'.$this->id.'%');
            $builder2->where('id_booth','like','%'.$this->id.'%');
            $builder3->where('id_booth','like','%'.$this->id.'%');
        }
        if(!empty($this->id)){
            $builder->where('id_booth',$this->id);
            $builder2->where('id_booth',$this->id);
            $builder3->where('id_booth',$this->id);
        }
        if(empty($this->akhir) || $this->awal==$this->akhir){
        $builder->whereDate('created_at', date('Y-m-d', strtotime($this->awal)));
        $builder2->whereDate('created_at', date('Y-m-d', strtotime($this->awal)));
        $builder3->whereDate('created_at', date('Y-m-d', strtotime($this->awal)));
                        
        }
        if(!empty($this->awal) && !empty($this->akhir)){
            $builder->whereDate('created_at','>=', date('Y-m-d', strtotime($this->awal)))
                    ->whereDate('created_at','<=',date('Y-m-d', strtotime($this->akhir)));
            $builder2->whereDate('created_at','>=', date('Y-m-d', strtotime($this->awal)))
                    ->whereDate('created_at','<=',date('Y-m-d', strtotime($this->akhir)));
            $builder3->whereDate('created_at','>=', date('Y-m-d', strtotime($this->awal)))
                    ->whereDate('created_at','<=',date('Y-m-d', strtotime($this->akhir)));
                           
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

        return view('admin/report-excel', [
            'id_booth' => $this->id,
            'awal' => $this->awal,
            'akhir' => $this->akhir,
            'sales' => $sales,
            'detail' => $detail,
            'nb' => $nb,
            'pj' => $pj,
            'pjk'=> $pjk
        ]);
        //
    }
}
