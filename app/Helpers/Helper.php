<?php
use App\PL_Transaksi;
use App\PL_Booth;
use App\PL_Stok;
use App\Top_Product;

function Nominal($value)
{
	
	$cari_koma = strpos($value,',');
	
	if($cari_koma == null){
		$value = str_replace('.','',$value);
	}else{
		$value = str_replace('.','',$value);
		$value = substr($value,0,-3);
	}

	return $value;
}

function GetSelected($jenis,$string)
{
	if(!is_null($jenis))
		if(in_array($string, $jenis)){
			return true;
		}
		else{
			return false;
		}
	else{
		return false;
	}
}

function PesananPending()
{
	$count = PL_Transaksi::where('jenis', 'Pesanan')
							->where('status',2)
							->count('id');
	return $count;
}

function StatusBooth($id)
{
	$booth = PL_Booth::where('id_booth',$id)->first();

	if($booth->status != 1){
		$session = session()->forget('login');
	}
	else{
		$session = null;
	}
	return $session;
}

function StringToInt($string)
{
	$convert = array_map('intval', $string);

	return json_encode($convert);
}

function ChartTransaksi()
{
	for($i=1; $i<=date('m'); $i++){
        $bulant[$i] =  PL_Transaksi::select(DB::raw('count(id) as id, status, created_at'))
        					->where('status', 1)
				            ->whereMonth('created_at',$i)
				            ->whereYear('created_at',date('Y'))
				            ->count('id');
    }

    return $bulant;
}

function ChartIncome()
{
	for($i=1; $i<=date('m'); $i++){
        $bulanI[$i] =  PL_Transaksi::where('status', 1)
				            ->whereMonth('created_at',$i)
				            ->whereYear('created_at',date('Y'))
				            ->sum('total');
    }

    return $bulanI;
}

function ProdukTerjual($produk,$booth,$param)
{

	for($i=0; $i<=13; $i++){
		$ts = date('Y-m-d');
        $tsp = date('Y-m-d', strtotime('- '.$i.' days', strtotime($ts)));
        $produkh[$i] =  Top_Product::where('id_produk',$produk)
        					->where('id_booth',$booth)
        					->where('status',1)
				            ->whereDate('created_at', $tsp)
				            ->sum('jumlah');

		$label[$i] = date('d/m/y', strtotime('- '.$i.' days', strtotime($ts)));
    }


    if($param == 'label'){
		return $label;

	}elseif($param == 'produk'){
		return $produkh;
	}

}

function ProdukTerjualB($produk,$booth)
{

	for($i=1; $i<=12; $i++){
        $produkb[$i] =  Top_Product::where('id_produk',$produk)
        					->where('id_booth',$booth)
        					->where('status',1)
				            ->whereMonth('created_at',$i)
				            ->whereYear('created_at',date('Y'))
				            ->sum('jumlah');

    }

	return $produkb;


}

function StokProduct($id,$param)
{
	for($i=0; $i<=13; $i++){
		$ts = date('Y-m-d');
        $tsp = date('Y-m-d', strtotime('- '.$i.' days', strtotime($ts)));
        $produk[$i] =  PL_Stok::where('id_produk',$id)
				            ->whereDate('created_at', $tsp)
				            ->pluck('sisa_stok');

		$label[$i] = date('d/m/y', strtotime('- '.$i.' days', strtotime($ts)));
    }

    if($param == 'label'){
		return $label;

	}elseif($param == 'produk'){
		return $produk;
	}
}
?>