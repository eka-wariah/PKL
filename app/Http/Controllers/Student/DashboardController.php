<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Attendance;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = auth()->user()->student;
        $academicYear = AcademicYear::where('acy_status', 1)->first();
        $startDate = $academicYear->acy_year . '-08-03';
        $endDate = Carbon::now()->toDateString();
        $period = CarbonPeriod::create($startDate, $endDate);

        $attendances = Attendance::where('att_std_id',auth()->user()->student->std_id)
            ->whereBetween('att_date', [$startDate, $endDate])
            ->orderBy('att_date')
            ->get()
            ->keyBy('att_date');
            // dd($attendances);
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






        $hadir = \App\Models\Attendance::where('att_std_id', $student->std_id)
            ->where('att_status', 1)
            ->count();

        $izin = \App\Models\Attendance::where('att_std_id', $student->std_id)
            ->where('att_status', 2)
            ->count();

        $sakit = \App\Models\Attendance::where('att_std_id', $student->std_id)
            ->where('att_status', 3)
            ->count();

        $alpha = collect($report)->filter(fn($r) => !in_array($r['status'], [1, 2, 3]))->count();
        // dd($alpha);












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

    public function editPassword()
{
    return view('student.edit-password');
}

public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
    ], [
        'current_password.required' => 'Password saat ini wajib diisi.',
        'new_password.required' => 'Password baru wajib diisi.',
        'new_password.min' => 'Password baru minimal 8 karakter.',
        'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
    ]);

    $student = Auth::user();
    // dd($request->current_password);
    if (!Hash::check($request->current_password, $student->password)) {
        return back()->withErrors([
            'current_password' => 'Password saat ini salah.',
        ]);
    }

    $student->update([
        'password' => Hash::make($request->new_password),
    ]);

    return back()->with('success', 'Password berhasil diubah.');
}
   
}
