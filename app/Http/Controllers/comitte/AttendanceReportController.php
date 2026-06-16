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

        if ($request->filled(['month', 'year'])) {

            $students = Student::with('user')

                ->get()
                ->map(function ($student) use ($request) {

                    $attendances = Attendance::where('att_std_id', $student->std_id)
                    ->whereMonth('att_date', $request->month)
                    ->whereYear('att_date', $request->year)
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
        $month = $request->month;
        $year  = $request->year;
    
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate   = Carbon::create($year, $month, 1)->endOfMonth();
    
        $students = MentorAssignments::with([
            'student.user',
            'student.attendances' => function ($q) use ($month, $year) {
                $q->whereMonth('att_date', $month)
                  ->whereYear('att_date', $year);
            }
        ])->get();
    
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
    //  dd($request);

        //  $mentor   = Mentor::where('mtr_usr_id', Auth::user()->usr_id)->firstOrFail();
        $month    = $request->month;
        $year     = $request->year;
        $filename = 'laporan-kehadiran-' . Carbon::create($year, $month)->format('Y-m') . '.xlsx';
        // dd($mentor);
        return Excel::download(
            new AttendanceReportExport($month, $year),
            $filename
        );
    }
}
