<?php

namespace App\Http\Controllers\comitte;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\Company;
use App\Models\MentorAssignments;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $academicYear = AcademicYear::where('acy_status', 1)->first();
        $students = MentorAssignments::with('student.attendanceToday', 'student.company') ->where('mas_academic_id', $academicYear?->acy_id)->get() ->unique('mas_student_id');
        // dd();
        $totalPerusahaan = Company::count();
    // dd($totalPerusahaan);
    $totalGuru = User::role('mentor')->count();
    // $academicYear = AcademicYear::where('acy_status', 1)->first();

    $studentIds = MentorAssignments::where('mas_academic_id', $academicYear?->acy_id)
            ->pluck('mas_student_id')
            ->unique('mas_student_id');
            // dd($studentIds);

    $attendances = Attendance::whereIn('att_std_id', $studentIds)
            ->whereDate('att_date', today())
            ->whereNull('deleted_at')
            ->pluck('att_std_id');

        $absents = Student::with('user')
            ->whereIn('std_id', $studentIds)
            ->whereNotIn('std_id', $attendances)
            ->get();

    // $guidances = News::where('news_mentor_id', Auth::user()->mentor->mtr_id)->where('news_parent_id', null)->get();
    // dd($students->first()->company);
    // dd($students);
    return view('comitte.dashboard', compact(['students', 'totalPerusahaan', 'totalGuru','attendances','absents']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function studentAttendance($id)
    {
            $student = Student::findOrFail($id);
            $academicYear = AcademicYear::where('acy_status', 1)->first();
    
            $startDate = $academicYear->acy_year . '-08-03';
            $endDate = Carbon::now()->toDateString();
            $period = CarbonPeriod::create($startDate, $endDate);
            // dd($period);
    
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
                    'att_id' => $attendance?->att_id,
                    'no'     => $no++,
                    'date'   => $date->format('d-m-Y'),
                    'status' => $attendance?->att_status ?? 4,
                    'time'   => $attendance?->att_time,
                    'photo'  => $attendance?->att_photo,
                    'checkout_time'   => $attendance?->att_checkout_time,
                    'checkout_photo'  => $attendance?->att_checkout_photo,
                    'latitude'  => $attendance?->att_latitude,
                    'longitude' => $attendance?->att_longitude,
                    'address'   => $attendance?->att_address,
                    'checkout_latitude'  => $attendance?->att_checkout_latitude,
                    'checkout_longitude' => $attendance?->att_checkout_longitude,
                    'checkout_address'   => $attendance?->att_checkout_address
                ];
            }
            // dd($report);
            // dd($report);
            $report = array_reverse($report);
        return view('comitte.attendance.index', compact('report','student'));
    }

    public function downloadImage($id)
{
    // dd($id);
    $attendance = Attendance::findOrFail($id);

    if (!Storage::disk('public')->exists($attendance->att_photo)) {
        abort(404, 'Foto tidak ditemukan.');
    }

    return Storage::disk('public')->download(
        $attendance->att_photo,
        basename($attendance->att_photo)
    );
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
