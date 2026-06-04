<?php

namespace App\Exports;

use App\Models\MentorAssignments;
use App\Models\News;
use App\Models\NewsParticipant;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class AttendanceReportExport implements WithStyles, WithColumnWidths, WithTitle, WithEvents
{
    protected $mentor;
    protected $month;
    protected $year;
    protected $students;
    protected $dates;
    protected $attendanceData;

    public function __construct($mentor, $month, $year)
    {
        $this->mentor = $mentor;
        $this->month  = $month;
        $this->year   = $year;
        $this->prepare();
    }

    protected function prepare()
    {
        // ambil semua tanggal bimbingan dalam bulan tsb
        $this->dates = News::where('news_mentor_id', $this->mentor->mtr_id)
            ->whereMonth('news_date', $this->month)
            ->whereYear('news_date', $this->year)
            ->whereNull('news_deleted_at')
            ->orderBy('news_date')
            ->pluck('news_date', 'news_id');

        // ambil semua siswa bimbingan mentor
        $this->students = MentorAssignments::with('student.user')
            ->where('mas_mentor_id', $this->mentor->mtr_id)
            ->get()
            ->pluck('student')
            ->filter();

        // ambil data kehadiran
        $participants = NewsParticipant::with('news')
            ->whereIn('nwp_news_id', $this->dates->keys())
            ->whereNull('nwp_deleted_at')
            ->get();

        // susun data: [student_id][news_id] = status
        foreach ($participants as $p) {
            $this->attendanceData[$p->nwp_student_id][$p->nwp_news_id] = $p->nwp_status ?? 'hadir';
        }
    }

    public function title(): string
    {
        return 'Laporan Kehadiran';
    }

    public function columnWidths(): array
    {
        $widths = [
            'A' => 5,
            'B' => 30,
            'C' => 15,
        ];

        // lebar kolom tanggal
        $col = 4;
        foreach ($this->dates as $date) {
            $widths[$this->colLetter($col)] = 12;
            $col++;
        }

        return $widths;
    }

    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
    {
        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet     = $event->sheet->getDelegate();
                $dateCount = $this->dates->count();
                $lastCol   = $this->colLetter(3 + $dateCount);
                $totalRows = $this->students->count() + 4;

                // === JUDUL ===
                $sheet->mergeCells("A1:{$lastCol}1");
                $sheet->setCellValue('A1', 'LAPORAN KEHADIRAN BIMBINGAN');
                $sheet->getStyle('A1')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 14, 'name' => 'Arial'],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $sheet->mergeCells("A2:{$lastCol}2");
                $bulan = Carbon::create($this->year, $this->month)->translatedFormat('F Y');
                $sheet->setCellValue('A2', 'Pembimbing: ' . $this->mentor->user->name . ' | Periode: ' . $bulan);
                $sheet->getStyle('A2')->applyFromArray([
                    'font'      => ['size' => 11, 'name' => 'Arial'],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $sheet->getRowDimension(3)->setRowHeight(5);

                // === HEADER TABEL ===
                $sheet->setCellValue('A4', 'No');
                $sheet->setCellValue('B4', 'Nama Siswa');
                $sheet->setCellValue('C4', 'NIS');

                $col = 4;
                foreach ($this->dates as $newsId => $date) {
                    $sheet->setCellValue($this->colLetter($col) . '4',
                        Carbon::parse($date)->translatedFormat('d M'));
                    $col++;
                }

                $sheet->getStyle("A4:{$lastCol}4")->applyFromArray([
                    'font' => ['bold' => true, 'name' => 'Arial', 'size' => 11],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '1E88E5'],
                    ],
                    'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Arial'],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'borders'   => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['rgb' => 'FFFFFF'],
                        ],
                    ],
                ]);
                $sheet->getRowDimension(4)->setRowHeight(25);

                // === DATA SISWA ===
                $row = 5;
                foreach ($this->students as $i => $student) {
                    $sheet->setCellValue("A{$row}", $i + 1);
                    $sheet->setCellValue("B{$row}", $student->user->name ?? '-');
                    $sheet->setCellValue("C{$row}", $student->std_nis ?? '-');

                    $col = 4;
                    foreach ($this->dates as $newsId => $date) {
                        $status = $this->attendanceData[$student->std_id][$newsId] ?? null;
                        $colLetter = $this->colLetter($col);
                        $cell = "{$colLetter}{$row}";

                        if ($status === null) {
                            // tidak hadir
                            $sheet->setCellValue($cell, 'A');
                            $sheet->getStyle($cell)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFCDD2']],
                                'font' => ['color' => ['rgb' => 'C62828'], 'bold' => true],
                            ]);
                        } elseif ($status === 'hadir') {
                            $sheet->setCellValue($cell, 'H');
                            $sheet->getStyle($cell)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'C8E6C9']],
                                'font' => ['color' => ['rgb' => '2E7D32'], 'bold' => true],
                            ]);
                        } elseif ($status === 'izin') {
                            $sheet->setCellValue($cell, 'I');
                            $sheet->getStyle($cell)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFF9C4']],
                                'font' => ['color' => ['rgb' => 'F57F17'], 'bold' => true],
                            ]);
                        } elseif ($status === 'sakit') {
                            $sheet->setCellValue($cell, 'S');
                            $sheet->getStyle($cell)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'BBDEFB']],
                                'font' => ['color' => ['rgb' => '1565C0'], 'bold' => true],
                            ]);
                        }

                        $sheet->getStyle($cell)->getAlignment()
                            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $col++;
                    }

                    // stripe baris
                    $bgRow = ($i % 2 === 0) ? 'FFFFFF' : 'F5F5F5';
                    $sheet->getStyle("A{$row}:C{$row}")->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgRow]],
                    ]);

                    $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color'       => ['rgb' => 'E0E0E0'],
                            ],
                        ],
                        'font'      => ['name' => 'Arial', 'size' => 10],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                    ]);

                    $sheet->getRowDimension($row)->setRowHeight(20);
                    $row++;
                }

                // === LEGENDA ===
                $sheet->setCellValue("A{$row}", '');
                $row++;
                $sheet->setCellValue("A{$row}", 'Keterangan:');
                $sheet->getStyle("A{$row}")->getFont()->setBold(true);
                $row++;

                $legends = [
                    ['H', 'C8E6C9', '2E7D32', 'Hadir'],
                    ['I', 'FFF9C4', 'F57F17', 'Izin'],
                    ['S', 'BBDEFB', '1565C0', 'Sakit'],
                    ['A', 'FFCDD2', 'C62828', 'Tidak Hadir'],
                ];

                foreach ($legends as $legend) {
                    $sheet->setCellValue("A{$row}", $legend[0]);
                    $sheet->getStyle("A{$row}")->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $legend[1]]],
                        'font' => ['color' => ['rgb' => $legend[2]], 'bold' => true, 'name' => 'Arial'],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);
                    $sheet->setCellValue("B{$row}", '= ' . $legend[3]);
                    $sheet->getStyle("B{$row}")->getFont()->setName('Arial');
                    $row++;
                }
            },
        ];
    }

    protected function colLetter(int $col): string
    {
        $letter = '';
        while ($col > 0) {
            $col--;
            $letter = chr(65 + ($col % 26)) . $letter;
            $col    = intdiv($col, 26);
        }
        return $letter;
    }
}