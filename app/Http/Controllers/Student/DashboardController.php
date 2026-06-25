<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = auth()->user()->student;

        $hadir = \App\Models\Attendance::where('att_std_id', $student->std_id)
            ->where('att_status', 1)
            ->count();

        $izin = \App\Models\Attendance::where('att_std_id', $student->std_id)
            ->where('att_status', 2)
            ->count();

        $sakit = \App\Models\Attendance::where('att_std_id', $student->std_id)
            ->where('att_status', 3)
            ->count();

        $alpha = \App\Models\Attendance::where('att_std_id', $student->std_id)
            ->where('att_status', 4)
            ->count();

        $total = $hadir + $izin + $sakit + $alpha;

        $persentase = $total > 0
            ? round(($hadir / $total) * 100)
            : 100;

        if ($alpha == 0) {
            $emoji = '😎';
            $title = 'Kehadiran Sempurna';
            $message = 'Tidak ada alfa. Pertahankan semangatmu!';
            $bg = 'success';
        } elseif ($alpha <= 5) {
            $emoji = '🙂';
            $title = 'Bagus';
            $message = 'Kehadiranmu masih sangat baik.';
            $bg = 'primary';
        } elseif ($alpha <= 10) {
            $emoji = '😐';
            $title = 'Waspada';
            $message = 'Jangan lupa melakukan presensi setiap hari.';
            $bg = 'warning';
        } else {
            $emoji = '😡';
            $title = 'Perlu Perhatian';
            $message = 'Jumlah alfa cukup tinggi, yuk lebih disiplin.';
            $bg = 'danger';
        }

        $quotes = [
            '🌟 Kehadiran adalah langkah kecil menuju kesuksesan besar.',
            '🚀 Datang tepat waktu adalah kebiasaan profesional.',
            '💪 Disiplin hari ini adalah investasi masa depan.',
            '🔥 Jangan biarkan alfa menghambat pencapaianmu.'
        ];

        $quote = $quotes[array_rand($quotes)];


        $today = Carbon::today();

$todayAttendance = Attendance::where('att_std_id', $student->std_id)
    ->whereDate('att_date', $today)
    ->first();

$hour = now()->hour;

if ($hour < 12) {

    $clockEmoji = '⏰🥰';
    $clockTitle = 'Ayo Presensi!';
    $clockMessage = 'Jangan lupa melakukan presensi sebelum waktu ditutup.';
    $clockColor = 'warning';

} else {

    if ($todayAttendance) {

        if ($todayAttendance->att_status == 4) {

            $clockEmoji = '⏰😠';
            $clockTitle = 'Kenapa Tidak Absen?';
            $clockMessage = 'Hari ini tercatat Alfa. Yuk lebih disiplin besok.';
            $clockColor = 'danger';

        } else {

            $clockEmoji = '⏰🤗';
            $clockTitle = 'Terima Kasih!';
            $clockMessage = 'Terima kasih sudah melakukan presensi hari ini.';
            $clockColor = 'success';
        }

    } else {

        $clockEmoji = '⏰😡';
        $clockTitle = 'Belum Presensi!';
        $clockMessage = 'Hari ini belum ada data presensi.';
        $clockColor = 'danger';
    }
}

        return view('student.dashboard', compact(
            'hadir',
            'izin',
            'sakit',
            'alpha',
            'persentase',
            'emoji',
            'title',
            'message',
            'bg',
            'quote',
            'clockEmoji',
'clockTitle',
'clockMessage',
'clockColor',
'todayAttendance'
        ));

}

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
