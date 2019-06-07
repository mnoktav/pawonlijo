<?php

namespace App\Http\Controllers;

use App\User;
use App\PL_Cabang;
use App\PL_Transaksi;
use App\PL_Transaksi_Jenis;
use App\PL_Produk;
use App\View_Transaksi;
use App\Top_Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;  
use Alert;

class AdminDashboard extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function Akun()
    {
        $user = User::first();
        return view('admin/akun',[
            'user' => $user
        ]);
    }

    public function UpdateAkun(Request $request)
    {
        if (!empty($request->update)) {
            $akun = User::find($request->id);
            if (Hash::check($request->password, $akun->password)) {
                $validator = Validator::make($request->all(), [
                    'username' => 'required|min:6',
                    'email' => 'required|email',
                    'password' => 'required'
                    ], [
                        
                    'username.min' => 'Username minimal 6 karakter.'
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('msg', 'akun');
                }
                $akun->username = $request->username;
                $akun->email = $request->email;
                $akun->save();

                Alert::success('Akun Berhasil Diupdate','Berhasil');
                return redirect()->back()->with('msg', 'akun');
            }else{
                Alert::error('Password yang anda masukkan salah','Password Salah');
                return redirect()->back()->with('msg', 'akun');
            }
        }
        elseif(!empty($request->update_p)){
            $akun = User::find($request->id_u);
            if (Hash::check($request->password_l, $akun->password)) {
                $validator = Validator::make($request->all(), [
                    'password_baru' => 'required|min:8',
                    'retype' => 'same:password_baru',
                    'password_l' => 'required'
                    ], [
                        'password_baru.min' => 'password minimal 8 karakter.',
                        'retype.same' => 'Password tidak sama.'
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors()->with('msg', 'password');
                }
                $akun->password = Hash::make($request->password_baru);
                $akun->save();

                Alert::success('Akun Berhasil Diupdate','Berhasil');
                return redirect()->back()->with('msg', 'password');
            }
            else{
                Alert::error('Password yang anda masukkan salah','Password Salah');
                return redirect()->back()->with('msg', 'password');
            }
        }
    }

    public function index()
    {

    	$jenis = PL_Transaksi_Jenis::groupBy('jenis_transaksi')->get();
    	$tb =  View_Transaksi::select(DB::raw('count(id) as jumlah, jenis'))
                            ->whereMonth('created_at',date('n'))
                            ->whereYear('created_at',date('Y'))
                            ->where('status',1)
                            ->groupBy('jenis')
                            ->get();
        $t = ChartIncome('income');
        $bulan =  View_Transaksi::where('status', 1)
				            ->whereMonth('created_at',date('m'))
				            ->whereYear('created_at',date('Y'))
				            ->sum('total_bersih')/1000;
		$pjk =  View_Transaksi::where('status', 1)
				            ->whereMonth('created_at',date('m'))
				            ->whereYear('created_at',date('Y'))
				            ->sum('total_pajak')/1000;

		$booths = PL_Cabang::get();
		
        $hari = null;
		foreach ($booths as $b => $a) {
			for($i=0; $i<=13; $i++){
				$ts = date('Y-m-d');
		        $tsp = date('Y-m-d', strtotime('- '.$i.' days', strtotime($ts)));
		        $hari[$b][$i] =  View_Transaksi::where('id_booth', $a->id_booth)
		        					->where('status', 1)
						            ->whereDate('created_at',$tsp)
						            ->sum('total_bersih')/1000;
		    }
	    }
	    for($i=0; $i<=13; $i++){
	    	$tr = date('Y-m-d');
	    	$lh[$i] = date('d/m', strtotime('- '.$i.' days', strtotime($tr)));
	    }

	    $top = Top_Product::select(DB::raw('sum(jumlah) as jumlah, nama_makanan'))
							->whereMonth('created_at','>=', date('m'))
                            ->whereYear('created_at',date('Y'))
                            ->groupBy('nama_makanan')
                            ->orderBy('jumlah','desc')
                            ->orderBy('nama_makanan','asc')
                            ->limit(5)->get();
        $jt = View_Transaksi::select(DB::raw('count(id) as jid, status, created_at, id_booth'))
        					->where('status', 1)
				            ->whereMonth('created_at',date('m'))
                            ->whereYear('created_at',date('Y'))
				            ->groupBy('id_booth')
				            ->get();
		$nt = View_Transaksi::orderBy('created_at','desc')
				            ->limit(5)
				            ->get();
        $pie = View_Transaksi::select(DB::raw(' Round(sum(total_bersih)/(select sum(total_bersih) from view_transaksi where status = 1) * 100) 
as persen, id_booth, nama_booth'))
                            ->where('status', 1)
                            ->whereMonth('created_at',date('m'))
                            ->whereYear('created_at',date('Y'))
                            ->groupBy('id_booth')
                            ->get();
        
    	return view('admin/dashboard',[
    		'jenis' => $jenis,
    		'tb' => $tb,
    		'income' => $t,
    		'bulan' => $bulan,
    		'pajak' => $pjk,
    		'booths' => $booths,
    		'hari' => $hari,
    		'lh' => $lh,
    		'top' => $top,
    		'jt' => $jt,
    		'nt' => $nt,
            'pie' => $pie
    	]);
    }
}
