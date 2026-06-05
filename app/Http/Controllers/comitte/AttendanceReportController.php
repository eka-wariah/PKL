<?php

namespace App\Http\Controllers\comitte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\MentorAssignments;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonPeriod;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\AttendanceReportExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Mentor;
use Carbon\Carbon;








class AttendanceReportController extends Controller
{
    public function index(Request $request)
    {
        $students = null;

        if ($request->filled(['start_date', 'end_date'])) {

            $students = Student::with('user')

                ->get()
                ->map(function ($student) use ($request) {

                    $attendances = Attendance::where('att_std_id', $student->std_id)
                        ->whereBetween('att_date', [
                            $request->start_date,
                            $request->end_date
                        ])
                        ->get();

                    $student->hadir = $attendances->where('att_status', 1)->count();
                    $student->izin  = $attendances->where('att_status', 2)->count();
                    $student->sakit = $attendances->where('att_status', 3)->count();
                    $student->alpha = $attendances->where('att_status', 4)->count();

                    return $student;
                });
        }
        return view('comitte.report.index', compact(['students']));
    }

    public function pdf(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $students = MentorAssignments::with([
            'student.user',
            'student.attendances' => function ($q) use ($startDate, $endDate) {
                $q->whereBetween('att_date', [$startDate, $endDate]);
            }
        ])

            ->get();

        $dates = CarbonPeriod::create($startDate, $endDate);
        $pdf = Pdf::loadView(
            'comitte.report.pdf',
            compact('students', 'dates', 'startDate', 'endDate')
        );

        return $pdf->stream('laporan-kehadiran.pdf');
    }




    public function downloadAttendance(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|between:1,12',
            'year'  => 'required|integer|min:2020',
        ]);
        // dd($request);

        $mentor   = Mentor::where('mtr_usr_id', Auth::user()->usr_id)->firstOrFail();
        $month    = $request->month;
        $year     = $request->year;
        $filename = 'laporan-kehadiran-' . Carbon::create($year, $month)->format('Y-m') . '.xlsx';

        return Excel::download(new AttendanceReportExport($mentor, $month, $year), $filename);
    }
}
