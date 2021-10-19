<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;


class Bulan implements FromView
{
    private $bulan;
    private $tahun;

    public function __construct($bulan,$tahun) 
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        return view('hse.print_hse_bulan', [
            'data' => DB::select("SELECT * FROM hseobs WHERE month(dibuat_hseobs) = '$this->bulan' AND year(dibuat_hseobs) = '$this->tahun'")
        ]);
    }

}

