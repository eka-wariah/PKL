<?php

namespace App\Exports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class CompaniesSheet implements FromCollection,  WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function title(): string
    {
        return 'companies';
    }
    public function collection()
    {
        return Company::select(
            'cmp_id',
            'cmp_name'
        )->get();
    }
}
