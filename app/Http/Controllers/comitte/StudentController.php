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

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = User::role('student') ->with('student')->get();
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
