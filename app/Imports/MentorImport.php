<?php

namespace App\Imports;

use App\Models\Mentor;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MentorImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                if (empty($row['nama']) || empty($row['email'])) {
                    continue;
                }

                // skip kalau email sudah ada
                if (User::where('email', $row['email'])->exists()) {
                    continue;
                }

                // skip kalau no_gtk sudah ada
                if (Mentor::where('mtr_gtk', (string) $row['no_gtk'])->exists()) {
                    continue;
                }

                $user = User::create([
                    'name'     => $row['nama'],
                    'email'    => $row['email'],
                    'password' => bcrypt($row['password'] ?? 'password'),
                ]);

                $user->assignRole('mentor');

                Mentor::create([
                    'mtr_usr_id'     => $user->usr_id,
                    'mtr_gtk'        => (string) $row['no_gtk'],
                    // 'mtr_created_by' => auth()->id(),
                ]);
            }
        });
    }
}
