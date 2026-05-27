<?php

namespace App\Imports;

use App\Models\Classes;
use App\Models\Company;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
    
            // mapping dropdown text -> id
            $classes = Classes::pluck('cls_id', 'cls_code');
            $companies = Company::pluck('cmp_id', 'cmp_name');
    
            foreach ($rows as $row) {
    
                // wajib ada
                if (empty($row['nama']) || empty($row['email'])) {
                    continue;
                }
    
                // skip email duplicate
                if (User::where('email', $row['email'])->exists()) {
                    continue;
                }
    
                // skip nis duplicate
                if (!empty($row['nis']) &&
                    Student::where('std_nis', $row['nis'])->exists()) {
                    continue;
                }
    
                // ambil id kelas & perusahaan
                $classId = $classes[$row['kelas']] ?? null;
                $companyId = $companies[$row['perusahaan']] ?? null;
    
                // skip kalau mapping gagal
                if (!$classId) {
                    continue;
                }
    
                $user = User::create([
                    'name'     => $row['nama'],
                    'email'    => $row['email'],
                    'password' => bcrypt(
                        $row['password'] ?? 'password123'
                    ),
                ]);
    
                $user->assignRole('student');
    
                Student::create([
                    'std_usr_id'        => $user->usr_id,
                    'std_nis'           => (string) $row['nis'] ?? null,
                    'std_nisn'          => (string) $row['nisn'] ?? null,
    
                    // 🔥 FK INTEGER
                    'std_classes_id'    => $classId,
                    'std_company_id'    => $companyId,
    
                    'std_nickname'      => $row['nickname'] ?? null,
                ]);
            }
        });
    }
}