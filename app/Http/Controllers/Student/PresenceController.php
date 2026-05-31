<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PresenceController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        $today = Carbon::today();

        $presenceData = Attendance::where('att_std_id', $student->std_id)
            ->whereDate('att_date', $today)
            ->first();
        return view('student.presence.index', [
            'student'      => $student,
            'already'      => (bool) $presenceData,
            'presenceData' => $presenceData,
        ]);
    }
}
