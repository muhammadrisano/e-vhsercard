<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

// class area implements FromCollection,WithHeadings,ShouldAutoSize
// {
//     /**
//     * @return \Illuminate\Support\Collection
//     */
//     public function collection() 
//     {
//         return   DB::table('eksport_area')->get();
//     }

//     public function headings(): array
//     {
//         return  [
//             'No',
//             'Nama Area',
//             'Submitting',
//             'Jumlah Pengawas',
//             'Presentasi',
//             'Rank'
//         ];
//     }
// }

class area implements FromView
{
    public function view(): View
    {
        return view('hse.print_area', [
            'data' => DB::table('eksport_area')->where('type','CFS')->orderBy('submitting','asc')->get(),
            'type'  =>  'CFS'
        ]);
    }
}