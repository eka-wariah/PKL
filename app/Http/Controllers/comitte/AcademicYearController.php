<?php

namespace App\Http\Controllers\comitte;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $now = Carbon::now();
        $academic_year = AcademicYear::all();
        foreach ($academic_year  as $year) {

            $start = Carbon::create($year->acy_year, 7, 1);
            $end   = Carbon::create($year->acy_year + 1, 6, 30);
    
            if ($now->between($start, $end)) {
                $year->acy_status = 1;
            } else {
                $year->acy_status = 0;
            }
    
            $year->save();
        }
    
        $academicYears = AcademicYear::latest()->get();
        $title = 'Hapus Tahun Akademik!';
        $text = "Apakah Anda yakin ingin menghapus?";
        confirmDelete($title, $text);
        return view('comitte.academic-year.index', compact('academic_year'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $startYear = date('Y');

        $years = [];

        for ($i = 0; $i < 2; $i++) {
            $years[] = $startYear + $i;
        }

        return view('comitte.academic-year.create', compact('years'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'acy_year' => 'required|digits:4|integer'
        ]);
        $checkYear = AcademicYear::where('acy_year', $request->acy_year)->exists();

        if ($checkYear) {
            Alert::error('Gagal', 'Tahun ajaran sudah ada');
            return redirect()->back()->withInput();
        }
    
        AcademicYear::create([
            'acy_year' => $request->acy_year,
            'acy_created_by' => auth()->id()
        ]);
    
        Alert::success('Berhasil Menambah', 'Berhasil menambah data tahun ajaran');
        return redirect('/comitte/academic-years');
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
        $edit_academic = AcademicYear::findOrFail($id);
        $years = [date('Y'), date('Y') + 1];
        return view('comitte.academic-year.edit', compact('edit_academic', 'years'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'acy_year' => 'required|digits:4|integer'
        ]);

        $checkYear = AcademicYear::where('acy_year', $request->acy_year)
                    ->where('acy_id', '!=', $id)
                    ->exists();

    if ($checkYear) {
        Alert::error('Gagal', 'Tahun ajaran sudah ada');
        return redirect()->back()->withInput();
    }

    
        $academicYear = AcademicYear::findOrFail($id);
    
        $academicYear->update([
            'acy_year' => $request->acy_year,
            'acy_updated_by' => auth()->id()
        ]);
    
        Alert::success('Berhasil Update', 'Data tahun ajaran berhasil diperbarui');
        return redirect('/comitte/academic-years');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destroyAcademic = AcademicYear::findOrFail($id);

    // Cek status
    if ($destroyAcademic->acy_status == 1) {

        Alert::error('Gagal', 'Tahun ajaran masih aktif');
        return redirect('/comitte/academic-years');
    }

    // Kalau status 0 → boleh hapus
    $destroyAcademic->delete();

    Alert::success('Berhasil', 'Tahun ajaran berhasil dihapus');

    return redirect('/comitte/academic-years');
    }
}
