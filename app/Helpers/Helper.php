<?php
use App\PL_Transaksi;
use App\PL_Cabang;
use App\PL_Produk_Stok;
use App\PL_Produk_Harga;
use App\Top_Product;
use App\PL_Transaksi_Jenis;
use App\View_Transaksi;
use App\View_Produk_Kasir;

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

function BulanIndo($x)
{
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);

	return $bulan[$x];
}

function NamaBulan()
{
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);

	return $bulan;
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
	$count = View_Transaksi::where('jenis', 'Pesanan')
							->where('status',2)
							->count('id');
	return $count;
}

function PesananPendingB($id)
{
	$count = View_Transaksi::where('jenis', 'Pesanan')
							->where('status',2)
							->where('id_booth',$id)
							->count('id');
	return $count;
}


function SessionCart()
{
	if(session()->get('cart') != null){
		if (Request::segment(2) != 'product' and Request::segment(2) != 'checkout' and Request::segment(2) != 'print-nota') {
			$session = 'hapus';
		}
		else{
			$session = null;
		}

		return $session;
	}
}
function StringToInt($string)
{
	$convert = array_map('intval', $string);

	return json_encode($convert);
}

function ChartTransaksi()
{
	for($i=1; $i<=date('m'); $i++){
        $bulant[$i] =  PL_Transaksi::where('status', 1)
				            ->whereMonth('created_at',$i)
				            ->whereYear('created_at',date('Y'))
				            ->count('id');
    }

    return $bulant;
}

function ChartIncome($param)
{
	for($i=1; $i<=date('m'); $i++){
        $bulan[$i] =  View_Transaksi::where('status', 1)
				            ->whereMonth('created_at',$i)
				            ->whereYear('created_at',date('Y'))
				            ->sum('total_bersih')/1000;
    }

    for($i=1; $i<=date('m'); $i++){
        $pjk[$i] =  View_Transaksi::where('status', 1)
				            ->whereMonth('created_at',$i)
				            ->whereYear('created_at',date('Y'))
				            ->sum('total_pajak')/1000;
    }

    if($param == 'income'){
		return $bulan;
	}elseif($param == 'tax'){
		return $pjk;
	}
}

function ChartIncomeBooth($id,$param)
{
	for($i=1; $i<=date('m'); $i++){
        $bulanI[$i] =  View_Transaksi::where('id_booth',$id)
        					->where('status', 1)
				            ->whereMonth('created_at',$i)
				            ->whereYear('created_at',date('Y'))
				            ->sum('total_bersih')/1000;
    }

    for($a=1; $a<=date('m'); $a++){
        $pb[$a] =  View_Transaksi::where('id_booth',$id)
        					->where('status', 1)
				            ->whereMonth('created_at',$a)
				            ->whereYear('created_at',date('Y'))
				            ->sum('total_pajak')/1000;
    }
    if($param == 'income'){
		return $bulanI;
	}elseif($param == 'tax'){
		return $pb;
	}
    
}

function ChartIncomeBoothH($id,$param)
{
	for($i=0; $i<=13; $i++){
		$ts = date('Y-m-d');
        $tsp = date('Y-m-d', strtotime('- '.$i.' days', strtotime($ts)));
        $hari[$i] =  View_Transaksi::where('id_booth',$id)
        					->where('status', 1)
				            ->whereDate('created_at',$tsp)
				            ->sum('total_bersih')/1000;
				            
		$label[$i] = date('d/m/y', strtotime('- '.$i.' days', strtotime($ts)));
    }

    for($i=0; $i<=13; $i++){
		$ts = date('Y-m-d');
        $tsp = date('Y-m-d', strtotime('- '.$i.' days', strtotime($ts)));
        $pjk[$i] =  View_Transaksi::where('id_booth',$id)
        					->where('status', 1)
				            ->whereDate('created_at',$tsp)
				            ->sum('total_pajak')/1000;

    }

    if($param == 'label'){
		return $label;
	}elseif($param == 'transaksi'){
		return $hari;
	}
	elseif($param == 'tax'){
		return $pjk;
	}
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
        $produk[$i] =  PL_Produk_Stok::where('id_produk',$id)
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

function StokProductTerjual($id)
{
	for($i=0; $i<=13; $i++){
		$ts = date('Y-m-d');
        $tsp = date('Y-m-d', strtotime('- '.$i.' days', strtotime($ts)));
        $produk[$i] =  PL_Produk_Stok::where('id_produk',$id)
				            ->whereDate('created_at', $tsp)
				            ->select(DB::raw('(total_stok-sisa_stok) as terjual'))
				            ->pluck('terjual');
    }

	return $produk;
}

function PajakTrans($jenis,$booth)
{
	$data = PL_Transaksi_Jenis::where('jenis_transaksi',$jenis)
							->where('id_booth',$booth)
							->first();
	return $data;
}

function Terbilang($x) {
  $angka = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
  if ($x < 12)
    return " " . $angka[$x];
  elseif ($x < 20)
    return Terbilang($x - 10) . " belas";
  elseif ($x < 100)
    return Terbilang($x / 10) . " puluh" . terbilang($x % 10);
  elseif ($x < 200)
    return " seratus" . Terbilang($x - 100);
  elseif ($x < 1000)
    return Terbilang($x / 100) . " ratus" . terbilang($x % 100);
  elseif ($x < 2000)
    return " seribu" . Terbilang($x - 1000);
  elseif ($x < 1000000)
    return Terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
  elseif ($x < 1000000000)
    return Terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
}

function Rupiah($number)
{
	$number = number_format($number,2,',','.');
	return $number;
}

function Rupiahd($number)
{
	$number = number_format($number,0,'','.');
	return $number;
}

function GetHarga($id1,$id2)
{
	$a = View_Produk_Kasir::where('id_produk',$id1)
						->where('jenis_transaksi',$id2)
						->first();
	return $a['harga'];
}
?>