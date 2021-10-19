<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User_Pengawas extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $area =  DB::table('hseobs')->join('positions', 'positions.id_positions', '=', 'hseobs.event')->join('users', 'users.id', '=', 'hseobs.user_id')->where('hse_nik', Auth::user()->email)->first();
        if (!$area) {
            $positions = 1;
        } else {
            $positions = $area->id_positions;
        }

        $akun = DB::table('users')->where('email', Auth::user()->mananger_user)->first();

        $data = [
            'title' =>  'Observasi',
            'observasi' =>  DB::table('hseobs')->join('positions', 'positions.id_positions', '=', 'hseobs.event')->where('hse_nik', Auth::user()->email)->get(),
            'area_observasi' =>  DB::table('hseobs')->join('positions', 'positions.id_positions', '=', 'hseobs.event')->where('user_id', $akun->id)->get(),
            'data_cabang' =>  DB::table('hseobs')->join('positions', 'positions.id_positions', '=', 'hseobs.event')->join('users', 'users.id', '=', 'hseobs.user_id')->where('hse_nik', Auth::user()->email)->first(),
            'count_observasi' =>  DB::table('hseobs')->join('positions', 'positions.id_positions', '=', 'hseobs.event')->where('hse_nik', Auth::user()->email)->orderBy('id_hseobs', 'desc')->count(),
            'user' =>  DB::table('users')->where('role', 2)->get(),
            'area'  =>  DB::table('positions')->get(),
            'profile'   =>  DB::table('profile')->first()
        ];

        return view('pengawas.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request)
    {
        if ($request->session()->get('login')) {
            if (Auth::user()->role == 1) {
                return redirect('/home_pengawas');
            } elseif (Auth::user()->role == 2) {
                return redirect('/home_manager');
            } elseif (Auth::user()->role == 3) {
                return redirect('/home_hse');
            } elseif (Auth::user()->role == 4) {
                return redirect('/home_admin');
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add_observasi(Request $request)
    {
        // validasi
        $request->validate([
            // 'nama'  =>  'required',
            'mulai'   =>  'required',
            'selesai'   =>  'required',
            'amati'   =>  'required',
            'perbaikan'   =>  'required',
            'terulang'   =>  'required',
            'img'   =>  'required',
            'kejadian'   =>  'required',
            'observasi'   =>  'required',
        ]);

        // cek cabang pengawas & manager & area
        $cabang_pengawas = DB::table('hseobs')->where('hse_nik', Auth::user()->email)->orderBy('id_hseobs', 'desc')->count();
        if ($cabang_pengawas) {
            $result_cabang = DB::table('hseobs')->where('hse_nik', Auth::user()->email)->orderBy('id_hseobs', 'desc')->first();
            $users_manager = DB::table('users')->where('email', Auth::user()->mananger_user)->first();
            $data_cabang = $result_cabang->cabang;
            // $data_area = $result_cabang->event;
            $data_area = $request->area;
            $data_mananger = $users_manager->id;
        } else {
            $users_manager = DB::table('users')->where('email', Auth::user()->mananger_user)->first();
            $data_cabang = $request->cabang;
            $data_area = $request->area;
            $data_mananger = $users_manager->id;
        }
        
        $times = DB::table('times_presentasi_proses')->orderBy('id_times_presentasi_proses', 'desc')->first();
        $now = date("Y-m-d");
        if (!$times) {
            DB::table('times_presentasi_proses')->insert([
                'times' =>  now(),
            ]);
        } else {
            if ($times->times != $now) {
                DB::table('times_presentasi_proses')->insert([
                    'times' =>  now(),
                ]);
            }
        }

        $positions = DB::table('positions')->where('id_positions',$data_area)->first();
        $area_user = DB::table('area_user')->where('user_id_area',Auth::user()->id)->where('area_user_id',$data_area)->orderBy('id_area_user','desc')->first();
        if(!$area_user) {
            DB::table('area_user')->insert([
                'area_user_id'  =>  $positions->id_positions,
                'user_id_area'  =>  Auth::user()->id
            ]);
        }

        $area = DB::table('eksport_area')->first();
        $positions_area = DB::table('positions')->where('id_positions', $data_area)->first();

        if($positions_area->type == "CFS") {
            $event = "CFS";
        } else {
            $event = "SFS";
        }
        $area_nama = DB::table('eksport_area')->where('nama_area', $positions_area->positions)->first();
        $users = DB::table('user_ekport')->where('user_id_eksport',Auth::user()->id)->count();
        if(!$users) {
            DB::table('user_ekport')->insert([
                'user_id_eksport'   =>  Auth::user()->id
            ]);
        }
        if ( !$area_nama) {
            DB::table('eksport_area')->insert([
                'nama_area' =>  $positions_area->positions,
                'submitting'    =>  1,
                'jml_pengawas'  =>  1,
                'presentase'    => 0,
                'rank'  =>  0,
                'type'  =>  $event
            ]);
        } else {
            if ($area_nama->nama_area == $positions_area->positions) {
                $area_data = DB::table('eksport_area')->where('nama_area', $positions_area->positions)->orderBy('id_eksport_area', 'desc')->first();
                $users = DB::table('user_ekport')->where('user_id_eksport',Auth::user()->id)->count();
                if($users) {
                    DB::table('eksport_area')->where('nama_area', $positions_area->positions)->orderBy('id_eksport_area', 'desc')->update([
                        'nama_area' =>   $positions_area->positions,
                        'submitting'    =>  $area_data->submitting + 1,
                        'presentase'    => $area_data->presentase + 1,
                    ]);
                } else {
                    DB::table('eksport_area')->where('nama_area', $positions_area->positions)->orderBy('id_eksport_area', 'desc')->update([
                        'nama_area' =>   $positions_area->positions,
                        'submitting'    =>  $area_data->submitting + 1,
                        'jml_pengawas'    => $area_data->jml_pengawas + 1,
                        'presentase'    => $area_data->presentase + 1,
                    ]);
                    DB::table('user_ekport')->insert([
                        'user_id_eksport'   =>  Auth::user()->id
                    ]);
                }
            }
        }

        // check kondisi
        $akun_menenger = DB::table('users')->where('email', Auth::user()->mananger_user)->first();
        $now = date('Y-m-d');
        $kondisi = DB::table('kondisi_submission')->where('user_id', $akun_menenger->id)->where('waktu_kondisi', $now)->first();
        if (!$kondisi) {
            DB::table('kondisi_submission')->insert([
                'waktu_kondisi'  =>  now(),
                'area_kondisi'  =>  $data_area,
                'user_id'   =>  $akun_menenger->id,
            ]);
            if ($request->observasi == "Tindakan aman") {
                $submission_kondisi = DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->first();
                DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->update([
                    'tindakan_aman' =>  $submission_kondisi->tindakan_aman + 1
                ]);
            } elseif ($request->observasi == "Tindakan tidak aman") {
                $submission_kondisi = DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->first();
                DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->update([
                    'tindakan_tidak_aman' =>  $submission_kondisi->tindakan_tidak_aman + 1
                ]);
            } elseif ($request->observasi == "Kondisi aman") {
                $submission_kondisi = DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->first();
                DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->update([
                    'kondisi_aman' =>  $submission_kondisi->kondisi_aman + 1
                ]);
            } elseif ($request->observasi == "Kondisi tidak aman") {
                $submission_kondisi = DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->first();
                DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->update([
                    'kondisi_tidak_aman' =>  $submission_kondisi->kondisi_tidak_aman + 1
                ]);
            } elseif ($request->observasi == "Nearmiss/nyaris celaka") {
                $submission_kondisi = DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->first();
                DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->update([
                    'Nearmiss' =>  $submission_kondisi->Nearmiss + 1
                ]);
            } elseif ($request->observasi == "Accident") {
                $submission_kondisi = DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->first();
                DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->update([
                    'Accident' =>  $submission_kondisi->Accident + 1
                ]);
            }
        } else {
            if ($request->observasi == "Tindakan aman") {
                $submission_kondisi = DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->first();
                DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->update([
                    'tindakan_aman' =>  $submission_kondisi->tindakan_aman + 1
                ]);
            } elseif ($request->observasi == "Tindakan tidak aman") {
                $submission_kondisi = DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->first();
                DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->update([
                    'tindakan_tidak_aman' =>  $submission_kondisi->tindakan_tidak_aman + 1
                ]);
            } elseif ($request->observasi == "Kondisi aman") {
                $submission_kondisi = DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->first();
                DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->update([
                    'kondisi_aman' =>  $submission_kondisi->kondisi_aman + 1
                ]);
            } elseif ($request->observasi == "Kondisi tidak aman") {
                $submission_kondisi = DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->first();
                DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->update([
                    'kondisi_tidak_aman' =>  $submission_kondisi->kondisi_tidak_aman + 1
                ]);
            } elseif ($request->observasi == "Nearmiss/nyaris celaka") {
                $submission_kondisi = DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->first();
                DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->update([
                    'Nearmiss' =>  $submission_kondisi->Nearmiss + 1
                ]);
            } elseif ($request->observasi == "Accident") {
                $submission_kondisi = DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->first();
                DB::table('kondisi_submission')->where('waktu_kondisi', $now)->where('user_id', $akun_menenger->id)->orderBy('id_kondisi_submission', 'desc')->update([
                    'Accident' =>  $submission_kondisi->Accident + 1
                ]);
            }
        }

        // // chek laporan minggu
        $minggu = DB::table('laporan_minggu')->orderBy('id_laporan_minggu', 'desc')->first();
        if (!$minggu) {
            $waktu_minggu = date('Y-m-d', strtotime('+6 days', strtotime($now)));
            DB::table('laporan_minggu')->insert([
                'waktu_laporan_minggu'  =>  $waktu_minggu,
                'user_mananger_id'  =>  $akun_menenger->id,
                'minggu_ke' =>  1
            ]);
        } elseif ($minggu->waktu_laporan_minggu == $now) {
            $waktu_minggu = date('Y-m-d', strtotime('+6 days', strtotime($now)));
            DB::table('laporan_minggu')->insert([
                'waktu_laporan_minggu'  =>  $waktu_minggu,
                'user_mananger_id'  =>  $akun_menenger->id,
                'minggu_ke' =>  $minggu->minggu_ke + 1
            ]);

            // $presentasi = DB::table('persentasi_proses')->where('user_id',Auth::user()->id)->where('waktu_laporan_minggu',$now)->orderBy('id_laporan_minggu','desc')->first();
            // DB::table('persentasi_proses')->where('user_id',Auth::user()->id)->where('waktu_laporan_minggu',$now)->orderBy('id_laporan_minggu','desc')->update([
            //     'status_proses' =>  $presentasi->status_proses - 20
            // ]);
        }

        // upload img
        $gambar = $request->img->getClientOriginalName() . '-' . time() . '.' . $request->img->extension();
        $request->img->move(public_path('assets/img/'), $gambar);

        // kondisi observasi
        $sekarang = date('d-m-Y');
        $users_akun = DB::table('users')->where('email',Auth::user()->mananger_user)->first();
        $result = DB::table('hseobs')->where('hse_nik', Auth::user()->email)->where('user_id',$users_akun->id)->orderBy('id_hseobs', 'desc')->first();
        $result_count = DB::table('hseobs')->where('hse_nik', Auth::user()->email)->where('user_id',$users_akun->id)->orderBy('id_hseobs', 'desc')->count();
        $result_hseobs = null;
        if (!$result_count) {
            // insert observasi
            $result_hseobs = DB::table('hseobs')->insert([
                'hse_nik'   =>  Auth::user()->email,
                'hse_name'  =>  Auth::user()->name,
                'location'  =>  $request->kejadian,
                'type_activity' =>  $request->type,
                'event' =>  $data_area,
                'cabang'   =>   $data_cabang,
                'user_id'   =>  $data_mananger,
                'kondisi_observasi' =>  $request->observasi,
                'expired'   =>  date("d-m-Y"),
                'mulai_kerja'   =>  $request->mulai,
                'selesai_kerja' =>  $request->selesai,
                'amati' =>  $request->amati,
                'perbaikan' =>  $request->perbaikan,
                'terulang'  =>  $request->terulang,
                'img_hseobs'   =>  $gambar,
                'dibuat_hseobs' =>  now(),
                'minggu'    =>  1
            ]); 

            $akun_menenger_id = DB::table('users')->where('email', Auth::user()->mananger_user)->first();
            $details = [
                'title' =>  'Konfirmasi Status Observasi User Pengawas',
                'body'  => "data",
                'email' =>  $akun_menenger_id->email_address_id
            ];

            \Mail::to($akun_menenger_id->email_address_id)->send(new \App\Mail\mananger($details));

            // insert progress
            $mananger_id = DB::table('users')->where('email', Auth::user()->mananger_user)->first();
            $result_hseobs = DB::table('hseobs')->where('hse_nik', Auth::user()->email)->where('user_id', $mananger_id->id)->orderBy('id_hseobs', 'desc')->first();
            DB::table('persentasi_proses')->insert([
                'persen'    =>  1,
                'waktu' =>  now(),
                'user_id'   =>  Auth::user()->id,
                'status_proses' =>  5,
                'expired_proses'    =>  $result_hseobs->minggu,
                'mananger_id'   =>  $mananger_id->id
            ]);

            $mananger = DB::table('users')->where('email', Auth::user()->mananger_user)->first();
            $now = date('Y-m-d');
            $laporan_perhari = DB::table('laporan_perhari')->where('user_pengawas_id', Auth::user()->id)->where('user_mananger_id', $mananger->id)->where('time_perhari', $now)->where('minggu_perhari', $result_hseobs->minggu)->first();

            DB::table('laporan_perhari')->where('user_pengawas_id', Auth::user()->id)->where('user_mananger_id', $mananger->id)->insert([
                'total_persen'  => 1,
                'time_perhari'  =>  now(),
                'user_pengawas_id'  =>  Auth::user()->id,
                'status_perhari'    =>  5,
                'minggu_perhari'    =>  $result_hseobs->minggu,
                'user_mananger_id'  =>  $mananger->id
            ]);

            $result_users = DB::table('hseobs')->where('hse_nik', Auth::user()->email)->orderBy('id_hseobs', 'desc')->first();

            // insert real time
            DB::table('real_time_observasi')->insert([
                'waktu_real_time'   =>  now(),
                'pesan_real_time'   =>  Auth::user()->name .  " Mengirim Observasi Ke Area Manager",
                'hseobs_id'    =>  $result_users->id_hseobs,
                'user_id'   =>  Auth::user()->id,
                'status_real'   =>  1,
                'mananger_id_user'  =>  Auth::user()->mananger_user
            ]);

            // insert submission chart
            $event = DB::table('positions')->where('id_positions', $data_area)->first();
            $users_manangers = DB::table('users')->where('email', Auth::user()->mananger_user)->first();
            $submission_observasi = DB::table('submission_observasi')->where('user_mananger_id',$users_manangers->id)->where('type_aktifitas_submission',$request->type)->first();
            if(!$submission_observasi) {
                DB::table('submission_observasi')->insert([
                    'type_aktifitas_submission' =>  $request->type,
                    'kondisi_observasi_submission_satu'  =>  'Tindakan aman',
                    'area_submission'   =>  $event->positions,
                    'user_mananger_id'  =>  $users_manangers->id,
                    'waktu_submission'  =>  now(),
                    // 'score_submission_satu'  =>   1,
                    'kondisi_observasi_submission_dua' =>  'Tindakan tidak aman',
                    'kondisi_observasi_submission_tiga' =>  'Kondisi aman',
                    'kondisi_observasi_submission_empat' =>  'Kondisi tidak aman',
                    'kondisi_observasi_submission_lima' =>  'Nearmiss/nyaris celaka',
                    'kondisi_observasi_submission_enam' =>  'Accident',
                ]);
                
            }

            $now = date("Y-m-d");
            $users_manager = DB::table('users')->where('email', Auth::user()->mananger_user)->first();
            $users_manangers = DB::table('users')->where('email', Auth::user()->mananger_user)->first();
            $submission_grafik = DB::table('submission_observasi')->where('waktu_submission', $now)->where('user_mananger_id', $users_manager->id)->where('type_aktifitas_submission', $request->type)->orderBy('id_submission_observasi', 'desc')->first();

            if ($submission_grafik->kondisi_observasi_submission_satu == $request->observasi) {
                DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_satu', $request->observasi)->update([
                    'type_aktifitas_submission' =>  $request->type,
                    // 'kondisi_observasi_submission_satu'  =>  $request->observasi,
                    'area_submission'   =>  $event->positions,
                    'user_mananger_id'  =>  $users_manangers->id,
                    'waktu_submission'  =>  now(),
                    'score_submission_satu'  =>  $submission_grafik->score_submission_satu + 1
                ]);
            } elseif ($submission_grafik->kondisi_observasi_submission_dua == $request->observasi) {
                DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_dua', $request->observasi)->update([
                    'type_aktifitas_submission' =>  $request->type,
                    'area_submission'   =>  $event->positions,
                    'user_mananger_id'  =>  $users_manangers->id,
                    'waktu_submission'  =>  now(),
                    // 'kondisi_observasi_submission_dua'  =>  $request->observasi,
                    'score_submission_dua'  =>  $submission_grafik->score_submission_dua + 1
                ]);
            } elseif ($submission_grafik->kondisi_observasi_submission_tiga == $request->observasi) {
                DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_tiga', $request->observasi)->update([
                    'type_aktifitas_submission' =>  $request->type,
                    'area_submission'   =>  $event->positions,
                    'user_mananger_id'  =>  $users_manangers->id,
                    'waktu_submission'  =>  now(),
                    // 'kondisi_observasi_submission_tiga'  =>  $request->observasi,
                    'score_submission_tiga'  =>  $submission_grafik->score_submission_tiga + 1
                ]);
            } elseif ($submission_grafik->kondisi_observasi_submission_empat == $request->observasi) {
                DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_empat', $request->observasi)->update([
                    'type_aktifitas_submission' =>  $request->type,
                    'area_submission'   =>  $event->positions,
                    'user_mananger_id'  =>  $users_manangers->id,
                    'waktu_submission'  =>  now(),
                    // 'kondisi_observasi_submission_empat'  =>  $request->observasi,
                    'score_submission_empat'  =>  $submission_grafik->score_submission_empat + 1
                ]);
            } elseif ($submission_grafik->kondisi_observasi_submission_lima == $request->observasi) {
                DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_lima', $request->observasi)->update([
                    'type_aktifitas_submission' =>  $request->type,
                    'area_submission'   =>  $event->positions,
                    'user_mananger_id'  =>  $users_manangers->id,
                    'waktu_submission'  =>  now(),
                    // 'kondisi_observasi_submission_lima'  =>  $request->observasi,
                    'score_submission_lima'  =>  $submission_grafik->score_submission_lima + 1
                ]);
            } elseif ($submission_grafik->kondisi_observasi_submission_enam == $request->observasi) {
                DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_enam', $request->observasi)->update([
                    'type_aktifitas_submission' =>  $request->type,
                    'area_submission'   =>  $event->positions,
                    'user_mananger_id'  =>  $users_manangers->id,
                    'waktu_submission'  =>  now(),
                    // 'kondisi_observasi_submission_enam'  =>  $request->observasi,
                    'score_submission_enam'  =>  $submission_grafik->score_submission_enam + 1
                ]);
            }
            var_dump($result_hseobs);
            return redirect('home_pengawas')->with('status', 'Data Berhasil Di Tambahkan');
        } elseif ($result->expired == date('d-m-Y')) {
            $result_data = DB::table('hseobs')->where('hse_nik', Auth::user()->email)->where('expired', $sekarang)->where('user_id',$users_akun->id)->orderBy('id_hseobs', 'desc')->count();
            if ($result_data >= 4) {
                $now = date("Y-m-d");
                $mananger_id_user = DB::table('users')->where('email',Auth::user()->mananger_user)->first();
                $minggu = DB::table('laporan_minggu')->orderBy('id_laporan_minggu', 'desc')->first();

                $presentasi = DB::table('persentasi_proses')->where('user_id', Auth::user()->id)->where('waktu',$minggu->waktu_laporan_minggu)->where('mananger_id',$mananger_id_user->id)->orderBy('id_persentasi_proses', 'desc')->first();
                $waktu_minggu = date('Y-m-d', strtotime('+6 days', strtotime($now)));
                if($presentasi) {
                    DB::table('persentasi_proses')->where('user_id', Auth::user()->id)->where('waktu', $minggu->waktu_laporan_minggu)->where('status_proses', 120)->where('mananger_id',$mananger_id_user->id)->orderBy('id_persentasi_proses', 'desc')->update([
                        'status_proses' =>  $presentasi->status_proses - 20
                    ]);
                }
                return redirect('home_pengawas')->with('status', 'Anda Sudah Melebihi Submission Hari Ini,Silahkan Isi Submission Untuk Besok');
            } else {
                $result_hseobs = DB::table('hseobs')->insert([
                    'hse_nik'   =>  Auth::user()->email,
                    'hse_name'  =>  Auth::user()->name,
                    'location'  =>  $request->kejadian,
                    'type_activity' =>  $request->type,
                    'event' =>  $data_area,
                    'cabang'   =>   $data_cabang,
                    'user_id'   =>  $data_mananger,
                    'kondisi_observasi' =>  $request->observasi,
                    'expired'   =>  date("d-m-Y"),
                    'mulai_kerja'   =>  $request->mulai,
                    'selesai_kerja' =>  $request->selesai,
                    'amati' =>  $request->amati,
                    'perbaikan' =>  $request->perbaikan,
                    'terulang'  =>  $request->terulang,
                    'img_hseobs'   =>  $gambar,
                    'dibuat_hseobs' =>  now(),
                    'minggu'    =>  1
                ]);

                $akun_menenger_id = DB::table('users')->where('email', Auth::user()->mananger_user)->first();

                $details = [
                    'title' =>  'Konfirmasi Status Observasi User Pengawas',
                    'body'  => "data",
                    'email' =>  $akun_menenger_id->email_address_id
                ];

                \Mail::to($akun_menenger_id->email_address_id)->send(new \App\Mail\mananger($details));

                $persentase = DB::table('persentasi_proses')->where('user_id', Auth::user()->id)->orderBy('id_persentasi_proses', 'desc')->first();
                $mananger_id = DB::table('users')->where('email', Auth::user()->mananger_user)->first();
                DB::table('persentasi_proses')->where('user_id', Auth::user()->id)->orderBy('id_persentasi_proses','desc')->update([
                    'persen' =>    $persentase->persen + 1,
                    'waktu' =>  now(),
                    'status_proses' =>  $persentase->status_proses + 5,
                    'mananger_id'   =>  $mananger_id->id
                ]);

                $mananger = DB::table('users')->where('email', Auth::user()->mananger_user)->first();
                $now = date('Y-m-d');
                $result_hseobs = DB::table('hseobs')->where('hse_nik', Auth::user()->email)->where('user_id', $mananger_id->id)->orderBy('id_hseobs', 'desc')->first();
                $laporan_perhari = DB::table('laporan_perhari')->where('user_pengawas_id', Auth::user()->id)->where('user_mananger_id', $mananger->id)->where('time_perhari', $now)->where('minggu_perhari', $result_hseobs->minggu)->first();

                DB::table('laporan_perhari')->where('user_pengawas_id', Auth::user()->id)->where('user_mananger_id', $mananger->id)->where('time_perhari', $now)->where('minggu_perhari', $result_hseobs->minggu)->update([
                    'total_persen'  => $laporan_perhari->total_persen + 1,
                    'time_perhari'  =>  now(),
                    'user_pengawas_id'  =>  Auth::user()->id,
                    'status_perhari'    =>  $laporan_perhari->status_perhari + 5,
                    'user_mananger_id'  =>  $mananger->id
                ]);

                $result_users = DB::table('hseobs')->where('hse_nik', Auth::user()->email)->orderBy('id_hseobs', 'desc')->first();

                DB::table('real_time_observasi')->insert([
                    'waktu_real_time'   =>  now(),
                    'pesan_real_time'   =>  Auth::user()->name .  " Mengirim Observasi Ke Area Manager",
                    'hseobs_id'    =>  $result_users->id_hseobs,
                    'user_id'   =>  Auth::user()->id,
                    'status_real'   =>  1,
                    'mananger_id_user'  =>  Auth::user()->mananger_user
                ]);

                // insert submission chart
                $event = DB::table('positions')->where('id_positions', $data_area)->first();
                $now = date("Y-m-d");
                $users_manager = DB::table('users')->where('email', Auth::user()->mananger_user)->first();
                $users_manangers = DB::table('users')->where('email', Auth::user()->mananger_user)->first();
                $submission_data = DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('user_mananger_id', $users_manager->id)->where('waktu_submission', $now)->first();

                if ($submission_data) {
                    if ($submission_data->kondisi_observasi_submission_satu == $request->observasi) {
                        DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_satu', $request->observasi)->update([
                            'type_aktifitas_submission' =>  $request->type,
                            // 'kondisi_observasi_submission_satu'  =>  $request->observasi,
                            'area_submission'   =>  $event->positions,
                            'user_mananger_id'  =>  $users_manangers->id,
                            'waktu_submission'  =>  now(),
                            'score_submission_satu'  =>  $submission_data->score_submission_satu + 1
                        ]);
                    } elseif ($submission_data->kondisi_observasi_submission_dua == $request->observasi) {
                        DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_dua', $request->observasi)->update([
                            'type_aktifitas_submission' =>  $request->type,
                            'area_submission'   =>  $event->positions,
                            'user_mananger_id'  =>  $users_manangers->id,
                            'waktu_submission'  =>  now(),
                            // 'kondisi_observasi_submission_dua'  =>  $request->observasi,
                            'score_submission_dua'  =>  $submission_data->score_submission_dua + 1
                        ]);
                    } elseif ($submission_data->kondisi_observasi_submission_tiga == $request->observasi) {
                        DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_tiga', $request->observasi)->update([
                            'type_aktifitas_submission' =>  $request->type,
                            'area_submission'   =>  $event->positions,
                            'user_mananger_id'  =>  $users_manangers->id,
                            'waktu_submission'  =>  now(),
                            // 'kondisi_observasi_submission_tiga'  =>  $request->observasi,
                            'score_submission_tiga'  =>  $submission_data->score_submission_tiga + 1
                        ]);
                    } elseif ($submission_data->kondisi_observasi_submission_empat == $request->observasi) {
                        DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_empat', $request->observasi)->update([
                            'type_aktifitas_submission' =>  $request->type,
                            'area_submission'   =>  $event->positions,
                            'user_mananger_id'  =>  $users_manangers->id,
                            'waktu_submission'  =>  now(),
                            // 'kondisi_observasi_submission_empat'  =>  $request->observasi,
                            'score_submission_empat'  =>  $submission_data->score_submission_empat + 1
                        ]);
                    } elseif ($submission_data->kondisi_observasi_submission_lima == $request->observasi) {
                        DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_lima', $request->observasi)->update([
                            'type_aktifitas_submission' =>  $request->type,
                            'area_submission'   =>  $event->positions,
                            'user_mananger_id'  =>  $users_manangers->id,
                            'waktu_submission'  =>  now(),
                            // 'kondisi_observasi_submission_lima'  =>  $request->observasi,
                            'score_submission_lima'  =>  $submission_data->score_submission_lima + 1
                        ]);
                    } elseif ($submission_data->kondisi_observasi_submission_enam == $request->observasi) {
                        DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_enam', $request->observasi)->update([
                            'type_aktifitas_submission' =>  $request->type,
                            'area_submission'   =>  $event->positions,
                            'user_mananger_id'  =>  $users_manangers->id,
                            'waktu_submission'  =>  now(),
                            // 'kondisi_observasi_submission_enam'  =>  $request->observasi,
                            'score_submission_enam'  =>  $submission_data->score_submission_enam + 1
                        ]);
                    }
                } else {
                    // insert submission chart
                    $event = DB::table('positions')->where('id_positions', $data_area)->first();
                    $users_manangers = DB::table('users')->where('email', Auth::user()->mananger_user)->first();
                    DB::table('submission_observasi')->insert([
                        'type_aktifitas_submission' =>  $request->type,
                        'kondisi_observasi_submission_satu'  =>  'Tindakan aman',
                        'area_submission'   =>  $event->positions,
                        'user_mananger_id'  =>  $users_manangers->id,
                        'waktu_submission'  =>  now(),
                        // 'score_submission_satu'  =>   1,
                        'kondisi_observasi_submission_dua' =>  'Tindakan tidak aman',
                        'kondisi_observasi_submission_tiga' =>  'Kondisi aman',
                        'kondisi_observasi_submission_empat' =>  'Kondisi tidak aman',
                        'kondisi_observasi_submission_lima' =>  'Nearmiss/nyaris celaka',
                        'kondisi_observasi_submission_enam' =>  'Accident',
                    ]);

                    $now = date("Y-m-d");
                    $users_manangers = DB::table('users')->where('email', Auth::user()->mananger_user)->first();
                    $submission_grafik = DB::table('submission_observasi')->where('waktu_submission', $now)->where('user_mananger_id', $users_manager->id)->where('type_aktifitas_submission', $request->type)->orderBy('id_submission_observasi', 'desc')->first();

                    if ($submission_grafik->kondisi_observasi_submission_satu == $request->observasi) {
                        DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_satu', $request->observasi)->update([
                            'type_aktifitas_submission' =>  $request->type,
                            // 'kondisi_observasi_submission_satu'  =>  $request->observasi,
                            'area_submission'   =>  $event->positions,
                            'user_mananger_id'  =>  $users_manangers->id,
                            'waktu_submission'  =>  now(),
                            'score_submission_satu'  =>  $submission_grafik->score_submission_satu + 1
                        ]);
                    } elseif ($submission_grafik->kondisi_observasi_submission_dua == $request->observasi) {
                        DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_dua', $request->observasi)->update([
                            'type_aktifitas_submission' =>  $request->type,
                            'area_submission'   =>  $event->positions,
                            'user_mananger_id'  =>  $users_manangers->id,
                            'waktu_submission'  =>  now(),
                            // 'kondisi_observasi_submission_dua'  =>  $request->observasi,
                            'score_submission_dua'  =>  $submission_grafik->score_submission_dua + 1
                        ]);
                    } elseif ($submission_grafik->kondisi_observasi_submission_tiga == $request->observasi) {
                        DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_tiga', $request->observasi)->update([
                            'type_aktifitas_submission' =>  $request->type,
                            'area_submission'   =>  $event->positions,
                            'user_mananger_id'  =>  $users_manangers->id,
                            'waktu_submission'  =>  now(),
                            // 'kondisi_observasi_submission_tiga'  =>  $request->observasi,
                            'score_submission_tiga'  =>  $submission_grafik->score_submission_tiga + 1
                        ]);
                    } elseif ($submission_grafik->kondisi_observasi_submission_empat == $request->observasi) {
                        DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_empat', $request->observasi)->update([
                            'type_aktifitas_submission' =>  $request->type,
                            'area_submission'   =>  $event->positions,
                            'user_mananger_id'  =>  $users_manangers->id,
                            'waktu_submission'  =>  now(),
                            // 'kondisi_observasi_submission_empat'  =>  $request->observasi,
                            'score_submission_empat'  =>  $submission_grafik->score_submission_empat + 1
                        ]);
                    } elseif ($submission_grafik->kondisi_observasi_submission_lima == $request->observasi) {
                        DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_lima', $request->observasi)->update([
                            'type_aktifitas_submission' =>  $request->type,
                            'area_submission'   =>  $event->positions,
                            'user_mananger_id'  =>  $users_manangers->id,
                            'waktu_submission'  =>  now(),
                            // 'kondisi_observasi_submission_lima'  =>  $request->observasi,
                            'score_submission_lima'  =>  $submission_grafik->score_submission_lima + 1
                        ]);
                    } elseif ($submission_grafik->kondisi_observasi_submission_enam == $request->observasi) {
                        DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_enam', $request->observasi)->update([
                            'type_aktifitas_submission' =>  $request->type,
                            'area_submission'   =>  $event->positions,
                            'user_mananger_id'  =>  $users_manangers->id,
                            'waktu_submission'  =>  now(),
                            // 'kondisi_observasi_submission_enam'  =>  $request->observasi,
                            'score_submission_enam'  =>  $submission_grafik->score_submission_enam + 1
                        ]);
                    }
                }
                var_dump($result_hseobs);
                return redirect('home_pengawas')->with('status', 'Data Berhasil Di Tambahkan');
            }
        } else {
            $user_id = DB::table('users')->where('email', Auth::user()->mananger_user)->first();
            $minggu = DB::table('laporan_minggu')->orderBy('id_laporan_minggu', 'desc')->first();
            $hseobs = DB::table('hseobs')->where('user_id', $user_id->id)->orderBy('id_hseobs', 'desc')->first();
            if ($hseobs->dibuat_hseobs == $minggu->waktu_laporan_minggu) {
                $result_hseobs = DB::table('hseobs')->insert([
                    'hse_nik'   =>  Auth::user()->email,
                    'hse_name'  =>  Auth::user()->name,
                    'location'  =>  $request->kejadian,
                    'type_activity' =>  $request->type,
                    'event' =>  $data_area,
                    'cabang'   =>   $data_cabang,
                    'user_id'   =>  $data_mananger,
                    'kondisi_observasi' =>  $request->observasi,
                    'expired'   =>  date("d-m-Y"),
                    'mulai_kerja'   =>  $request->mulai,
                    'selesai_kerja' =>  $request->selesai,
                    'amati' =>  $request->amati,
                    'perbaikan' =>  $request->perbaikan,
                    'terulang'  =>  $request->terulang,
                    'img_hseobs'   =>  $gambar,
                    'dibuat_hseobs' =>  now(),
                    'minggu'    =>  $hseobs->minggu + 1
                ]);
            } else {
                $result_hseobs = DB::table('hseobs')->insert([
                    'hse_nik'   =>  Auth::user()->email,
                    'hse_name'  =>  Auth::user()->name,
                    'location'  =>  $request->kejadian,
                    'type_activity' =>  $request->type,
                    'event' =>  $data_area,
                    'cabang'   =>   $data_cabang,
                    'user_id'   =>  $data_mananger,
                    'kondisi_observasi' =>  $request->observasi,
                    'expired'   =>  date("d-m-Y"),
                    'mulai_kerja'   =>  $request->mulai,
                    'selesai_kerja' =>  $request->selesai,
                    'amati' =>  $request->amati,
                    'perbaikan' =>  $request->perbaikan,
                    'terulang'  =>  $request->terulang,
                    'img_hseobs'   =>  $gambar,
                    'dibuat_hseobs' =>  now(),
                    'minggu'    =>  1
                ]);
            }
            // var_dump($result_hseobs);
            // die;
            $akun_menenger_id = DB::table('users')->where('email', Auth::user()->mananger_user)->first();

            $details = [
                'title' =>  'Konfirmasi Status Observasi User Pengawas',
                'body'  => "data",
                'email' =>  $akun_menenger_id->email_address_id
            ];

            \Mail::to($akun_menenger_id->email_address_id)->send(new \App\Mail\mananger($details));

            $now = date("Y-m-d");
            $waktu_minggu = date('Y-m-d', strtotime('+6 days', strtotime($now)));
            $mananger_id = DB::table('users')->where('email', Auth::user()->mananger_user)->first();
            $result_hseobs = DB::table('hseobs')->where('hse_nik', Auth::user()->email)->where('user_id', $mananger_id->id)->orderBy('id_hseobs', 'desc')->first();
            $data_persentasi = DB::table('persentasi_proses')->where('user_id', Auth::user()->id)->where('mananger_id', $mananger_id->id)->where('expired_proses', $result_hseobs->minggu)->first();

            DB::table('persentasi_proses')->where('user_id', Auth::user()->id)->where('mananger_id', $mananger_id->id)->where('expired_proses', $result_hseobs->minggu)->update([
                'persen'    =>  $data_persentasi->persen + 1,
                'waktu' =>  now(),
                'user_id'   =>  Auth::user()->id,
                'status_proses' =>  $data_persentasi->status_proses + 5,
                'mananger_id'    => $mananger_id->id,
            ]);

            $mananger = DB::table('users')->where('email', Auth::user()->mananger_user)->first();
            $now = date('Y-m-d');
            $laporan_perhari = DB::table('laporan_perhari')->where('user_pengawas_id', Auth::user()->id)->where('user_mananger_id', $mananger->id)->where('time_perhari', $now)->where('minggu_perhari', $result_hseobs->minggu)->first();

            DB::table('laporan_perhari')->where('user_pengawas_id', Auth::user()->id)->where('user_mananger_id', $mananger->id)->insert([
                'total_persen'  => 1,
                'time_perhari'  =>  now(),
                'user_pengawas_id'  =>  Auth::user()->id,
                'status_perhari'    =>  5,
                'minggu_perhari'    =>  $result_hseobs->minggu,
                'user_mananger_id'  =>  $mananger->id
            ]);

            $result_users = DB::table('hseobs')->where('hse_nik', Auth::user()->email)->orderBy('id_hseobs', 'desc')->first();

            DB::table('real_time_observasi')->insert([
                'waktu_real_time'   =>  now(),
                'pesan_real_time'   =>  Auth::user()->name .  " Mengirim Observasi Ke Area Manager",
                'hseobs_id'    =>  $result_users->id_hseobs,
                'user_id'   =>  Auth::user()->id,
                'status_real'   =>  1,
                'mananger_id_user'  =>  Auth::user()->mananger_user
            ]);

            // insert submission chart
            $event = DB::table('positions')->where('id_positions', $data_area)->first();

            $now = date("Y-m-d");
            $users_manager = DB::table('users')->where('email', Auth::user()->mananger_user)->first();
            $users_manangers = DB::table('users')->where('email', Auth::user()->mananger_user)->first();
            $submission_grafik = DB::table('submission_observasi')->where('waktu_submission', $now)->where('user_mananger_id', $users_manager->id)->where('type_aktifitas_submission', $request->type)->orderBy('id_submission_observasi', 'desc')->first();

            if (!$submission_grafik) {
                $event = DB::table('positions')->where('id_positions', $data_area)->first();
                $users_manangers = DB::table('users')->where('email', Auth::user()->mananger_user)->first();
                DB::table('submission_observasi')->insert([
                    'type_aktifitas_submission' =>  $request->type,
                    'kondisi_observasi_submission_satu'  =>  'Tindakan aman',
                    'area_submission'   =>  $event->positions,
                    'user_mananger_id'  =>  $users_manangers->id,
                    'waktu_submission'  =>  now(),
                    // 'score_submission_satu'  =>   1,
                    'kondisi_observasi_submission_dua' =>  'Tindakan tidak aman',
                    'kondisi_observasi_submission_tiga' =>  'Kondisi aman',
                    'kondisi_observasi_submission_empat' =>  'Kondisi tidak aman',
                    'kondisi_observasi_submission_lima' =>  'Nearmiss/nyaris celaka',
                    'kondisi_observasi_submission_enam' =>  'Accident',
                ]);
                
                $submission_grafik = DB::table('submission_observasi')->where('waktu_submission', $now)->where('user_mananger_id', $users_manager->id)->where('type_aktifitas_submission', $request->type)->orderBy('id_submission_observasi', 'desc')->first();
                if ($submission_grafik->kondisi_observasi_submission_satu == $request->observasi) {
                    DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_satu', $request->observasi)->update([
                        'type_aktifitas_submission' =>  $request->type,
                        // 'kondisi_observasi_submission_satu'  =>  $request->observasi,
                        'area_submission'   =>  $event->positions,
                        'user_mananger_id'  =>  $users_manangers->id,
                        'waktu_submission'  =>  now(),
                        'score_submission_satu'  =>  $submission_grafik->score_submission_satu + 1
                    ]);
                } elseif ($submission_grafik->kondisi_observasi_submission_dua == $request->observasi) {
                    DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_dua', $request->observasi)->update([
                        'type_aktifitas_submission' =>  $request->type,
                        'area_submission'   =>  $event->positions,
                        'user_mananger_id'  =>  $users_manangers->id,
                        'waktu_submission'  =>  now(),
                        // 'kondisi_observasi_submission_dua'  =>  $request->observasi,
                        'score_submission_dua'  =>  $submission_grafik->score_submission_dua + 1
                    ]);
                } elseif ($submission_grafik->kondisi_observasi_submission_tiga == $request->observasi) {
                    DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_tiga', $request->observasi)->update([
                        'type_aktifitas_submission' =>  $request->type,
                        'area_submission'   =>  $event->positions,
                        'user_mananger_id'  =>  $users_manangers->id,
                        'waktu_submission'  =>  now(),
                        // 'kondisi_observasi_submission_tiga'  =>  $request->observasi,
                        'score_submission_tiga'  =>  $submission_grafik->score_submission_tiga + 1
                    ]);
                } elseif ($submission_grafik->kondisi_observasi_submission_empat == $request->observasi) {
                    DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_empat', $request->observasi)->update([
                        'type_aktifitas_submission' =>  $request->type,
                        'area_submission'   =>  $event->positions,
                        'user_mananger_id'  =>  $users_manangers->id,
                        'waktu_submission'  =>  now(),
                        // 'kondisi_observasi_submission_empat'  =>  $request->observasi,
                        'score_submission_empat'  =>  $submission_grafik->score_submission_empat + 1
                    ]);
                } elseif ($submission_grafik->kondisi_observasi_submission_lima == $request->observasi) {
                    DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_lima', $request->observasi)->update([
                        'type_aktifitas_submission' =>  $request->type,
                        'area_submission'   =>  $event->positions,
                        'user_mananger_id'  =>  $users_manangers->id,
                        'waktu_submission'  =>  now(),
                        // 'kondisi_observasi_submission_lima'  =>  $request->observasi,
                        'score_submission_lima'  =>  $submission_grafik->score_submission_lima + 1
                    ]);
                } elseif ($submission_grafik->kondisi_observasi_submission_enam == $request->observasi) {
                    DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_enam', $request->observasi)->update([
                        'type_aktifitas_submission' =>  $request->type,
                        'area_submission'   =>  $event->positions,
                        'user_mananger_id'  =>  $users_manangers->id,
                        'waktu_submission'  =>  now(),
                        // 'kondisi_observasi_submission_enam'  =>  $request->observasi,
                        'score_submission_enam'  =>  $submission_grafik->score_submission_enam + 1
                    ]);
                }
                var_dump($result_hseobs);
                return redirect('home_pengawas')->with('status', 'Data Berhasil Di Tambahkan');
            } else {
                if ($submission_grafik->kondisi_observasi_submission_satu == $request->observasi) {
                    DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_satu', $request->observasi)->update([
                        'type_aktifitas_submission' =>  $request->type,
                        // 'kondisi_observasi_submission_satu'  =>  $request->observasi,
                        'area_submission'   =>  $event->positions,
                        'user_mananger_id'  =>  $users_manangers->id,
                        'waktu_submission'  =>  now(),
                        'score_submission_satu'  =>  $submission_grafik->score_submission_satu + 1
                    ]);
                } elseif ($submission_grafik->kondisi_observasi_submission_dua == $request->observasi) {
                    DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_dua', $request->observasi)->update([
                        'type_aktifitas_submission' =>  $request->type,
                        'area_submission'   =>  $event->positions,
                        'user_mananger_id'  =>  $users_manangers->id,
                        'waktu_submission'  =>  now(),
                        // 'kondisi_observasi_submission_dua'  =>  $request->observasi,
                        'score_submission_dua'  =>  $submission_grafik->score_submission_dua + 1
                    ]);
                } elseif ($submission_grafik->kondisi_observasi_submission_tiga == $request->observasi) {
                    DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_tiga', $request->observasi)->update([
                        'type_aktifitas_submission' =>  $request->type,
                        'area_submission'   =>  $event->positions,
                        'user_mananger_id'  =>  $users_manangers->id,
                        'waktu_submission'  =>  now(),
                        // 'kondisi_observasi_submission_tiga'  =>  $request->observasi,
                        'score_submission_tiga'  =>  $submission_grafik->score_submission_tiga + 1
                    ]);
                } elseif ($submission_grafik->kondisi_observasi_submission_empat == $request->observasi) {
                    DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_empat', $request->observasi)->update([
                        'type_aktifitas_submission' =>  $request->type,
                        'area_submission'   =>  $event->positions,
                        'user_mananger_id'  =>  $users_manangers->id,
                        'waktu_submission'  =>  now(),
                        // 'kondisi_observasi_submission_empat'  =>  $request->observasi,
                        'score_submission_empat'  =>  $submission_grafik->score_submission_empat + 1
                    ]);
                } elseif ($submission_grafik->kondisi_observasi_submission_lima == $request->observasi) {
                    DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_lima', $request->observasi)->update([
                        'type_aktifitas_submission' =>  $request->type,
                        'area_submission'   =>  $event->positions,
                        'user_mananger_id'  =>  $users_manangers->id,
                        'waktu_submission'  =>  now(),
                        // 'kondisi_observasi_submission_lima'  =>  $request->observasi,
                        'score_submission_lima'  =>  $submission_grafik->score_submission_lima + 1
                    ]);
                } elseif ($submission_grafik->kondisi_observasi_submission_enam == $request->observasi) {
                    DB::table('submission_observasi')->where('type_aktifitas_submission', $request->type)->where('kondisi_observasi_submission_enam', $request->observasi)->update([
                        'type_aktifitas_submission' =>  $request->type,
                        'area_submission'   =>  $event->positions,
                        'user_mananger_id'  =>  $users_manangers->id,
                        'waktu_submission'  =>  now(),
                        // 'kondisi_observasi_submission_enam'  =>  $request->observasi,
                        'score_submission_enam'  =>  $submission_grafik->score_submission_enam + 1
                    ]);
                }
                var_dump($result_hseobs);
                return redirect('home_pengawas')->with('status', 'Data Berhasil Di Tambahkan');
            }
        }
        var_dump($result_hseobs);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hapus_observasi($id)
    {
        DB::table('hseobs')->where('id_hseobs', $id)->delete();
        return redirect('home_pengawas')->with('status', 'Data Berhasil Di Hapus');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_observasi_pengawas(Request $request, $id)
    {
        $request->validate([
            'nama'  =>  'required',
            // 'jam'   =>  'required',
            // 'manager'   =>  'required',
            // 'cabang'   =>  'required',
            // 'area'   =>  'required',
            'amati' =>  'required',
            'perbaikan' =>  'required',
            'mulai' =>  'required',
            'selesai'   =>  'required',
            'terulang'  =>  'required',
            'kejadian'   =>  'required',
            'observasi'   =>  'required',
        ]);

        if (!$request->file('img')) {
            // disini
            $gambar = $request->img_lama;
            $gambar_before = $request->img_hseobs_before;
        } else {
            $gambar_before =$request->img_lama;
            $gambar = $request->img->getClientOriginalName() . '-' . time() . '.' . $request->img->extension();
            $request->img->move(public_path('assets/img/'), $gambar);
        }

        DB::table('hseobs')->where('id_hseobs', $id)->update([
            'hse_nik'   =>  Auth::user()->email,
            'hse_name'  =>  $request->nama,
            'location'  =>  $request->kejadian,
            'type_activity' =>  $request->type,
            'kondisi_observasi' =>  $request->observasi,
            'mulai_kerja'   =>  $request->mulai,
            'selesai_kerja' =>  $request->selesai,
            'amati' =>  $request->amati,
            'perbaikan' =>  $request->perbaikan,
            'terulang'  => $request->terulang,
            'img_hseobs' => $gambar,
            'img_hseobs_before' => $gambar_before
        ]);

        return redirect('home_pengawas')->with('status', 'Data Berhasil Di Update');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function send_observasi(Request $request, $id)
    {
        DB::table('hseobs')->where('id_hseobs', $id)->update([
            'conditions'    =>  null,
            // 'coretive'  =>  null
        ]);

        $result_users = DB::table('hseobs')->where('hse_nik', Auth::user()->email)->where('id_hseobs', $id)->first();

        DB::table('real_time_observasi')->insert([
            'waktu_real_time'   =>  now(),
            'pesan_real_time'   =>  Auth::user()->name .  " Mengirim Ulang Observasi Ke Area Manager",
            'hseobs_id'    =>  $result_users->id_hseobs,
            'user_id'   =>  Auth::user()->id,
            'status_real'   =>  4,
            'mananger_id_user'  =>  Auth::user()->mananger_user
        ]);

        return redirect('home_pengawas')->with('status', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function edit_pengawas_profile(Request $request,$id)
    {
        $request->validate([
            'nama'  =>  'required',
            'nik'   =>  'required',
            'email' =>  'required',
        ]);

        if($request->password != $request->repeat) {
            return redirect('home_pengawas')->with('status','Password Tidak Sama');
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


        return redirect('home_pengawas')->with('status','Data Berhasil Di Update');
    }
}
