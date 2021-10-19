<?php

namespace App\Exports;


use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Tahun implements FromView
{
    private $tahun;

    public function __construct($tahun) 
    {
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        return view('hse.print_hse_tahun', [
            'data' => DB::select("SELECT * FROM hseobs WHERE year(dibuat_hseobs) = '$this->tahun'")
        ]);
    }

}