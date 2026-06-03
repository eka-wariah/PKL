<?php

namespace App\Http\Controllers\Mentor;

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

class ReportController extends Controller
{

public function index(){
    return view('mentor.report.index');
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
