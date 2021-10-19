<?php

namespace App\Http\Controllers;

use Facade\FlareClient\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if($request->session()->get('login')) {
            return redirect('/home');
        } else {
            return redirect('/');
        }
    }

    public function login(Request $request)
    {
        if($request->session()->get('login')) {
            return redirect('/home');
        } else {
            return view('auth.login');
        }
    }
}
