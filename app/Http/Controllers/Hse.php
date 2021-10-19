<?php

namespace App\Http\Controllers;

use App\Exports\area;
use App\Exports\Bulan;
use App\Exports\hse as ExportsHse;
use Illuminate\Contracts\View\View;
use App\Exports\sfs;
use App\Exports\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Exel;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Hash;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;
use Symfony\Component\Process\ExecutableFinder;

class Hse extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' =>  'Observasi',
            'observasi' =>  DB::table('hseobs')->leftJoin('positions','positions.id_positions','=','hseobs.event')->where('conditions',2)->orWhere('conditions',3)->get(),
            'user' =>  DB::table('users')->where('role',2)->get(),
            'kondisi_submision' =>  DB::table('kondisi_submission')->get(),
            'kondisi_submision_count' =>  DB::table('kondisi_submission')->count(),
            'area'  =>  DB::table('positions')->get(),
            'statistik' =>  DB::table('submission_observasi')->limit(10)->get(),
            'statistik_count' =>  DB::table('submission_observasi')->count(),
            'profile'   =>  DB::table('profile')->first()
        ];

        return view('hse.index',$data);
    }

    public function cari_hse(Request $request)
    {
        $request->validate([
            'waktu' =>  'required',
            'area'  =>  'required'
        ]);

        $result = DB::table('submission_observasi')->where('waktu_submission',$request->waktu)->where('area_submission',$request->area)->count();
        if($result) {
            $data = [
                'title' =>  'Observasi',
                'observasi' =>  DB::table('hseobs')->leftJoin('positions','positions.id_positions','=','hseobs.event')->where('hseobs.user_id',Auth::user()->id)->where('conditions',null)->orWhere('conditions',1)->get(),
                'user' =>  DB::table('users')->where('role',2)->get(),
                // 'statistik' =>  DB::table('submission_observasi')->where('waktu_submission',$request->waktu)->where('area_submission',$request->area)->where('user_mananger_id',Auth::user()->id)->where('user_mananger_id',Auth::user()->id)->limit(10)->get(),
                'area' =>   DB::table('positions')->get(),
                'statistik' =>  DB::table('submission_observasi')->where('waktu_submission',$request->waktu)->where('area_submission',$request->area)->limit(10)->get(),
                'kondisi_submision' =>  DB::table('kondisi_submission')->limit(1)->get(),
                'statistik_count' =>  DB::table('submission_observasi')->where('user_mananger_id',Auth::user()->id)->count(),
                'profile'   =>  DB::table('profile')->first()
            ];

            return view('hse.index',$data);
        } else {
            return redirect('/home_hse')->with('status','Data Tidak Di Temukan');
        }
    }

    public function detail_pengawas_manager_id_hse(Request $request,$id)
    {
        $data = [
            'title' =>  'Detail Area Pengawas',
            'observasi' =>  DB::table('hseobs')->where('user_id',Auth::user()->id)->get(),
            'user' =>  DB::table('users')->where('role',2)->get(),
            'pengawas'  =>  DB::table('users')->where('role',1)->get(),
            'area'  =>  DB::table('positions')->get(),
            'profile'   =>  DB::table('profile')->first(),
            'area_pengawas' =>  DB::table('area_user')->join('positions','positions.id_positions','=','area_user.area_user_id')->join('users','users.id','=','area_user.user_id_area')->where('area_user_id',$id)->get(),
            'id'    =>  $id
        ];

        return view('hse.detail_area_pengawas',$data);
    }

    public function detail_pengawas_observasi_hse(Request $request,$id,$positions)
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
            'id'    =>  $id,
            'positions' =>  $positions
        ];

        return view('hse.detail_area_pengawas_observasi',$data);
    }

    public function report_area(Request $request)
    {
        $data = [
            'title' =>  'Report Area',
            'observasi' =>  DB::table('hseobs')->leftJoin('positions','positions.id_positions','=','hseobs.event')->where('conditions',2)->orWhere('conditions',3)->get(),
            'user' =>  DB::table('users')->where('role',2)->get(),
            'kondisi_submision' =>  DB::table('kondisi_submission')->limit(1)->get(),
            'area'  =>  DB::table('positions')->get(),
            'statistik' =>  DB::table('submission_observasi')->limit(10)->get(),
            'area'  =>  DB::table('eksport_area')->get(),
            'area_count'  =>  DB::table('eksport_area')->count(),
            'profile'   =>  DB::table('profile')->first()
        ];

        return view('hse.report_area',$data);   
    }

    public function area()
    {
        $data = [
            'title' =>  'Area',
            'observasi' =>  DB::table('hseobs')->leftJoin('positions','positions.id_positions','=','hseobs.event')->where('conditions',2)->orWhere('conditions',3)->get(),
            'user' =>  DB::table('users')->where('role',2)->get(),
            'kondisi_submision' =>  DB::table('kondisi_submission')->limit(1)->get(),
            'area'  =>  DB::table('positions')->get(),
            'statistik' =>  DB::table('submission_observasi')->limit(10)->get(),
            // 'area'  =>  DB::table('eksport_area')->get(),
            'profile'   =>  DB::table('profile')->first(),
            'area_count'  =>  DB::table('positions')->count(),
            'eksport'   =>  DB::table('eksport_area')->count()
        ];

        return view('hse.area_pengawas',$data);
    }

    public function type_area_hse(Request $request,$id)
    {
        $result = DB::table('positions')->where('type',$id)->count();
        if($result) {
            $data = [
                'title' =>  'Area',
                'observasi' =>  DB::table('hseobs')->where('user_id',Auth::user()->id)->get(),
                'user' =>  DB::table('users')->where('role',2)->get(),
                'pengawas'  =>  DB::table('users')->where('role',1)->get(),
                'area'  =>  DB::table('positions')->where('type',$id)->get(),
                'profile'   =>  DB::table('profile')->first(),
                'eksport'   =>  DB::table('eksport_area')->count(),
                'area_count'  =>  DB::table('positions')->count(),
            ];

            return view('hse.area_pengawas',$data);
        } else {
            return redirect('area')->with('status','Data Tidak Di Temukan');
        }
    }

    public function print_cfs($id)
    {
        $result = DB::table('eksport_area')->where('type',$id)->count();
        if(!$result) {
            return redirect('area')->with('status','Data Tidak Di Temukan');
        }
        return Excel::download(new area, 'print_area.xlsx');
    }

    public function print_sfs($id)
    {
        $result = DB::table('eksport_area')->where('type',$id)->count();
        if(!$result) {
            return redirect('area')->with('status','Data Tidak Di Temukan');
        }
        return Excel::download(new sfs, 'print_area.xlsx');
    }

    public function cari_kondisi(Request $request)
    {
        $request->validate([
            'waktu' =>  'required',
            'area'  =>  'required'
        ]);

        $data = DB::table('kondisi_submission')->where('waktu_kondisi',$request->waktu)->where('area_kondisi',$request->area)->first();
        if(!$data) {
            return redirect('/home_hse')->with('status','Data Tidak Di Temukan');
        } else {
            $data = [
                'title' =>  'Observasi',
                'observasi' =>  DB::table('hseobs')->leftJoin('positions','positions.id_positions','=','hseobs.event')->where('conditions',2)->orWhere('conditions',3)->get(),
                'user' =>  DB::table('users')->where('role',2)->get(),
                'kondisi_submision' =>  DB::table('kondisi_submission')->where('waktu_kondisi',$request->waktu)->where('area_kondisi',$request->area)->limit(1)->get(),
                'area'  =>  DB::table('positions')->get(),
                'profile'   =>  DB::table('profile')->first(),
                'statistik' =>  DB::table('submission_observasi')->limit(10)->get(),
            ];
    
            return view('hse.index',$data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edits_observasi_tolak(Request $request,$id)
    {
        $request->validate([
            'pesan' =>  'required'
        ]);

        DB::table('hseobs')->where('id_hseobs',$id)->update([
            'conditions'    =>  1,
            'approve_hse_audit'  =>  $request->pesan
        ]);

        
        $observasi = DB::table('hseobs')->where('id_hseobs',$id)->first();
        $users = DB::table('users')->where('email',$observasi->hse_nik)->first();

        DB::table('real_time_observasi')->insert([
            'waktu_real_time'   =>  now(),
            'pesan_real_time' =>   Auth::user()->name . " Menolak Permintaan Observasi User Area Manager",
            'hseobs_id' =>  $id,
            'user_id'   =>  $users->id,
            'status_real'   =>  6
        ]);

        return redirect('home_hse')->with('status','Data Berhasil Di Update');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function terimas_observasi(Request $request,$id)
    {
        DB::table('hseobs')->where('id_hseobs',$id)->update([
            'conditions'    =>  3,
            'approve_hse_audit'  =>  $request->pesan
        ]);

        $observasi = DB::table('hseobs')->where('id_hseobs',$id)->first();
        $users = DB::table('users')->where('email',$observasi->hse_nik)->first();

        DB::table('real_time_observasi')->insert([
            'waktu_real_time'   =>  now(),
            'pesan_real_time' =>   Auth::user()->name . " Menerima Permintaan Observasi User Area Manager",
            'hseobs_id' =>  $id,
            'user_id'   =>  $users->id,
            'status_real'   =>  5
        ]);

        return redirect('home_hse')->with('status','Data Berhasil Di Update');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hapus_observasis($id)
    {
        $observasi = DB::table('hseobs')->where('id_hseobs',$id)->first();
        $users = DB::table('users')->where('email',$observasi->hse_nik)->first();
        $persentasi = DB::table('persentasi_proses')->where('user_id',$users->id)->orderBy('id_persentasi_proses','desc')->first();

        DB::table('persentasi_proses')->where('user_id',$users->id)->orderBy('id_persentasi_proses','desc')->update([
            'persen'    =>  $persentasi->persen - 1
        ]);

        DB::table('hseobs')->where('id_hseobs',$id)->delete();
        return redirect('home_hse')->with('status','Data Berhasil Di Hapus');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approval_hse()
    {
        $data = [
            'title' =>  'Approval Pengawas',
            'day'   =>  DB::table('times_presentasi_proses')->get(),
            'profile'   =>  DB::table('profile')->first(),
            'hse'   =>  DB::table('hseobs')->count(),
            'data'  =>  DB::table('hseobs')->join('positions','positions.id_positions','=','hseobs.event')->get()
        ];

        return view('hse.approval',$data);
    }

    public function print_perbulan(Request $request)
    {
        $request->validate([
            'bulan' =>  'required'
        ]);

        $bulan = date('m',strtotime($request->bulan));
        $tahun = date('Y',strtotime($request->bulan));
        $result = DB::select("SELECT * FROM hseobs WHERE month(dibuat_hseobs) = '$bulan' AND year(dibuat_hseobs) = '$tahun'");
        if(!empty($result)) {
            return Excel::download(new Bulan($bulan,$tahun),'hse.xlsx');
        } else {
            return redirect('/approval_hse')->with('status','Data Tidak Di Temukan');
        }
    }

    public function print_pertahun(Request $request)
    {
        $request->validate([
            'tahun' =>  'required'
        ]);

        $tahun = $request->tahun;
        $result = DB::select("SELECT * FROM hseobs WHERE year(dibuat_hseobs) = '$tahun'");
        if(!empty($result)) {
            return Excel::download(new Tahun($tahun),'hse.xlsx');
        } else {
            return redirect('/approval_hse')->with('status','Data Tidak Di Temukan');
        }
    }

    public function cari_waktu_hse(Request $request)
    {
        $request->validate([
            'waktu' =>  'required'
        ]);

        $result = DB::table('times_presentasi_proses')->where('times',$request->waktu)->count();
        if($result) {
            $data = [
                'title' =>  'Approval Pengawas',
                'day'   =>  DB::table('times_presentasi_proses')->where('times',$request->waktu)->get(),
                'profile'   =>  DB::table('profile')->first(),
                'hse'   =>  DB::table('hseobs')->count(),
                'data'  =>  DB::table('hseobs')->join('positions','positions.id_positions','=','hseobs.event')->get()
            ];
    
            return view('hse.approval',$data);
        } else {
            return redirect('/approval_hse')->with('status','Data Tidak Di Temukan');
        }
    }

    public function print_hse(Request $request)
    {
        return Excel::download(new ExportsHse,'hse.xlsx');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail_approval($id)
    {
        $data = [
            'title' =>  'Detail Approval Pengawas',
            'day'   =>  DB::table('times_presentasi_proses')->get(),
            'approval_user' =>  DB::table('users')->leftJoin('laporan_perhari','laporan_perhari.user_pengawas_id','=','users.id')->where('role',1)->where('time_perhari',$id)->get(),
            'times' =>  $id,
            'profile'   =>  DB::table('profile')->first()
        ];

        return view('hse.approval_proses',$data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail_approval_point($id,$point)
    {
        $users = DB::table('users')->where('id',$id)->first();
        // @dd($users);

        $data = [
            'title' =>  'Detail Approval Pengawas',
            'day'   =>  DB::table('times_presentasi_proses')->get(),
            'approval_user' =>  DB::table('users')->where('id',$id)->get(),
            'times' =>  $point,
            'id'    =>  $id,
            'persentasi' => DB::table('persentasi_proses')->where('user_id',$id)->where('waktu',$point)->get(),
            'observasi' =>  DB::table('hseobs')->leftJoin('positions','positions.id_positions','=','hseobs.event')->where('hse_nik',$users->email)->where('dibuat_hseobs',$point)->get(),
            'profile'   =>  DB::table('profile')->first()
        ];

        return view('hse.approval_user',$data);
    }

    public function terimas_observasi_user($id,$point,$id_user)
    {
        DB::table('hseobs')->where('id_hseobs',$id)->update([
            'conditions'    =>  3
        ]);

        return redirect('/detail_approval_point' . '/' . $id_user . '/'. $point)->with('status','Data Berhasil Di Update');
    }
    
    public function edits_observasi_tolak_hse(Request $request, $id,$point,$id_user) 
    {
        $request->validate([
            'pesan' =>  'required'
        ]);
        
        DB::table('hseobs')->where('id_hseobs',$id)->update([
            'conditions'    =>  1,
            'coretive'  =>  $request->pesan
        ]);


        return redirect('/detail_approval_point' . '/' . $id_user . '/'. $point)->with('status','Data Berhasil Di Update');
    }

    public function edit_hse_admin(Request $request,$id)
    {
        $request->validate([
            'nama'  =>  'required',
            'nik'   =>  'required',
            'email' =>  'required',
        ]);

        if($request->password != $request->repeat) {
            return redirect('hse_audit')->with('status','Password Tidak Sama');
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


        return redirect('hse_audit')->with('status','Data Berhasil Di Update');
    }

    
    public function edit_hse_profile(Request $request,$id)
    {
        $request->validate([
            'nama'  =>  'required',
            'nik'   =>  'required',
            'email' =>  'required',
        ]);

        if($request->password != $request->repeat) {
            return redirect('home_hse')->with('status','Password Tidak Sama');
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

        return redirect('home_hse')->with('status','Data Berhasil Di Update');
    }

    
    public function edit_mananger_admin(Request $request,$id)
    {
        $request->validate([
            'nama'  =>  'required',
            'nik'   =>  'required',
            'email' =>  'required'
        ]);

        if($request->password != $request->repeat) {
            return redirect('area_mananger')->with('status','Password Tidak Sama');
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

        return redirect('area_mananger')->with('status','Data Berhasil Di Update');
    }

    public function edit_pengawas_admin(Request $request,$id)
    {
        $request->validate([
            'nama'  =>  'required',
            'nik'   =>  'required',
            'email' =>  'required'
        ]);

        if($request->password != $request->repeat) {
            return redirect('home_admin')->with('status','Password Tidak Sama');
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

        return redirect('home_admin')->with('status','Data Berhasil Di Update');
    }
    

    public function edit_pengawas_admins(Request $request,$id)
    {
        $request->validate([
            'nama'  =>  'required',
            'nik'   =>  'required',
            'email' =>  'required'
        ]);

        if($request->password != $request->repeat) {
            return redirect('home_admin')->with('status','Password Tidak Sama');
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

        return redirect('home_admin')->with('status','Data Berhasil Di Update');
    }
    
    public function hapus_observasis_hse($id,$point,$id_user)
    {
        $persentasi = DB::table('persentasi_proses')->where('user_id',$id_user)->orderBy('id_persentasi_proses','desc')->first();
        DB::table('persentasi_proses')->where('user_id',$id_user)->orderBy('id_persentasi_proses','desc')->update([
            'persen'    =>  $persentasi->persen - 1
        ]);

        DB::table('hseobs')->where('id_hseobs',$id)->delete();
        return redirect('/detail_approval_point' . '/' . $id_user . '/'. $point)->with('status','Data Berhasil Di Hapus');
    }
}
