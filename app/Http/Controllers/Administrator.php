<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Administrator extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' =>  'Pengawas',
            'observasi' =>  DB::table('hseobs')->where('user_id',Auth::user()->id)->get(),
            'user' =>  DB::table('users')->where('role',2)->get(),
            'pengawas'  =>  DB::table('users')->where('role',1)->get(),
            'mananger'  =>  DB::table('users')->where('role',2)->get(),
            'profile'   =>  DB::table('profile')->first()
        ];

        return view('admin.pengawas',$data);
    }

    public function hse_audit()
    {
        $data = [
            'title' =>  'HSE AUDIT',
            'observasi' =>  DB::table('hseobs')->where('user_id',Auth::user()->id)->get(),
            'user' =>  DB::table('users')->where('role',2)->get(),
            'pengawas'  =>  DB::table('users')->where('role',3)->get(),
            'profile'   =>  DB::table('profile')->first()
        ];

        return view('admin.hse',$data);
    }

    public function area_mananger()
    {
        $data = [
            'title' =>  'Area Mananger',
            'observasi' =>  DB::table('hseobs')->where('user_id',Auth::user()->id)->get(),
            'user' =>  DB::table('users')->where('role',2)->get(),
            'pengawas'  =>  DB::table('users')->where('role',2)->get(),
            'profile'   =>  DB::table('profile')->first()
        ];

        return view('admin.manager',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_pengawas_admin(Request $request)
    {
        $request->validate([
            'nama'  =>  'required',
            'nik'   =>  'required',
            'repeat'    =>  'required|min:8',
            'img'   =>  'required',
            'password'  =>  'required|min:8',
            'mananger'  =>  'required',
            'email'     =>  'required'
        ]);

        if(!$request->mananger) {
            return redirect('home_admin')->with('status','Area Mananger Belum Ada');
        }

        $gambar = $request->img->getClientOriginalName() . '-' . time() . '.' . $request->img->extension();
        $request->img->move(public_path('assets/img/'), $gambar);

        if($request->password != $request->repeat) {
            return redirect('home_admin')->with('status','Password Tidak Sama');
        }

        DB::table('users')->insert([
            'name'  =>  $request->nama,
            'email' =>  $request->nik,
            'password'  =>  Hash::make($request->password),
            'created_at'    =>  now(),
            'role' =>   1,
            'img'   =>  $gambar,
            'mananger_user' =>  $request->mananger,
            'email_address_id'  =>  $request->email
        ]);

        return redirect('home_admin')->with('status','Data Berhasil Di Tambahkan');
    }

    public function hapus_mananger_admin($id)
    {
        DB::table('users')->where('id',$id)->delete();
        return redirect('area_mananger')->with('status','Data  Berhasil Di Hapus');
    }

    public function add_hse_admin(Request $request)
    {
        $request->validate([
            'nama'  =>  'required',
            'nik'   =>  'required',
            'repeat'    =>  'required|min:8',
            'img'   =>  'required',
            'email' =>  'required',
            'password'  =>  'required|min:8'
        ]);

        $gambar = $request->img->getClientOriginalName() . '-' . time() . '.' . $request->img->extension();
        $request->img->move(public_path('assets/img/'), $gambar);

        if($request->password != $request->repeat) {
            return redirect('home_admin')->with('status','Password Tidak Sama');
        }

        DB::table('users')->insert([
            'name'  =>  $request->nama,
            'email' =>  $request->nik,
            'password'  =>  Hash::make($request->password),
            'created_at'    =>  now(),
            'role' =>   3,
            'img'   =>  $gambar,
            'email_address_id'  =>  $request->email
        ]);

        return redirect('hse_audit')->with('status','Data Berhasil Di Tambahkan');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function hapus_pengawas_admin(Request $request,$id)
    {
        DB::table('users')->where('id',$id)->delete();
        return redirect('home_admin')->with('status','Data Berhasil Di Hapus');
    }
    
    public function hapus_hse_admin(Request $request,$id)
    {
        DB::table('users')->where('id',$id)->delete();
        return redirect('hse_audit')->with('status','Data Berhasil Di Hapus');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add_manager_admin(Request $request)
    {
        $request->validate([
            'nama'  =>  'required',
            'nik'   =>  'required',
            'repeat'    =>  'required|min:8',
            'img'   =>  'required',
            'email' =>  'required',
            'password'  =>  'required|min:8'
        ]);

        $gambar = $request->img->getClientOriginalName() . '-' . time() . '.' . $request->img->extension();
        $request->img->move(public_path('assets/img/'), $gambar);

        if($request->password != $request->repeat) {
            return redirect('home_admin')->with('status','Password Tidak Sama');
        }

        DB::table('users')->insert([
            'name'  =>  $request->nama,
            'email' =>  $request->nik,
            'password'  =>  Hash::make($request->password),
            'created_at'    =>  now(),
            'role' =>   2,
            'img'   =>  $gambar,
            'email_address_id'  => $request->email
        ]);

        return redirect('area_mananger')->with('status','Data Berhasil Di Tambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setting()
    {
        $data = [
            'title' =>  "Setting",
            'profile'   =>  DB::table('profile')->first()
        ];
        return view('admin.setting',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_profile(Request $request, $id)
    {
        $request->validate([
            'nama'  =>  'required'
        ]);

        if(!$request->file('img')) {
            $gambar = $request->img_lama;
        } else {
            $gambar = $request->img->getClientOriginalName() . '-' . time() . '.' . $request->img->extension();
            $request->img->move(public_path('assets/img/'), $gambar);
        }

        DB::table('profile')->orderBy('id_profile','desc')->update([
            'logo'  =>  $gambar,
            'nama'  =>  $request->nama,
        ]);

        return redirect('setting')->with('status','Data Berhasil Di Update');
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
