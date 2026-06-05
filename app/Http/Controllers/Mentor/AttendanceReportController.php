<?php

namespace App\Http\Controllers\mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Mentor;
use App\Models\MentorAssignments;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonPeriod;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceReportExportt;



class AttendanceReportController extends Controller
{
    public function index(){
        return view('mentor.report.index');
    }
    public function download(Request $request)
{
    $request->validate([
        'month' => 'required|integer|between:1,12',
        'year'  => 'required|integer|min:2020',
    ]);
    // dd(Auth::user()->usr_id);
    $mentor   = Mentor::where('mtr_usr_id', Auth::user()->usr_id)->firstOrFail();
    $bulan    = Carbon::create($request->year, $request->month)->translatedFormat('F-Y');
    $filename = 'laporan-kehadiran-' . $bulan . '.xlsx';

    return Excel::download(
        new AttendanceReportExportt($mentor, $request->month, $request->year),
        $filename
    );
}
}
