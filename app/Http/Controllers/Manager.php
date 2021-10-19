<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class Manager extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;
        $data = [
            'title' =>  'Observasi',
            'observasi' =>  DB::table('hseobs')->leftJoin('positions','positions.id_positions','=','hseobs.event')->where('hseobs.user_id',Auth::user()->id)->where('conditions',null)->orWhere('conditions',1)->get(),
            'user' =>  DB::table('users')->where('role',2)->get(),
            'statistik' =>  DB::table('submission_observasi')->where('user_mananger_id',Auth::user()->id)->limit(10)->get(),
            'area' =>   DB::table('positions')->get(),
            'statistik_data' =>  DB::table('submission_observasi')->where('user_mananger_id',Auth::user()->id)->first(),
            'statistik_count' =>  DB::table('submission_observasi')->where('user_mananger_id',Auth::user()->id)->count(),
            'profile'   =>  DB::table('profile')->first(),
            'real_time' =>  DB::table('real_time_observasi')->get()
        ];

        return view('meneger.index',$data);
    }

    public function cari_mananger(Request $request)
    {
        $request->validate([
            'waktu' =>  'required',
            'area'  =>  'required'
        ]);

        $result = DB::table('submission_observasi')->where('waktu_submission',$request->waktu)->where('area_submission',$request->area)->where('user_mananger_id',Auth::user()->id)->limit(10)->count();
        if($result) {
            $data = [
                'title' =>  'Observasi',
                'observasi' =>  DB::table('hseobs')->leftJoin('positions','positions.id_positions','=','hseobs.event')->where('hseobs.user_id',Auth::user()->id)->where('conditions',null)->orWhere('conditions',1)->get(),
                'user' =>  DB::table('users')->where('role',2)->get(),
                'statistik' =>  DB::table('submission_observasi')->where('waktu_submission',$request->waktu)->where('area_submission',$request->area)->where('user_mananger_id',Auth::user()->id)->where('user_mananger_id',Auth::user()->id)->limit(10)->get(),
                'area' =>   DB::table('positions')->get(),
                'statistik_data' =>  DB::table('submission_observasi')->where('user_mananger_id',Auth::user()->id)->first(),
                'statistik_count' =>  DB::table('submission_observasi')->where('user_mananger_id',Auth::user()->id)->count(),
                'profile'   =>  DB::table('profile')->first()
            ];
    
            return view('meneger.index',$data);
        } else {
            return redirect('/home_manager')->with('status','Data Tidak Di Temukan');
        }
    }
  
    public function jam_monitoring()
    {
        $data = [
            'title' =>  'Report Perhari',
            'observasi' =>  DB::table('hseobs')->join('positions','positions.id_positions','=','hseobs.event')->where('user_id',Auth::user()->id)->where('conditions',null)->orWhere('conditions',1)->get(),
            'user' =>  DB::table('users')->where('role',2)->get(),
            'jam'   =>  DB::table('times_presentasi_proses')->get(),
            'profile'   =>  DB::table('profile')->first()
        ];

        return view('meneger.jam',$data);
    }

    public function detail($id,$hari)
    {
        $data = [
            'title' =>  'Report Perhari',
            'observasi' =>  DB::table('hseobs')->join('positions','positions.id_positions','=','hseobs.event')->where('user_id',Auth::user()->id)->where('dibuat_hseobs',$hari)->get(),
            'user' => DB::table('users')->join('laporan_perhari','laporan_perhari.user_pengawas_id','=','users.id')->where('role',1)->where('mananger_user',Auth::user()->email)->where('time_perhari',$hari)->get(),
            'jam'   =>  DB::table('times_presentasi_proses')->get(),
            'hari' =>   $hari,
            'profile'   =>  DB::table('profile')->first()
        ];

        return view('meneger.detail_waktu',$data);
    }

    public function detail_observasi($point,$hari)
    {
        $id = DB::table('users')->where('id',$point)->first();
        $data = [
            'title' =>  'Report Perhari',
            'observasi' =>  DB::table('hseobs')->join('positions','positions.id_positions','=','hseobs.event')->where('user_id',Auth::user()->id)->where('hse_nik',$id->email)->where('dibuat_hseobs',$hari)->get(),
            'user' =>  DB::table('users')->where('role',1)->where('mananger_user',Auth::user()->email)->get(),
            'jam'   =>  DB::table('times_presentasi_proses')->get(),
            'id'    =>  $point,
            'hari'  =>  $hari,
            'profile'   =>  DB::table('profile')->first()
        ];

        return view('meneger.detail_observasi',$data);
    }

    public function detail_perminggu_user_id($point,$hari)
    {
        $id = DB::table('users')->where('id',$point)->first();
        $data = [
            'title' =>  'Detail Report Per Minggu',
            'observasi' =>  DB::table('hseobs')->join('positions','positions.id_positions','=','hseobs.event')->where('user_id',Auth::user()->id)->where('hse_nik',$id->email)->where('minggu',$hari)->get(),
            'user' =>  DB::table('users')->where('role',1)->where('mananger_user',Auth::user()->email)->get(),
            'jam'   =>  DB::table('times_presentasi_proses')->get(),
            'id'    =>  $point,
            'hari'  =>  $hari,
            'profile'   =>  DB::table('profile')->first()
        ];

        return view('meneger.deail_perminggu_user',$data);
    }

    public function laporan_minggu()
    {
        $data = [
            'title' =>  'Report Per Minggu',
            'observasi' =>  DB::table('hseobs')->join('positions','positions.id_positions','=','hseobs.event')->where('user_id',Auth::user()->id)->get(),
            'user' =>  DB::table('users')->where('role',1)->where('mananger_user',Auth::user()->email)->get(),
            'jam'   =>  DB::table('times_presentasi_proses')->get(),
            'minggu'    =>  DB::table('laporan_minggu')->where('user_mananger_id',Auth::user()->id)->get(),
            'profile'   =>  DB::table('profile')->first()
        ];

        return view('meneger.minggu',$data);
    }

    public function detail_perminggu($id,$hari)
    {
        $kemarin_enam = date('Y-m-d', strtotime("-6 day", strtotime(date("Y-m-d",strtotime(($hari))))));
        $kemarin_lima = date('Y-m-d', strtotime("-5 day", strtotime(date("Y-m-d",strtotime(($hari))))));
        $kemarin_empat = date('Y-m-d', strtotime("-4 day", strtotime(date("Y-m-d",strtotime(($hari))))));
        $kemarin_tiga = date('Y-m-d', strtotime("-3 day", strtotime(date("Y-m-d",strtotime(($hari))))));
        $kemarin_dua = date('Y-m-d', strtotime("-2 day", strtotime(date("Y-m-d",strtotime(($hari))))));
        $kemarin_satu = date('Y-m-d', strtotime("-1 day", strtotime(date("Y-m-d",strtotime(($hari))))));
        $data = [
            'title' =>  'Detail Report Per Minggu',
            'observasi' =>  DB::table('hseobs')->join('positions','positions.id_positions','=','hseobs.event') ->where('hseobs.user_id',Auth::user()->id)->get(),
            'user' =>  DB::table('users')->where('role',1)->where('mananger_user',Auth::user()->email)->get(),
            'jam'   =>  DB::table('times_presentasi_proses')->get(),
            'minggu'    =>  DB::table('laporan_minggu')->where('user_mananger_id',Auth::user()->id)->get(),
            'kemarin_enam'  =>  $kemarin_enam,
            'kemarin_lima'  =>  $kemarin_lima,
            'kemarin_empat'  =>  $kemarin_empat,
            'kemarin_tiga'  =>  $kemarin_tiga,
            'kemarin_dua'  =>  $kemarin_dua,
            'kemarin_satu'  =>  $kemarin_satu,
            'hari'  =>  $hari,
            'profile'   =>  DB::table('profile')->first()
        ];
        // @dd($data['observasi']);

        return view('meneger.deail_perminggu',$data);
    }

    public function hapus_pengawas_manager($id)
    {
        DB::table('users')->where('id',$id)->delete();
        return redirect('pengawas_manager')->status('status','Data Berhasil Di Hapus');
    }

    public function edit_observasi_tolak(Request $request,$id)
    {
        $request->validate([
            'pesan' =>  'required'
        ]);

        $observasi = DB::table('hseobs')->where('id_hseobs',$id)->first();
        $users = DB::table('users')->where('email',$observasi->hse_nik)->first();

        DB::table('hseobs')->where('id_hseobs',$id)->update([
            'conditions'    =>  1,
            'coretive'  =>  $request->pesan
        ]);

        DB::table('real_time_observasi')->insert([
            'waktu_real_time'   =>  now(),
            'pesan_real_time' =>   Auth::user()->name . " Menolak Permintaan Observasi User Pengawas",
            'hseobs_id' =>  $id,
            'user_id'   =>  $users->id,
            'status_real'   => 2
        ]);

        return redirect('home_manager')->with('status','Data Berhasil Di Update');
    }

    public function terima_observasi(Request $request, $id)
    {
        DB::table('hseobs')->where('id_hseobs',$id)->update([
            'conditions'    =>  2,
            'coretive'  =>  $request->pesan
        ]);

        $observasi = DB::table('hseobs')->where('id_hseobs',$id)->first();
        $users = DB::table('users')->where('email',$observasi->hse_nik)->first();

        DB::table('real_time_observasi')->insert([
            'waktu_real_time'   =>  now(),
            'pesan_real_time' =>   Auth::user()->name . " Menerima Permintaan Observasi User Pengawas",
            'hseobs_id' =>  $id,
            'user_id'   =>  $users->id,
            'status_real'   =>  3
        ]);

        $hse = DB::table('users')->where('role',3)->get();
        foreach($hse as $row) {
            $details = [
                'title' =>  'Konfirmasi Status Observasi User Hse Audit',
                'body'  => "data",
                'email' =>  $row->email_address_id
            ];

            \Mail::to($row->email_address_id)->send(new \App\Mail\hse($details));
        }

        return redirect('home_manager')->with('status','Data Berhasil Di Update');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pengawas_manager()
    {
        $data = [
            'title' =>  'Pengawas',
            'observasi' =>  DB::table('hseobs')->where('user_id',Auth::user()->id)->get(),
            'user' =>  DB::table('users')->join('hseobs','hseobs.user_id','=','users.id')->where('role',2)->where('user_id',Auth::user()->id)->get(),
            'pengawas'  =>  DB::table('users')->where('role',1)->where('mananger_user',Auth::user()->email)->get(),
            'profile'   =>  DB::table('profile')->first()
        ];

        return view('meneger.pengawas',$data);
    }

    public function detail_pengawas_manager_id($id)
    {
        $data = [
            'title' =>  'Detail Area Pengawas',
            'observasi' =>  DB::table('hseobs')->where('user_id',Auth::user()->id)->get(),
            'user' =>  DB::table('users')->where('role',2)->get(),
            'pengawas'  =>  DB::table('users')->where('role',1)->get(),
            'area'  =>  DB::table('positions')->get(),
            'profile'   =>  DB::table('profile')->first(),
            'area_pengawas' =>  DB::table('area_user')->join('positions','positions.id_positions','=','area_user.area_user_id')->join('users','users.id','=','area_user.user_id_area')->where('area_user_id',$id)->where('mananger_user',Auth::user()->email)->get(),
            'id'    =>  $id
        ];

        return view('meneger.detail_area_pengawas',$data);
    }

    public function detail_pengawas_observasi($id,$positions)
    {
        $user = DB::table('users')->where('id',$id)->first();
        $data = [
            'title' =>  'Detail Area Pengawas',
            'observasi' =>  DB::table('hseobs')->where('user_id',Auth::user()->id)->get(),
            'user' =>  DB::table('users')->where('role',2)->get(),
            'pengawas'  =>  DB::table('users')->where('role',1)->get(),
            'area'  =>  DB::table('positions')->get(),
            'profile'   =>  DB::table('profile')->first(),
            'area_pengawas' =>  DB::table('hseobs')->where('hse_nik',$user->email)->where('event',$positions)->get(),
            // 'area_pengawas' =>  DB::table('area_user')->join('positions','positions.id_positions','=','area_user.area_user_id')->join('users','users.id','=','area_user.user_id_area')->where('area_user_id',$positions)->where('user_id_area',$id)->get(),
            'id'    =>  $id,
            'positions' =>  $positions
        ];
        

        return view('meneger.detail_area_pengawas_observasi',$data);
    }

    public function area_pengawas()
    {
        $data = [
            'title' =>  'Area Pengawas',
            'observasi' =>  DB::table('hseobs')->where('user_id',Auth::user()->id)->get(),
            'user' =>  DB::table('users')->where('role',2)->get(),
            'pengawas'  =>  DB::table('users')->where('role',1)->get(),
            'area'  =>  DB::table('positions')->get(),
            'area_count'  =>  DB::table('positions')->count(),
            'profile'   =>  DB::table('profile')->first()
        ];

        return view('meneger.area_pengawas',$data);
    }

    public function hapus_pengawas_manager_id($id)
    {
        DB::table('users')->where('id',$id)->delete();
        return redirect('pengawas_manager')->with('status','Data Berhasil Di Tambahkan');
    }

    public function type_area($id)
    {
        $result = DB::table('positions')->where('type',$id)->count();
        if($result) {
            $data = [
                'title' =>  'Area Pengawas',
                'observasi' =>  DB::table('hseobs')->where('user_id',Auth::user()->id)->get(),
                'user' =>  DB::table('users')->where('role',2)->get(),
                'pengawas'  =>  DB::table('users')->where('role',1)->get(),
                'area'  =>  DB::table('positions')->where('type',$id)->get(),
                'profile'   =>  DB::table('profile')->first(),
                'area_count'  =>  DB::table('positions')->count(),
            ];

            return view('meneger.area_pengawas',$data);
        } else {
            return redirect('area_pengawas')->with('status','Data Tidak Di Temukan');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add_pengawas(Request $request)
    {
        $request->validate([
            'nama'  =>  'required',
            'nik'   =>  'required',
            'password'  =>  'required|min:8',
            'img'   =>  'required',
            'email' =>  'required',
            'repeat'    =>  'required|min:8'
        ]);

        if($request->password != $request->repeat) {
            return redirect('pengawas_manager')->with('status','Password Tidak Sama');
        }

        $akuns = DB::table('users')->where('mananger_user',Auth::user()->email)->count();
        $akun = DB::table('users')->where('email',$request->nik)->count();
        if($akuns >= 10)  {
            return redirect('/pengawas_manager')->with('status','User Pengawas Maksimal 10 Orang');
        } elseif($akun) {
            return redirect('/pengawas_manager')->with('status','Nik Sudah Ada');
        }

        $gambar = $request->img->getClientOriginalName() . '-' . time() . '.' . $request->img->extension();
        $request->img->move(public_path('assets/img/'), $gambar);

        DB::table('users')->insert([
            'name'  =>  $request->nama,
            'email' =>  $request->nik,
            'password'  =>  Hash::make($request->password),
            'created_at'    =>  now(),
            'role' =>   1,
            'img'   =>  $gambar,
            'mananger_user' => Auth::user()->email,
            'email_address_id'  =>  $request->email
        ]);


        return redirect('pengawas_manager')->with('status','Data Berhasil Di Tambahkan');
    }
    
    public function add_area_pengawas(Request $request)
    {
        $request->validate([
            'area'  =>  'required',
            'type'  =>  'required'
        ]);

        DB::table('positions')->insert([
            'positions'  =>  $request->area,
            'type'  =>  $request->type
        ]);

        return redirect('area_pengawas')->with('status','Data Berhasil Di Tambahkan');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hapus_area_pengawas($id)
    {
        DB::table('positions')->where('id_positions',$id)->delete();
        return redirect('area_pengawas')->with('status','Data Berhasil Di Hapus');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hapus_observasi_manager($id)
    {
        DB::table('hseobs')->where('id_hseobs',$id)->delete();
        return redirect('home_manager')->with('status','Data Berhasil Di Hapus');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_manager(Request $request,$id)
    {
        $request->validate([
            'nama'  =>  'required',
            'nik'   =>  'required',
            'email' =>  'required',
        ]);

        if($request->password != $request->repeat) {
            return redirect('home_manager')->with('status','Password Tidak Sama');
        }

        if(!$request->file('img')) {
            $gambar = $request->img_lama;
        } else {
            $gambar = $request->img->getClientOriginalName() . '-' . time() . '.' . $request->img->extension();
            $request->img->move(public_path('assets/img/'), $gambar);
        }

        if(!$request->password || !$request->repeat) {
            DB::table('users')->where('id',$id)->update([
                'name'  =>  $request->nama,
                'email' =>  $request->nik,
                'img'   =>  $gambar,
                'email_address_id'  =>  $request->email
            ]);
        } else {
            DB::table('users')->where('id',$id)->update([
                'name'  =>  $request->nama,
                'email' =>  $request->nik,
                'password'  =>  Hash::make($request->password),
                'img'   =>  $gambar,
                'email_address_id'  =>  $request->email
            ]);

        }

        return redirect('home_manager')->with('status','Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
