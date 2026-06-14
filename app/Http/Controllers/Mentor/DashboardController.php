<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\MentorAssignments;
use Carbon\CarbonPeriod;
use App\Models\News;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $academicYear = AcademicYear::where('acy_status', 1)->first();
        $students = MentorAssignments::with('student.attendanceToday')
            ->where('mas_mentor_id', Auth::user()->mentor->mtr_id)
            ->get();
        $guidances = News::where('news_mentor_id', Auth::user()->mentor->mtr_id)->where('news_parent_id', null)->get();
        $studentIds = MentorAssignments::where('mas_mentor_id', Auth::user()->mentor->mtr_id)
            ->where('mas_academic_id', $academicYear?->acy_id)
            ->pluck('mas_student_id');
        $attendances = Attendance::whereIn('att_std_id', $studentIds)
            ->whereDate('att_date', today())
            ->whereNull('deleted_at')
            ->pluck('att_std_id');

        $absents = Student::with('user')
            ->whereIn('std_id', $studentIds)
            ->whereNotIn('std_id', $attendances)
            ->get();
        // dd($students);
        return view('mentor.dashboard', compact(['students', 'guidances', 'attendances','absents']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function studentAttendance($id)
    {

        $student = Student::findOrFail($id);
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
                'att_id' => $attendance?->att_id,
                'no'     => $no++,
                'date'   => $date->format('d-m-Y'),
                'status' => $attendance?->att_status ?? 4,
                'time'   => $attendance?->att_time,
                'photo'  => $attendance?->att_photo,
                'latitude'  => $attendance?->att_latitude,
                'longitude' => $attendance?->att_longitude,
                'address'   => $attendance?->att_address,
            ];
        }
        // dd($report);
        // dd($report);

        return view('mentor.attendance.index', compact('report', 'student'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function downloadImage($id)
    {
        $attendance = Attendance::findOrFail($id);

        return Storage::disk('public')->download(
            $attendance->att_photo,
            basename($attendance->news_photo)
        );
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
