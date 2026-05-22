<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Support\Collection;

class MentorTemplateExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    public function title(): string
    {
        return 'Data Guru';
    }

    public function headings(): array
    {
        return [
            'nama',
            'email',
            'no_gtk',
            'password',
        ];
    }

    public function collection(): Collection
    {
        return collect([
            [
                'nama'     => 'Budi Santoso',
                'email'    => 'budi@gmail.com',
                'no_gtk'   => '123456789',
                'password' => 'password123',
            ],
            [
                'nama'     => 'Siti Aminah',
                'email'    => 'siti@gmail.com',
                'no_gtk'   => '987654321',
                'password' => 'password123',
            ],
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 35,
            'C' => 20,
            'D' => 20,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold'  => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size'  => 12,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1E88E5'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A2:D3')->applyFromArray([
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E3F2FD'],
            ],
        ]);

        $sheet->getRowDimension(1)->setRowHeight(25);

        $sheet->getStyle('A1:D3')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['rgb' => 'BBDEFB'],
                ],
            ],
        ]);

        $sheet->setCellValue('A5', '* Kolom password opsional, jika kosong default: password');
        $sheet->getStyle('A5')->applyFromArray([
            'font' => [
                'italic' => true,
                'color'  => ['rgb' => '888888'],
                'size'   => 10,
            ],
        ]);

        $sheet->setCellValue('A6', '* Hapus baris contoh sebelum import');
        $sheet->getStyle('A6')->applyFromArray([
            'font' => [
                'italic' => true,
                'color'  => ['rgb' => 'E53935'],
                'size'   => 10,
            ],
        ]);

        return [];
    }
}