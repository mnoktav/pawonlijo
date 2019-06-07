<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\PL_Cabang;
use Validator;
use Alert;

class KasirLogin extends Controller
{
    public function index()
    {
    	return view('kasir/login');
    }

    public function Login(Request $request)
    {
    	if(!is_null($request->login)){
    		 $validator = Validator::make($request->all(), [
                'username_booth' => 'required',
                'password_booth' => 'required'
            ], [
                
                'username_booth.required' => 'Username tidak boleh kosong.',
                'password_booth.required' => 'Password tidak boleh kosong.'
             
            ])->validate();

    		if(!is_null($request->username_booth) and !is_null($request->password_booth)){

    			$find = PL_Cabang::where('username_booth',$request->username_booth)->first();

    			if(!is_null($find)){
    				if( date('H:i') < date('H:i',strtotime($find->jam_buka)) || date('H:i') > date('H:i',strtotime($find->jam_tutup)) ){

    					Alert::warning('Sistem Offline','Offline');
	    				return redirect()->back();
    				}elseif($find->status != 1){

    					Alert::warning('Booth Sedang Tidak Aktif','Nonaktif');
	    				return redirect()->back();
    				}
    				else{
    					if(Crypt::decryptString($find->password_booth) == $request->password_booth){
	    					$login = [
	    						'id_booth' => $find->id_booth,
	    						'username_booth' => $find->username_booth,
	    						'nama_booth' => $find->nama_booth,
	    						'kota_booth' => $find->kota_booth,
	    						'token' => $request->_token
	    					]; 

	    					session()->put('login', $login);

	    					Alert::success('Selamat Datang '.$find->id_booth,'Berhasil');
	    					return redirect()->route('kasir.dashboard');

	    				}
	    				else{
	    					Alert::warning('Username atau Password Salah','Gagal');
	    					return redirect()->back();
	    				}
    				}
    				
    			}
    			else{
    				Alert::warning('Username atau Password Salah','Gagal');
    				return redirect()->back();
    			}
    		}
    	}
    }
    public function Logout()
    {
    	session()->forget('login');
    	return redirect()->route('kasir.dashboard');
    }
}
