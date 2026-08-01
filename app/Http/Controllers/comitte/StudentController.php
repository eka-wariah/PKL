<?php

namespace App\Http\Controllers\comitte;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Company;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentTemplateExport;
use App\Imports\StudentImport;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $title = 'Hapus Siswa!';
        $text = "Apakah Anda yakin ingin menghapus?";
        confirmDelete($title, $text);
        $student = User::role('student')->with('student')->get();
        return view('comitte.student.index', compact('student'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::all();
        $class = Classes::all();
        $company = Company::all();
        return view('comitte.student.create', compact('user', 'class', 'company'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',

            // 'mtr_gtk'               => 'required|string|unique:mentors,mtr_gtk',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
            ]);
            $user->assignRole('student');

            Student::create([
                'std_usr_id'        => $user->usr_id,
                'std_nis'           => $request->std_nis,
                'std_nisn'           => $request->std_nisn,
                'std_classes_id'     => $request->std_classes_id,
                'std_company_id'     => $request->std_company_id,
                'std_nickname'           => $request->std_nickname,
                // 'mtr_created_by'    => auth()->id(),
            ]);
        });
        Alert::success('Berhasil Menambah', 'Data guru berhasil ditambahkan');


        return redirect()->route('comitte.student.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = User::with(['student.classes', 'student.company'])
            ->where('usr_id', $id)
            ->firstOrFail();

        return view('comitte.student.detail', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = User::with([
            'student.classes',
            'student.company'
        ])->where('usr_id', $id)
          ->firstOrFail();
    
        $class = Classes::with('cls_major')->get();
        $company = Company::all();
    
        return view('comitte.student.edit', compact('student', 'class', 'company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

    // $request->validate([
    //     'name' => 'required',
    //     'std_nis' => 'required',
    //     'std_nisn' => 'required',
    // ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    $user->student->update([
        'std_nis'        => $request->std_nis,
        'std_nisn'       => $request->std_nisn,
        'std_classes_id' => $request->std_classes_id,
        'std_company_id' => $request->std_company_id,
    ]);
    Alert::success('Berhasil Update', 'Data siswa berhasil diperbarui');
        return redirect('/comitte/student');
    // return redirect()
    //     ->route('comitte.student.index')
    //     ->with('success', 'Data siswa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        // dd($id);
        $student = User::findOrFail($id);
        // dd($student);
        $student->delete();
        Alert::success('Berhasil Menghapus', 'Data siswa berhasil diHapus');
        return redirect('/comitte/student');

    }
    public function importPage()
    {
        return view('comitte.student.import');
    }

    public function downloadTemplate()
    {
        return Excel::download(
            new StudentTemplateExport,
            'template-student.xlsx'
        );
    }
    // public function downloadTemplate()
    // {
    //     return Excel::download(new StudentTemplateExport, 'template-siswa.xlsx');
    // }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);
        // dd(class_exists(\ZipArchive::class));
        Excel::import(new StudentImport, $request->file('file'));
        Alert::success('Berhasil Import', 'Data Guru Berhasil Diimport');
        return redirect()->route('comitte.student.index')
            ->with('success', 'Data siswa berhasil diimport.');
    }


    public function editPassword($id)
    {
        $student = User::findOrFail($id);
        // dd($mentor);
        return view('comitte.student.edit-password', compact(['student']));
    }
     public function updatePassword($id, Request $request)
    {
        $mentor = User::findOrFail($id);

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $mentor->update([
            'password' => bcrypt($request->password),
        ]);

        Alert::success('Berhasil Megubah', 'Password berhasil diperbarui');

        return redirect()->route('comitte.student.index')
            ->with('success', 'Password Siswa berhasil diubah.');
    }

    public function updatePassword1(Request $request, $id)
{
    $request->validate([
        'password' => 'required|min:8|confirmed',
    ]);

    $student = User::findOrFail($id);

    $student->update([
        'password' => Hash::make($request->password)
    ]);

    return back()->with('success', 'Password siswa berhasil diubah');
}
}
