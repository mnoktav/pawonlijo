<?php

namespace App\Http\Controllers;

use App\PL_Booth;
use App\PL_Kasir;
use App\PL_Note;
use App\PL_Transaksi;
use App\View_Transaksi;
use App\PL_JenisTransaksi;
use App\PL_Product;
use App\Top_Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;  
use Illuminate\Support\Facades\Crypt;
use Alert;

class AdminBooth extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	//booth
	public function Booth()
    {
        $booths = PL_Booth::all();
        $kasirs = PL_Kasir::all();
        
    	return view('admin/booth',[
            'booths' => $booths,
            'kasirs' => $kasirs
        ]);
    }

    public function DetailBooth(Request $request)
    {

        $id = $request->id_booth;
        $booth = PL_Booth::where('id_booth',$id)->first();
       
        return view('admin/booth-detail',[
            'booth' => $booth
        ]);
    }

    public function DetailBoothHome(Request $request)
    {
        $id = $request->id_booth;
        $booth = PL_Booth::where('id_booth',$id)->first();
        $kasirs = PL_Kasir::where('id_booth',$id)->get();
        $jumlah_kasir = PL_Kasir::where('id_booth',$id)->count();
        $jenis = PL_JenisTransaksi::where('id_booth',$id)->orderBy('pajak','desc')->get();
        return view('admin/booth-detail-home',[
            'booth' => $booth,
            'kasirs' => $kasirs,
            'jumlah_kasir' => $jumlah_kasir,
            'jenis' => $jenis
        ]);
    }

    public function DetailBoothTransaksi(Request $request)
    {
        $id = $request->id_booth;
        $booth = PL_Booth::where('id_booth',$id)->first();
        $sales = View_Transaksi::where('id_booth', $id)
                            ->orderBy('id','desc')
                            ->get();

        return view('admin/booth-detail-transaksi',[
            'id' => $id,
            'booth' => $booth,
            'sales' => $sales
        ]);
    }

    public function DetailBoothInfo(Request $request)
    {
        $id = $request->id_booth;
        $booth = PL_Booth::where('id_booth',$id)->first();
        $income = ChartIncomeBooth($id,'income');
        $pjk = ChartIncomeBooth($id,'tax');
        $income_h = ChartIncomeBoothH($id,'transaksi');
        $label_h = ChartIncomeBoothH($id,'label');
        $tax_h = ChartIncomeBoothH($id,'tax');
        //transaksi
        if (empty($request->bulan)) {
            $b = date('n');
        }
        else{
            $b = $request->bulan;
        }
        $tb =  View_Transaksi::select(DB::raw('count(id) as trans, jenis, sum(total_bersih) as total_b, sum(total_pajak) as t_pajak'))
                            ->where('id_booth',$id)
                            ->whereMonth('created_at',$b)
                            ->whereYear('created_at',date('Y'))
                            ->where('status',1)
                            ->groupBy('jenis')
                            ->get();
        $p = Top_Product::select(DB::raw('sum(jumlah) as jumlah, nama_makanan, id_booth'))
                        ->where('id_booth',$request->id_booth)
                        ->whereMonth('created_at',$b)
                        ->whereYear('created_at',date('Y'))
                        ->groupBy('nama_makanan')
                        ->orderBy('jumlah','desc')
                        ->get();

        // if(count($tb) == null){
        //     Alert::message('Tidak Ada Data Transaksi '.BulanIndo($request->bulan).' '.date('Y'));
        //     return redirect()->back();
        // }                                 
        return view('admin/booth-detail-info',[
            'id' => $id,
            'booth' => $booth,
            'income' => $income,
            'tb' => $tb,
            'pj' => $p,
            'b' => $b,
            'lb'=> $label_h,
            'th' => $income_h,
            'pjk' => $pjk,
            'tax_h' => $tax_h
        ]);
    }
    //Jenis Transaksi
    public function JenisTransaksi()
    {
        $jenis = PL_JenisTransaksi::groupBy('jenis_transaksi')
                                    ->orderBy('pajak','desc')
                                    ->get();
        $booths = PL_Booth::all();
        $tax = View_transaksi::select(DB::raw('sum(total_pajak) as pajak, date(created_at) as tanggal, jenis , id_booth'))
                                ->where('status',1)
                                ->where('pajak','>',0)
                                ->groupBy('jenis','id_booth', 'tanggal')
                                ->orderBy('tanggal','asc')
                                ->orderBy('id_booth')
                                ->get();
        
        return view('admin/booth-jenis-transaksi',[
            'jenis' => $jenis,
            'booths' => $booths,
            'tax' => $tax
        ]);
    }
    public function ActTrans(Request $request)
    {
        PL_JenisTransaksi::find($request->id)
                    ->update([
                'status' => $request->status
            ]);

        Alert::success('Berhasil Update');
        return redirect()->back();
    }
    public function UpdatePajak(Request $request)
    {
        PL_JenisTransaksi::where('jenis_transaksi',$request->jenis_transaksi)
                    ->update([
                'pajak' => $request->pajak
            ]);
        Alert::success('Berhasil Update');
        return redirect()->back();
    }
    public function DetailPajak(Request $request)
    {
        $detail = View_transaksi::where('status',1)
                                ->where('id_booth', $request->id)
                                ->whereDate('created_at', $request->tgl)
                                ->where('jenis', $request->jenis)
                                ->get();
        return view('admin/booth-jenis-transaksi-pajak',[
            'detail' => $detail
        ]);
    }
    //Update booth
    public function EditBooth(Request $request)
    {
        $id = $request->id_booth;
        $booth = PL_Booth::where('id_booth',$id)->first();
        $kasirs = PL_Kasir::where('id_booth',$id)->get();
        $jumlah_kasir = PL_Kasir::where('id_booth',$id)->count();
        $max = PL_Kasir::max('id');
        $max = $max+1;
        return view('admin/booth-edit',[
            'booth' => $booth,
            'kasirs' => $kasirs,
            'jumlah_kasir' => $jumlah_kasir,
            'max' => $max
        ]);
    }
    public function UpdateBooth(Request $request)
    {
        if ($request->update_booth != null) {

            PL_Booth::where('id_booth',$request->id_booth)
                    ->update([
                'nama_booth' => $request->nama_booth,
                'alamat_booth' => $request->alamat_booth,
                'kota_booth' => $request->kota,
                'jam_buka' => $request->jam_buka,
                'jam_tutup' => $request->jam_tutup,
                'telepon_booth' => $request->nomor
            ]);

            Alert::success('Berhasil Update Data '.$request->nama_booth.' ('.$request->id_booth.')', 'Berhasil');
            return redirect()->back()->with('msg', 'booth');
        }
        elseif($request->update_akun != null){

            $validator = Validator::make($request->all(), [
                'username_booth' => 'required|min:4',
                'password_booth' => 'required|min:8',
                're_pass' => 'same:password_booth'
            ], [
                
                'username_booth.required' => 'Username harus diisi.',
                'username_booth.min' => 'Username minimal 4 karakter.',
                'password_booth.required' => 'Password harus diisi.',
                'password_booth.min' => 'Password minimal 8 karakter.',
                're_pass.same' => 'Password tidak sama.',
                'username_booth.unique' => 'Username booth sudah digunakan.'
            ])->validate();

            PL_Booth::where('id_booth',$request->id_booth)
                    ->update([
                'username_booth' => $request->username_booth,
                'password_booth' => Crypt::encryptString($request->password_booth)
                
            ]);

            Alert::success('Berhasil Update Data '.$request->nama_booth.' ('.$request->id_booth.')', 'Berhasil');
            return redirect()->back()->with('msg', 'akun');
        }
        elseif($request->update_kasir1 != null){

            for ($i=0; $i < count($request->nama_kasir); $i++) {
                if($request->nama_kasir[$i] != null){
                    PL_Kasir::updateOrCreate(
                        ['id' => $request->id_kasir[$i], 'id_booth' => $request->id_booth[$i]],
                        [
                            'nama_kasir' => $request->nama_kasir[$i],
                            'alamat_kasir' => $request->alamat_kasir[$i],
                            'telp_kasir' => $request->telp_kasir[$i]
                        ]
                    );
                }
            }

            Alert::success('Berhasil Update Data Kasir', 'Berhasil');
            return redirect()->back()->with('msg', 'pegawai');
        }
        
    }
    //Delete KAsir

    public function DeleteKasir(Request $request)
    {
        $delete = PL_Kasir::find($request->id);

        $delete->delete();

        Alert::success('Berhasil Hapus Data Kasir', 'Berhasil');
        return redirect()->back();
    }

    //add booth
    public function AddBooth()
    {
    	return view('admin/booth-add-step1');
    }
    public function Step2()
    {
        if(session('step1')==null){
            return redirect()->route('admin.add-booth');
        }else{
            return view('admin/booth-add-step2');
        }
        
    }
    public function Step3()
    {
        if(session('step2')==null){
            return redirect()->route('admin.add-booth-step2');
        }else{
            return view('admin/booth-add-step3');
        }
        
    }
    public function Step4()
    {
        if(session('step3')==null){
            return redirect()->route('admin.add-booth-step3');
        }else{
            return view('admin/booth-add-step4');
        }
    }
    public function Step5()
    {
        if(session('finish')==null){
            return redirect()->route('admin.add-booth-step4');
        }else{
        
            $products = PL_Product::where('status',1)
                        ->groupBy('nama_makanan')
                        ->get();
            $booth = PL_Booth::max('id_booth');

            return view('admin/booth-add-step5',[
                'products' => $products,
                'booth' => $booth
            ]);
        }
    }
    public function SaveStep(Request $request)
    {
        if($request->step1 != null){

            $validator = Validator::make($request->all(), [
                'id_booth' => 'required|unique:pl_booth,id_booth',
                'nama_booth' => 'required|unique:pl_booth,nama_booth'
            ], [
                'id_booth.required' => 'ID booth harus diisi.',
                'id_booth.unique' => 'ID sudah digunakan.',
                'nama_booth.required' => 'Nama booth harus diisi.',
                'nama_booth.unique' => 'Nama booth sudah digunakan.'
            ])->validate();
            
            
            $boothValue = [
                'time' => date('H:i'),
                'id_booth' => $request->id_booth,
                'nama_booth' => $request->nama_booth,
                'alamat_booth' => $request->alamat_booth,
                'kota' => $request->kota,
                'jam_buka' => $request->jam_buka,
                'jam_tutup' => $request->jam_tutup,
                'nomor' => $request->nomor
            ];

            session()->put('step1', $boothValue);
            return redirect()->route('admin.add-booth-step2');
        }
        elseif($request->step3 != null){

            $boothValue = [
                'nama_kasir1' => $request->nama_kasir1,
                'alamat_kasir1' => $request->alamat_kasir1,
                'no_kasir1' => $request->no_kasir1,
                'nama_kasir2' => $request->nama_kasir2,
                'alamat_kasir2' => $request->alamat_kasir2,
                'no_kasir2' => $request->no_kasir2
            ];

            session()->put('step3', $boothValue);
            return redirect()->route('admin.add-booth-step4');
        }
        elseif ($request->step2 != null) {
            $validator = Validator::make($request->all(), [
                'username_booth' => 'required|min:4|unique:pl_booth,username_booth',
                'password_booth' => 'required|min:8',
                're_pass' => 'same:password_booth'
            ], [
                
                'username_booth.required' => 'Username harus diisi.',
                'username_booth.min' => 'Username minimal 4 karakter.',
                'password_booth.required' => 'Password harus diisi.',
                'password_booth.min' => 'Password minimal 8 karakter.',
                're_pass.same' => 'Password tidak sama.',
                'username_booth.unique' => 'Username booth sudah digunakan.'
            ])->validate();

            $boothValue = [
                'username_booth' => $request->username_booth,
                'password_booth' => $request->password_booth,
                're_pass' => $request->re_pass
            ];

            session()->put('step2', $boothValue);
            return redirect()->route('admin.add-booth-step3');

        }
        elseif ($request->finish != null) {
            PL_Booth::create([
                'id_booth' => $request->id_booth,
                'nama_booth' => $request->nama_booth,
                'alamat_booth' => $request->alamat_booth,
                'kota_booth' => $request->kota,
                'jam_buka' => $request->jam_buka,
                'jam_tutup' => $request->jam_tutup,
                'telepon_booth' => $request->nomor,
                'username_booth' => $request->username_booth,
                'password_booth' => Crypt::encryptString($request->password_booth),
                'status' => 1
            ]);

            for ($i=0; $i < count($request->nama_kasir) ; $i++) {
                if($request->nama_kasir[$i] != null){
                    PL_Kasir::create([
                        'nama_kasir' => $request->nama_kasir[$i],
                        'alamat_kasir' => $request->alamat_kasir[$i],
                        'telp_kasir' => $request->no_kasir[$i],
                        'id_booth' => $request->id_booth
                    ]);
                }
            }
            for ($i=1; $i <= 3 ; $i++) { 
                session()->forget('step'.$i);
            }
            session()->put('finish', 'finish');
            return redirect()->route('admin.add-booth-step5');
        }
        elseif($request->selesai != null){
            if(!empty($request->nama_makanan)){
                for ($i=0; $i < count($request->nama_makanan) ; $i++) { 
                    PL_Product::create([
                        'nama_makanan' => $request->nama_makanan[$i],
                        'kategori' => $request->kategori[$i],
                        'harga_reguler' => $request->reguler[$i],
                        'harga_gojek' => $request->gojek[$i],
                        'harga_grab' => $request->grab[$i],
                        'id_booth' => $request->id_booth,
                        'status' => 1
                    ]);
                }
            }

            
            $jenis = PL_JenisTransaksi::groupBy('jenis_transaksi')
                                    ->get();
            foreach($jenis as $j){
                PL_JenisTransaksi::create([
                    'jenis_transaksi' => $j->jenis_transaksi,
                    'pajak' => $j->pajak,
                    'status' => 1,
                    'id_booth' => $request->id_booth
                ]);
            }
            session()->forget('finish');

            Alert::success('Menu Berhasil Ditambahkan', 'Berhasil');
            return redirect()->route('admin.booth');
        }
    }

    public function NonBooth($id)
    {
        PL_Booth::where('id_booth',$id)
                ->update([
                    'status' => 0
                ]);
        
        Alert::success('Booth Berhasil Dinonaktifkan', 'Berhasil');
        return redirect()->route('admin.booth');
    }

    public function ActBooth($id)
    {
        PL_Booth::where('id_booth',$id)
                ->update([
                    'status' => 1
                ]);
        
        Alert::success('Booth Berhasil Aktifkan', 'Berhasil');
        return redirect()->route('admin.booth');
    }


    //note-booth
    public function NoteBooth()
    {
        $notes = DB::table('pl_note')
                ->join('pl_booth','pl_note.id_booth','=','pl_booth.id_booth')
                ->select(DB::raw('pl_note.*, pl_booth.nama_booth, GROUP_CONCAT(nama_booth SEPARATOR ", ") as nama_booth '))
                ->groupBy('judul')
                ->get();

    	return view('admin/booth-note',[
            'notes' => $notes
        ]);
    }
    public function AddNoteBooth()
    {
        $booths = PL_Booth::where('status', 1)->get();
        return view('admin/booth-note-add',[
            'booths' => $booths
        ]);
    }
    public function SaveNote(Request $request)
    {
        
        if($request->save != null){
            $validator = Validator::make($request->all(), [
                'id_booth' => 'required',
                'judul' => 'unique:pl_note,judul'
            ], [
                'id_booth.required' => 'Pilih booth terlebih dahulu.',
                'judul.unique' => 'Judul tidak boleh sama.'
            ])->validate();

            for ($i=0; $i < count($request->id_booth) ; $i++) { 
                PL_Note::create([
                    'judul' => $request->judul,
                    'pesan' => $request->pesan,
                    'id_booth' => $request->id_booth[$i],
                    'status' => 1
                ]);
            }

            Alert::success('Berhasil Tambah Note Baru', 'Berhasil');
            return redirect()->route('admin.note-booth');
        }
    }

    public function DeleteNote(Request $request)
    {
        $judul = $request->judul;
        $delete = PL_Note::where('judul',$judul)->delete();

        Alert::success('Berhasil Hapus Note', 'Berhasil');
        return redirect()->route('admin.note-booth');
    }
}
