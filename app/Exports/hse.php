<?php

namespace App\Exports;


use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class hse implements FromView
{
    public function view(): View
    {
        return view('hse.print_hse', [
            'data' => DB::table('hseobs')->get()
        ]);
    }
}