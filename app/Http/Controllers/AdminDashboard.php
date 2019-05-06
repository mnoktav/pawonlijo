<?php

namespace App\Http\Controllers;

use App\View_Transaksi;
use App\PL_Booth;
use App\Top_Product;
use App\User;
use App\PL_JenisTransaksi;
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
                ])->validate();
                $akun->username = $request->username;
                $akun->email = $request->email;
                $akun->save();

                Alert::success('Akun Berhasil Diupdate','Berhasil');
                return redirect()->back();
            }else{
                Alert::error('Password yang anda masukkan salah','Password Salah');
                return redirect()->back();
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
                ])->validate();

                $akun->password = Hash::make($request->password_baru);
                $akun->save();

                Alert::success('Akun Berhasil Diupdate','Berhasil');
                return redirect()->back();
            }
            else{
                Alert::error('Password yang anda masukkan salah','Password Salah');
                return redirect()->back();
            }
        }
    }

    public function index()
    {

    	$jenis = PL_JenisTransaksi::groupBy('jenis_transaksi')->get();
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

		$booths = PL_Booth::get();
		
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
                            ->groupBy('nama_makanan')
                            ->orderBy('jumlah','desc')
                            ->limit(5)->get();
        $jt = View_Transaksi::select(DB::raw('count(id) as jid, status, created_at, id_booth'))
        					->where('status', 1)
				            ->whereMonth('created_at',date('m'))
				            ->groupBy('id_booth')
				            ->get();
		$nt = View_Transaksi::orderBy('created_at','desc')
				            ->limit(5)
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
    		'nt' => $nt
    	]);
    }
}
