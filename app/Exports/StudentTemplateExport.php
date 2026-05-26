<?php
namespace App\Exports;

use App\Models\Classes;
use App\Models\Company;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StudentTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new StudentTemplateSheet(),
            new ClassesSheet(),
            new CompaniesSheet(),
        ];
    }
}

// namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\WithStyles;
// use Maatwebsite\Excel\Concerns\WithColumnWidths;
// use Maatwebsite\Excel\Concerns\WithTitle;
// use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
// use PhpOffice\PhpSpreadsheet\Style\Fill;
// use PhpOffice\PhpSpreadsheet\Style\Alignment;
// use PhpOffice\PhpSpreadsheet\Style\Border;
// use Illuminate\Support\Collection;

// class StudentTemplateExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
// {
//     public function title(): string
//     {
//         return 'Data Siswa';
//     }

//     public function headings(): array
//     {
//         return [
//             'nama',
//             'email',
//             'nis',
//             'nisn',
//             'kelas',
//             'perusahaan',
//             'nickname',
//         ];
//     }

//     public function collection(): Collection
//     {
//         return collect([
//             [
//                 'nama'        => 'Budi Santoso',
//                 'email'        => 'budii@gmail.com',
//                 'nis'         => '22001',
//                 'nisn'        => '0012345678',
//                 'kelas'       => 'XII RPL 1',
//                 'perusahaan'  => 'PT Teknologi Nusantara',
//                 'nickname'    => 'Budi',
//             ],
//             [
//                 'nama'        => 'Siti Aminah',
//                 'email'        => 'sitii@gmail.com',
//                 'nis'         => '22002',
//                 'nisn'        => '0012345679',
//                 'kelas'       => 'XI RPL 2',
//                 'perusahaan'  => 'CV Digital Mandiri',
//                 'nickname'    => 'Siti',
//             ],
//             [
//                 'nama'        => 'Ahmad Fauzi',
//                 'email'        => 'achmadd@gmail.com',
//                 'nis'         => '22003',
//                 'nisn'        => '0012345680',
//                 'kelas'       => 'X TKJ 1',
//                 'perusahaan'  => 'PT Solusi Data',
//                 'nickname'    => 'Ahmad',
//             ],
//         ]);
//     }

//     public function columnWidths(): array
//     {
//         return [
//             'A' => 30,
//             'B' => 35,
//             'C' => 20,
//             'D' => 20,
//             'E' => 20,
//             'F' => 20,
//         ];
//     }

//     public function styles(Worksheet $sheet)
//     {
//         $sheet->getStyle('A1:F1')->applyFromArray([
//             'font' => [
//                 'bold'  => true,
//                 'color' => ['rgb' => 'FFFFFF'],
//                 'size'  => 12,
//             ],
//             'fill' => [
//                 'fillType'   => Fill::FILL_SOLID,
//                 'startColor' => ['rgb' => '1E88E5'],
//             ],
//             'alignment' => [
//                 'horizontal' => Alignment::HORIZONTAL_CENTER,
//                 'vertical'   => Alignment::VERTICAL_CENTER,
//             ],
//         ]);

//         $sheet->getStyle('A2:F3')->applyFromArray([
//             'fill' => [
//                 'fillType'   => Fill::FILL_SOLID,
//                 'startColor' => ['rgb' => 'E3F2FD'],
//             ],
//         ]);

//         $sheet->getRowDimension(1)->setRowHeight(25);

//         $sheet->getStyle('A1:F3')->applyFromArray([
//             'borders' => [
//                 'allBorders' => [
//                     'borderStyle' => Border::BORDER_THIN,
//                     'color'       => ['rgb' => 'BBDEFB'],
//                 ],
//             ],
//         ]);

//         $sheet->setCellValue('A5', '* Kolom password opsional, jika kosong default: password');
//         $sheet->getStyle('A5')->applyFromArray([
//             'font' => [
//                 'italic' => true,
//                 'color'  => ['rgb' => '888888'],
//                 'size'   => 10,
//             ],
//         ]);

//         $sheet->setCellValue('A6', '* Hapus baris contoh sebelum import');
//         $sheet->getStyle('A6')->applyFromArray([
//             'font' => [
//                 'italic' => true,
//                 'color'  => ['rgb' => 'E53935'],
//                 'size'   => 10,
//             ],
//         ]);

//         return [];
//     }
// }