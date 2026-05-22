<?php

namespace App\Http\Controllers\comitte;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Classes;
use App\Models\Major;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $class = Classes::with(['cls_major', 'cls_academic'])->get();
        $title = 'Hapus Kelas!';
        $text = "Apakah Anda yakin ingin menghapus?";
        confirmDelete($title, $text);
        return view('comitte.class.index', compact(['class']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $homeroom = User::role('teacher')->get();
        $academic_year = AcademicYear::all();
        $majors = Major::all();
        return view('comitte.class.create', compact('academic_year', 'majors' ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $major = Major::find($request->cls_major_id);
        $academic_year = AcademicYear::find($request->cls_acy_id);

        $prefix = $major->mjr_abbr . '-' . $academic_year->acy_year . '-';

        $lastClass = Classes::where('cls_code', 'like', $prefix . '%')
        ->orderBy('cls_code', 'desc')
        ->first();

    if ($lastClass) {
        $lastNumber = (int) substr($lastClass->cls_code, -2);
        $newNumber  = $lastNumber + 1;
    } else {
        $newNumber = 1;
    }

    $numberFormatted = str_pad($newNumber, 2, '0', STR_PAD_LEFT);

    $classCode = $prefix . $numberFormatted;

        $CreateClass = Classes::create([
            'cls_code' => $classCode,
            'cls_level' => $request->cls_level,
            'cls_major_id' => $request->cls_major_id,
            'cls_number' => $request->cls_number,
            // 'cls_homeroom_id' => $request->cls_homeroom_id,
            'cls_acy_id' => $request->cls_acy_id,
        ]); 
        Alert::success('Berhasil Menambah', 'Berhasil menambah data tahun ajaran');
        return redirect('/comitte/classes');
    }

    public function students(string $id)
    {
        $class = Classes::with('students')->where('cls_id',$id)->first();
        // dd($class);
        return view('comitte.class.students',compact('class'));
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
        $edit_class = Classes::findOrFail($id);
        // $homeroom = User::role('teacher')->get();
        $academic_year = AcademicYear::all();
        $majors = Major::all();
        return view('comitte.class.edit', compact(['edit_class', 'academic_year', 'majors']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $class = Classes::findOrFail($id);

    // Ambil relasi baru dari request
    $major = Major::find($request->cls_major_id);
    $academic_year = AcademicYear::find($request->cls_acy_id);

    // Prefix baru
    $prefix = $major->mjr_abbr . '-' . $academic_year->acy_year . '-';

    /*
    Cek apakah major / tahun berubah
    */
    if (
        $class->cls_major_id != $request->cls_major_id ||
        $class->cls_acy_id != $request->cls_acy_id
    ) {

        // Cari urutan terakhir di kombinasi baru
        $lastClass = Classes::where('cls_code', 'like', $prefix . '%')
            ->orderBy('cls_code', 'desc')
            ->first();

        if ($lastClass) {
            $lastNumber = (int) substr($lastClass->cls_code, -2);
            $newNumber  = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $numberFormatted = str_pad($newNumber, 2, '0', STR_PAD_LEFT);

        $classCode = $prefix . $numberFormatted;

    } else {
        // Kalau tidak berubah → pakai kode lama
        $classCode = $class->cls_code;
    }

    // Update data
    $class->update([
        'cls_code' => $classCode,
        'cls_level' => $request->cls_level,
        'cls_major_id' => $request->cls_major_id,
        'cls_number' => $request->cls_number,
        // 'cls_homeroom_id' => $request->cls_homeroom_id,
        'cls_acy_id' => $request->cls_acy_id,
    ]);

    Alert::success('Berhasil Update', 'Data kelas berhasil diperbarui');
    return redirect('/comitte/classes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destroyClass = Classes::findOrFail($id);
        //dd ($destroyScopeCategories);
        $destroyClass->delete();
        Alert::success('Berhasil Menghapus', 'Berhasil menghapus data jurusan');
        return redirect('/comitte/classes');
    }
}
