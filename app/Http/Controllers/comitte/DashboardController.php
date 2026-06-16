<?php

namespace App\Http\Controllers\comitte;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\MentorAssignments;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = MentorAssignments::with('student.attendanceToday', 'student.company')->get();
        $totalPerusahaan = $students
    ->pluck('student.std_company_id')
    ->filter()
    ->unique()
    ->count();
    $totalGuru = User::role('mentor')->count();

    // $guidances = News::where('news_mentor_id', Auth::user()->mentor->mtr_id)->where('news_parent_id', null)->get();
    // dd($students->first()->company);
    // dd($students);
    return view('comitte.dashboard', compact(['students', 'totalPerusahaan', 'totalGuru']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function studentAttendance($id)
    {

    $student= Student::findOrFail($id); 
        $academicYear = AcademicYear::where('acy_status', 1)->first();

        $startDate = $academicYear->acy_year . '-06-01';
        $endDate = Carbon::now()->toDateString();
        $period = CarbonPeriod::create($startDate, $endDate);

        $attendances = Attendance::where('att_std_id', $id)
            ->whereBetween('att_date', [$startDate, $endDate])
            ->orderBy('att_date')
            ->get()
            ->keyBy('att_date'); // key by att_date biar bisa di-lookup per tanggal

        $report = [];
        $no = 1;

        foreach ($period as $date) {
            $dateStr = $date->format('Y-m-d');
            $attendance = $attendances->get($dateStr); // sekarang bisa lookup by tanggal

            $report[] = [
                'no'     => $no++,
                'date'   => $date->format('d-m-Y'),
                'status' => $attendance?->att_status ?? 4,
                'time'   => $attendance?->att_time,
                'photo'  => $attendance?->att_photo
            ];
        }
        // dd($report);
        $report = array_reverse($report);


        return view('comitte.attendance.index', compact('report','student'));
    }

    public function create()
    {
        // 
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
