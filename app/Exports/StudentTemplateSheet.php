<?php

namespace App\Exports;

use App\Models\Classes;
use App\Models\Company;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class StudentTemplateSheet implements WithHeadings, WithEvents,  WithStyles, WithColumnWidths
{
    public function headings(): array
    {
        return [
            'nama',
            'email',
            'password',
            'nis',
            'nisn',
            'kelas',
            'perusahaan',
            'nickname',
        ];
    }
    // =========================
    // WIDTH COLUMN
    // =========================
    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 35,
            'C' => 25,
            'D' => 20,
            'E' => 20,
            'F' => 30,
            'G' => 35,
            'H' => 25,
        ];
    }

    // =========================
    // STYLE
    // =========================
    public function styles(Worksheet $sheet)
    {
        // HEADER
        $sheet->getStyle('A1:H1')->applyFromArray([
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

        // CONTOH ROW
        $sheet->getStyle('A2:H3')->applyFromArray([
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E3F2FD'],
            ],
        ]);

        // BORDER
        $sheet->getStyle('A1:H100')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['rgb' => 'BBDEFB'],
                ],
            ],
        ]);

        // HEIGHT HEADER
        $sheet->getRowDimension(1)->setRowHeight(25);

        // CATATAN
        $sheet->setCellValue(
            'A105',
            '* Kolom password opsional, jika kosong akan menggunakan password default.'
        );

        $sheet->getStyle('A105')->applyFromArray([
            'font' => [
                'italic' => true,
                'color'  => ['rgb' => '666666'],
                'size'   => 10,
            ],
        ]);

        $sheet->setCellValue(
            'A106',
            '* Pastikan data Jurusan, Kelas, dan Perusahaan telah tersedia sebelum import dilakukan.'
        );
        $sheet->getStyle('D2:E1000')
    ->getNumberFormat()
    ->setFormatCode('@');

        $sheet->getStyle('A106')->applyFromArray([
            'font' => [
                'italic' => true,
                'color'  => ['rgb' => 'E53935'],
                'size'   => 10,
            ],
        ]);

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                // ambil data dropdown
                $classes = Classes::pluck('cls_code')->toArray();
                $companies = Company::pluck('cmp_name')->toArray();

                // =========================
                // DROPDOWN KELAS
                // =========================
                for ($i = 2; $i <= 100; $i++) {

                    $validation = new DataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_STOP);
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);

                    $validation->setFormula1(
                        '"' . implode(',', $classes) . '"'
                    );

                    $sheet->getCell("F$i")
                        ->setDataValidation(clone $validation);
                }

                // =========================
                // DROPDOWN PERUSAHAAN
                // =========================
                for ($i = 2; $i <= 100; $i++) {

                    $validation = new DataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_STOP);
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);

                    $validation->setFormula1(
                        '"' . implode(',', $companies) . '"'
                    );

                    $sheet->getCell("G$i")
                        ->setDataValidation(clone $validation);
                }
            },
        ];
    }
    
}