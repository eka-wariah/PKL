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
        $canPresence = now()->format('H:i') >= '06:00'
            && now()->format('H:i') < '14:00';
        return view('student.presence.index', [
            'student'      => $student,
            'already'      => (bool) $presenceData,
            'presenceData' => $presenceData,
            'canPresence' => $canPresence,
        ]);
    }
    public function store(Request $request)
    {
        $student = Auth::user()->student;
        $today   = Carbon::today();

        $currentTime = now()->format('H:i');

        if ($currentTime < '06:00' || $currentTime >= '14:00') {
            return response()->json([
                'success' => false,
                'message' => 'Presensi hanya dapat dilakukan pukul 06:00 - 12:00.'
            ]);
        }

        // Cek sudah presensi hari ini
        if (Attendance::where('att_std_id', $student->std_id)
            ->whereDate('att_date', $today)
            ->exists()
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu sudah melakukan presensi hari ini.',
            ]);
        }
        $status = (int) $request->att_status;

        $request->validate([
            'foto'      => 'required|string',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // // Simpan foto
        $fotoPath = null;
        if ($request->foto) {
            $base64   = preg_replace('/^data:image\/\w+;base64,/', '', $request->foto);
            $decoded  = base64_decode($base64);
            $filename = 'presensi/' . $student->std_id . '_' . $today->format('Ymd') . '_' . time() . '.jpg';
            Storage::disk('public')->put($filename, $decoded);
            $fotoPath = $filename;
        }
        
        Attendance::create([
            'att_std_id'   => $student->std_id,
            'att_date'     => $today,
            'att_time'     => Carbon::now()->format('H:i:s'),
            'att_status'   => 1,
            'att_type'     => 'masuk',
            'att_photo'    => $fotoPath,
            'att_latitude'  => $request->latitude,
            'att_longitude' => $request->longitude,
            'att_address'   => $request->alamat,
            // 'att_created_by' => Auth::id(),
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Presensi berhasil dicatat.',
        ]);
    }
    public function storePermission(Request $request)
{
    $student = Auth::user()->student;

    $today = Carbon::today();
    $currentTime = now()->format('H:i');

if ($currentTime < '06:00' || $currentTime >= '12:00') {
    return response()->json([
        'success' => false,
        'message' => 'Presensi hanya dapat dilakukan pukul 06:00 - 12:00.'
    ]);
}

    if (
        Attendance::where('att_std_id', $student->std_id)
            ->whereDate('att_date', $today)
            ->exists()
    ) {
        return response()->json([
            'success' => false,
            'message' => 'Kamu sudah melakukan presensi hari ini.'
        ]);
    }

    $request->validate([
        'description' => 'required'
    ]);

    Attendance::create([
        'att_std_id'      => $student->std_id,
        'att_date'        => $today,
        'att_status'      => 2,
        'att_description' => $request->description,
        'att_type'        => 'masuk',
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Izin berhasil dikirim.'
    ]);
}
public function storeSick(Request $request)
{
    $student = Auth::user()->student;

    $today = Carbon::today();
    $currentTime = now()->format('H:i');

    if ($currentTime < '06:00' || $currentTime >= '12:00') {
        return response()->json([
            'success' => false,
            'message' => 'Presensi hanya dapat dilakukan pukul 06:00 - 12:00.'
        ]);
    }

    if (
        Attendance::where('att_std_id', $student->std_id)
            ->whereDate('att_date', $today)
            ->exists()
    ) {
        return response()->json([
            'success' => false,
            'message' => 'Kamu sudah melakukan presensi hari ini.'
        ]);
    }

    $request->validate([
        'description' => 'required'
    ]);

    Attendance::create([
        'att_std_id'      => $student->std_id,
        'att_date'        => $today,
        'att_status'      => 3,
        'att_description' => $request->description,
        'att_type'        => 'masuk',
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Laporan sakit berhasil dikirim.'
    ]);
}
}
