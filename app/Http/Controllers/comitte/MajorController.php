<?php

namespace App\Http\Controllers\comitte;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $majors = Major::all();
        $title = 'Hapus Jurusan!';
        $text = "Apakah Anda yakin ingin menghapus?";
        confirmDelete($title, $text);
        return view('comitte.major.index', compact(['majors']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('comitte.major.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $create_major = Major::create([
            'mjr_name' => $request->mjr_name,
            'mjr_abbr' => $request->mjr_abbr,
        ]); 
        Alert::success('Berhasil Menambah', 'Berhasil menambah data jurusan');
        return redirect('/comitte/major');
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
        $edit_major = Major::findOrFail($id);
        return view('comitte.major.edit', compact(['edit_major']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $update_major =Major::findOrFail($id); 
        $update_major->mjr_name = $request->mjr_name;
        $update_major->mjr_abbr = $request->mjr_abbr;
        $update_major->save();

        Alert::success('Berhasil Mengedit', 'Berhasil mengubah data jurusan');
        return redirect('/comitte/major');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destroy_major = Major::findOrFail($id);
        $destroy_major->delete();
        Alert::success('Berhasil Menghapus', 'Berhasil menghapus data jurusan');
        return redirect('/comitte/major');
    }
}
