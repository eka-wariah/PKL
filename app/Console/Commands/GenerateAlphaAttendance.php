<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:generate-alpha-attendance')]
#[Description('Command description')]
class GenerateAlphaAttendance extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
{
    $today = now()->toDateString();

    $students = Student::all();

    foreach ($students as $student) {

        $exists = Attendance::where('att_std_id', $student->std_id)
            ->whereDate('att_date', $today)
            ->exists();

        if (!$exists) {

            Attendance::create([
                'att_std_id' => $student->std_id,
                'att_date' => $today,
                'att_status' => 4, // Alfa
                'att_type' => 'masuk',
            ]);
        }
    }

    return self::SUCCESS;
}
}
