<?php

namespace App\Exports;

use App\Models\Classes;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class ClassesSheet implements FromCollection,  WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function title(): string
    {
        return 'classes';
    }
    public function collection()
    {
        // dd(Classes::get());
        return Classes::select(
            'cls_code'
        )->get();
    }
}
