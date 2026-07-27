<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CheckOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = Auth::user()->student;

        $today = Carbon::today();

        $presenceData = Attendance::where('att_std_id', $student->std_id)
            ->whereDate('att_date', $today)
            ->first();
            $hasCheckin = !is_null($presenceData);

            $hasCheckout = !is_null($presenceData?->att_checkout_time);
            
            $canCheckout = $hasCheckin && !$hasCheckout;
        return view('student.checkout.index', [
            'student'      => $student,
            'already'      => (bool) $presenceData,
            'presenceData' => $presenceData,
            'hasCheckin'   => $hasCheckin,
            'hasCheckout'  => $hasCheckout,
            'canCheckout' => $canCheckout,
        ]);
    }

    // public function storePermission(Request $request)
    // {
    //     $student = Auth::user()->student;

    //     $today = Carbon::today();
    //     $currentTime = now()->format('H:i');

    // if ($currentTime < '06:00' || $currentTime >= '12:00') {
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Presensi hanya dapat dilakukan pukul 06:00 - 12:00.'
    //     ]);
    // }

    //     if (
    //         Attendance::where('att_std_id', $student->std_id)
    //             ->whereDate('att_date', $today)
    //             ->exists()
    //     ) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Kamu sudah melakukan presensi hari ini.'
    //         ]);
    //     }

    //     $request->validate([
    //         'description' => 'required'
    //     ]);

    //     Attendance::create([
    //         'att_std_id'      => $student->std_id,
    //         'att_date'        => $today,
    //         'att_status'      => 2,
    //         'att_description' => $request->description,
    //         'att_type'        => 'masuk',
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Izin berhasil dikirim.'
    //     ]);
    // }

    // public function storeSick(Request $request)
    // {
    //     $student = Auth::user()->student;

    //     $today = Carbon::today();
    //     $currentTime = now()->format('H:i');

    //     if ($currentTime < '06:00' || $currentTime >= '12:00') {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Presensi hanya dapat dilakukan pukul 06:00 - 12:00.'
    //         ]);
    //     }

    //     if (
    //         Attendance::where('att_std_id', $student->std_id)
    //             ->whereDate('att_date', $today)
    //             ->exists()
    //     ) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Kamu sudah melakukan presensi hari ini.'
    //         ]);
    //     }

    //     $request->validate([
    //         'description' => 'required'
    //     ]);

    //     Attendance::create([
    //         'att_std_id'      => $student->std_id,
    //         'att_date'        => $today,
    //         'att_status'      => 3,
    //         'att_description' => $request->description,
    //         'att_type'        => 'masuk',
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Laporan sakit berhasil dikirim.'
    //     ]);
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $student = Auth::user()->student;
    $today   = Carbon::today();

    // Cari presensi hari ini
    $attendance = Attendance::where('att_std_id', $student->std_id)
        ->whereDate('att_date', $today)
        ->first();

    // Belum presensi masuk
    if (!$attendance) {
        return response()->json([
            'success' => false,
            'message' => 'Kamu belum melakukan presensi masuk hari ini.'
        ]);
    }

    // Hanya siswa yang hadir yang boleh checkout
    if ($attendance->att_status != 1) {
        return response()->json([
            'success' => false,
            'message' => 'Checkout hanya dapat dilakukan oleh siswa yang hadir.'
        ]);
    }

    // Sudah checkout
    if ($attendance->att_checkout_time) {
        return response()->json([
            'success' => false,
            'message' => 'Kamu sudah melakukan presensi pulang hari ini.'
        ]);
    }

    $request->validate([
        'foto'      => 'required|string',
        'latitude'  => 'required|numeric',
        'longitude' => 'required|numeric',
    ]);

    // Simpan foto checkout
    $fotoPath = null;

    if ($request->foto) {

        $base64 = preg_replace('/^data:image\/\w+;base64,/', '', $request->foto);
        $decoded = base64_decode($base64);

        $filename = 'presensi/pulang/' .
            $student->std_id . '_' .
            now()->format('YmdHis') . '.jpg';

        Storage::disk('public')->put($filename, $decoded);

        $fotoPath = $filename;
    }

    // Update data checkout
    $attendance->update([
        'att_checkout_time'      => now()->format('H:i:s'),
        'att_checkout_photo'     => $fotoPath,
        'att_checkout_latitude'  => $request->latitude,
        'att_checkout_longitude' => $request->longitude,
        'att_checkout_address'   => $request->alamat,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Presensi pulang berhasil dicatat.'
    ]);

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
