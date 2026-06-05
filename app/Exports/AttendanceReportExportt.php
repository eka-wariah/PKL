<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\MentorAssignments;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class AttendanceReportExportt implements WithStyles, WithColumnWidths, WithTitle, WithEvents
{
    protected $mentor;
    protected $month;
    protected $year;
    protected $students;
    protected $dates;
    protected $attendanceData;

    // status map
    const STATUS = [
        1 => ['label' => 'H', 'bg' => 'C8E6C9', 'font' => '2E7D32', 'text' => 'Hadir'],
        2 => ['label' => 'I', 'bg' => 'FFF9C4', 'font' => 'F57F17', 'text' => 'Izin'],
        3 => ['label' => 'S', 'bg' => 'BBDEFB', 'font' => '1565C0', 'text' => 'Sakit'],
        4 => ['label' => 'A', 'bg' => 'FFCDD2', 'font' => 'C62828', 'text' => 'Tidak Hadir'],
    ];

    public function __construct($mentor, $month, $year)
    {
        $this->mentor = $mentor;
        $this->month  = $month;
        $this->year   = $year;
        $this->prepare();
    }

    protected function prepare()
    {
        // ambil semua siswa bimbingan mentor
        $this->students = MentorAssignments::with('student.user')
            ->where('mas_mentor_id', $this->mentor->mtr_id)
            ->get()
            ->pluck('student')
            ->filter();

        // generate semua tanggal dalam bulan (senin - jumat aja / semua hari)
        $startDate = Carbon::create($this->year, $this->month, 1);
        $endDate   = $startDate->copy()->endOfMonth();
        $this->dates = collect();

        while ($startDate->lte($endDate)) {
            // skip sabtu & minggu
            if (!$startDate->isWeekend()) {
                $this->dates->push($startDate->toDateString());
            }
            $startDate->addDay();
        }

        // ambil data kehadiran semua siswa dalam bulan tsb
        $studentIds = $this->students->pluck('std_id');
        $attendances = Attendance::whereIn('att_std_id', $studentIds)
            ->whereMonth('att_date', $this->month)
            ->whereYear('att_date', $this->year)
            ->whereNull('deleted_at')
            ->get();

        // susun: [std_id][date] = status
        foreach ($attendances as $att) {
            $this->attendanceData[$att->att_std_id][$att->att_date] = $att->att_status;
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

        $col = 4;
        foreach ($this->dates as $date) {
            $widths[$this->colLetter($col)] = 6;
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

                // === JUDUL ===
                $sheet->mergeCells("A1:{$lastCol}1");
                $sheet->setCellValue('A1', 'LAPORAN KEHADIRAN HARIAN PKL');
                $sheet->getStyle('A1')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 14, 'name' => 'Arial', 'color' => ['rgb' => '1A237E']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $sheet->mergeCells("A2:{$lastCol}2");
                $bulan = Carbon::create($this->year, $this->month)->translatedFormat('F Y');
                $sheet->setCellValue('A2', 'Pembimbing: ' . $this->mentor->user->name . '  |  Periode: ' . $bulan);
                $sheet->getStyle('A2')->applyFromArray([
                    'font'      => ['size' => 10, 'name' => 'Arial', 'color' => ['rgb' => '555555']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $sheet->getRowDimension(3)->setRowHeight(5);

                // === HEADER TABEL ===
                $sheet->setCellValue('A4', 'No');
                $sheet->setCellValue('B4', 'Nama Siswa');
                $sheet->setCellValue('C4', 'NIS');

                $col = 4;
                foreach ($this->dates as $date) {
                    $sheet->setCellValue(
                        $this->colLetter($col) . '4',
                        Carbon::parse($date)->format('d')
                    );
                    // tooltip nama hari di baris 5
                    $sheet->setCellValue(
                        $this->colLetter($col) . '5',
                        Carbon::parse($date)->translatedFormat('D')
                    );
                    $col++;
                }

                // style header baris 4
                $sheet->getStyle("A4:{$lastCol}4")->applyFromArray([
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1565C0']],
                    'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Arial', 'size' => 10],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'FFFFFF']]],
                ]);

                // style header baris 5 (nama hari)
                $sheet->getStyle("D5:{$lastCol}5")->applyFromArray([
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '90CAF9']],
                    'font'      => ['bold' => true, 'color' => ['rgb' => '0D47A1'], 'name' => 'Arial', 'size' => 9],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getStyle('A5:C5')->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1565C0']],
                    'font' => ['color' => ['rgb' => 'FFFFFF']],
                ]);

                $sheet->getRowDimension(4)->setRowHeight(22);
                $sheet->getRowDimension(5)->setRowHeight(18);

                // === DATA SISWA ===
                $row = 6;
                foreach ($this->students as $i => $student) {
                    $sheet->setCellValue("A{$row}", $i + 1);
                    $sheet->setCellValue("B{$row}", $student->user->name ?? '-');
                    $sheet->setCellValue("C{$row}", $student->std_nis ?? '-');

                    $col = 4;
                    foreach ($this->dates as $date) {
                        $colLetter = $this->colLetter($col);
                        $cell      = "{$colLetter}{$row}";
                        $status    = $this->attendanceData[$student->std_id][$date] ?? null;

                        if ($status !== null && isset(self::STATUS[$status])) {
                            $s = self::STATUS[$status];
                            $sheet->setCellValue($cell, $s['label']);
                            $sheet->getStyle($cell)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $s['bg']]],
                                'font' => ['color' => ['rgb' => $s['font']], 'bold' => true, 'size' => 9],
                            ]);
                        } else {
                            // belum ada data
                            $sheet->setCellValue($cell, '-');
                            $sheet->getStyle($cell)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']],
                                'font' => ['color' => ['rgb' => 'BDBDBD'], 'size' => 9],
                            ]);
                        }

                        $sheet->getStyle($cell)->getAlignment()
                            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                            ->setVertical(Alignment::VERTICAL_CENTER);

                        $col++;
                    }

                    // border & stripe
                    $bgRow = ($i % 2 === 0) ? 'FFFFFF' : 'F8F9FA';
                    $sheet->getStyle("A{$row}:C{$row}")->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgRow]],
                        'font' => ['name' => 'Arial', 'size' => 10],
                    ]);
                    $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
                        'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E0E0E0']]],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                    ]);
                    $sheet->getRowDimension($row)->setRowHeight(18);
                    $row++;
                }

                // === LEGENDA ===
                $row += 1;
                $sheet->setCellValue("A{$row}", 'Keterangan:');
                $sheet->getStyle("A{$row}")->getFont()->setBold(true)->setName('Arial');
                $row++;

                foreach (self::STATUS as $s) {
                    $sheet->setCellValue("A{$row}", $s['label']);
                    $sheet->getStyle("A{$row}")->applyFromArray([
                        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $s['bg']]],
                        'font'      => ['color' => ['rgb' => $s['font']], 'bold' => true, 'name' => 'Arial'],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                        'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E0E0E0']]],
                    ]);
                    $sheet->setCellValue("B{$row}", '= ' . $s['text']);
                    $sheet->getStyle("B{$row}")->getFont()->setName('Arial')->setSize(10);
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