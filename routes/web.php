<?php

use App\Http\Controllers\Administrator;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Hse as ControllersHse;
use App\Http\Controllers\Manager;
use App\Http\Controllers\User_Pengawas;
use App\Http\Middleware\hse;
use App\Http\Middleware\pengawas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[HomeController::class,'login']);

Auth::routes();

Route::get('/home',[User_Pengawas::class,'home']);

// pengawas
Route::middleware('pengawas')->group(function() {
    Route::get('/home_pengawas',[User_Pengawas::class,'index']);
    Route::get('/hapus_observasi/{id}',[User_Pengawas::class,'hapus_observasi']);
    Route::get('/send_observasi/{id}',[User_Pengawas::class,'send_observasi']);
    Route::post('/add_observasi',[User_Pengawas::class,'add_observasi']);
    Route::post('/edit_observasi_pengawas/{id}',[User_Pengawas::class,'edit_observasi_pengawas']);
    Route::post('/edit_pengawas_profile/{id}',[User_Pengawas::class,'edit_pengawas_profile']);
});

// manager
Route::middleware('manager')->group(function() {
    Route::get('/home_manager',[Manager::class,'index']);
    Route::get('/jam_monitoring',[Manager::class,'jam_monitoring']);
    Route::get('/laporan_minggu',[Manager::class,'laporan_minggu']);
    Route::post('/cari_mananger',[Manager::class,'cari_mananger']);
    Route::get('/area_pengawas',[Manager::class,'area_pengawas']);
    Route::get('/detail_perminggu/{id}/{hari}',[Manager::class,'detail_perminggu']);
    Route::get('/detail_perminggu_user_id/{id}/{hari}',[Manager::class,'detail_perminggu_user_id']);
    Route::get('/hapus_area_pengawas/{id}',[Manager::class,'hapus_area_pengawas']);
    Route::get('/hapus_observasi_manager/{id}',[Manager::class,'hapus_observasi_manager']);
    Route::post('/terima_observasi/{id}',[Manager::class,'terima_observasi']);
    Route::get('/hapus_jam/{id}',[Manager::class,'hapus_jam']);
    Route::get('/pengawas_manager',[Manager::class,'pengawas_manager']);
    Route::post('/add_pengawas',[Manager::class,'add_pengawas']);
    Route::post('/add_jam',[Manager::class,'add_jam']);
    Route::post('/add_area_pengawas',[Manager::class,'add_area_pengawas']);
    Route::post('/edit_observasi_tolak/{id}',[Manager::class,'edit_observasi_tolak']);
    Route::post('/edit_manager/{id}',[Manager::class,'edit_manager']);
    Route::get('/detail/{id}/{hari}',[Manager::class,'detail']);
    Route::get('/detail_observasi/{id}/{hari}',[Manager::class,'detail_observasi']);
    Route::get('/hapus_pengawas_manager/{id}',[Manager::class,'hapus_pengawas_manager']);
    Route::get('/type_area/{id}',[Manager::class,'type_area']);
    Route::get('/detail_pengawas_manager_id/{id}',[Manager::class,'detail_pengawas_manager_id']);
    Route::get('/hapus_pengawas_manager_id/{id}',[Manager::class,'hapus_pengawas_manager_id']);
    Route::get('/detail_pengawas_observasi/{id}/{positions}',[Manager::class,'detail_pengawas_observasi']);
});

// hse
Route::middleware('hse')->group(function() {
    Route::get('/home_hse',[ControllersHse::class,'index']);
    Route::get('/area',[ControllersHse::class,'area']);
    Route::get('/eksport',[ControllersHse::class,'eksport']);
    Route::get('/print_hse',[ControllersHse::class,'print_hse']);
    Route::get('/print_cfs/{id}',[ControllersHse::class,'print_cfs']);
    Route::get('/print_sfs/{id}',[ControllersHse::class,'print_sfs']);
    Route::post('/print_pertahun',[ControllersHse::class,'print_pertahun']);
    Route::post('/terimas_observasi/{id}',[ControllersHse::class,'terimas_observasi']);
    Route::post('/edit_pengawas_admin/{id}',[ControllersHse::class,'edit_pengawas_admin']);
    Route::post('/edit_pengawas_admins/{id}',[ControllersHse::class,'edit_pengawas_admins']);
    Route::post('/edit_hse_profile/{id}',[ControllersHse::class,'edit_hse_profile']);
    Route::post('/edit_mananger_admin/{id}',[ControllersHse::class,'edit_mananger_admin']);
    Route::post('/print_perbulan',[ControllersHse::class,'print_perbulan']);
    Route::get('/hapus_observasis/{id}',[ControllersHse::class,'hapus_observasis']);
    Route::post('/edits_observasi_tolak/{id}',[ControllersHse::class,'edits_observasi_tolak']);
    Route::post('/edit_hse_admin/{id}',[ControllersHse::class,'edit_hse_admin']);
    Route::post('/cari_waktu_hse',[ControllersHse::class,'cari_waktu_hse']);
    Route::post('/cari_kondisi',[ControllersHse::class,'cari_kondisi']);
    Route::post('/cari_hse',[ControllersHse::class,'cari_hse']);
    Route::get('/report_area',[ControllersHse::class,'report_area']);
    Route::get('/approval_hse',[ControllersHse::class,'approval_hse']);
    Route::get('/detail_approval/{id}',[ControllersHse::class,'detail_approval']);
    Route::get('/detail_pengawas_manager_id_hse/{id}',[ControllersHse::class,'detail_pengawas_manager_id_hse']);
    Route::get('/detail_pengawas_manager_id_hse/{id}',[ControllersHse::class,'detail_pengawas_manager_id_hse']);
    Route::get('/type_area_hse/{id}',[ControllersHse::class,'type_area_hse']);
    Route::get('/detail_approval_point/{id}/{point}',[ControllersHse::class,'detail_approval_point']);
    Route::get('/detail_pengawas_observasi_hse/{id}/{point}',[ControllersHse::class,'detail_pengawas_observasi_hse']);
    Route::get('/terimas_observasi_user/{id}/{point}/{id_user}',[ControllersHse::class,'terimas_observasi_user']);
    Route::post('/edits_observasi_tolak_hse/{id}/{point}/{id_user}',[ControllersHse::class,'edits_observasi_tolak_hse']);
    Route::get('/hapus_observasis_hse/{id}/{point}/{id_user}',[ControllersHse::class,'hapus_observasis_hse']);
});

// admin
Route::middleware('admin')->group(function() {
    Route::get('/home_admin',[Administrator::class,'index']);
    Route::get('/area_mananger',[Administrator::class,'area_mananger']);
    Route::get('/setting',[Administrator::class,'setting']);
    Route::get('/hse_audit',[Administrator::class,'hse_audit']);
    Route::get('/hapus_pengawas_admin/{id}',[Administrator::class,'hapus_pengawas_admin']);
    Route::get('/hapus_mananger_admin/{id}',[Administrator::class,'hapus_mananger_admin']);
    Route::get('/hapus_hse_admin/{id}',[Administrator::class,'hapus_hse_admin']);
    Route::post('/add_pengawas_admin',[Administrator::class,'add_pengawas_admin']);
    Route::post('/add_hse_admin',[Administrator::class,'add_hse_admin']);
    Route::post('/add_manager_admin',[Administrator::class,'add_manager_admin']);
    Route::post('/edit_profile/{id}',[Administrator::class,'edit_profile']);
});