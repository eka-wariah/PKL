<?php

namespace App\Http\Controllers\comitte;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $company = Company::all();
        $title = 'Hapus Jurusan!';
        $text = "Apakah Anda yakin ingin menghapus?";
        confirmDelete($title, $text);
        return view('comitte.company.index', compact(['company']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('comitte.company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $create_company = Company::create([
            'cmp_name' => $request->cmp_name,
            'cmp_adress' => $request->cmp_adress,
        ]); 
        Alert::success('Berhasil Menambah', 'Berhasil menambah data jurusan');
        return redirect('/comitte/company');
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit_company = Company::findOrFail($id);
        return view('comitte.company.edit', compact(['edit_company']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $update_company = Company::findOrFail($id); 
        $update_company->cmp_name = $request->cmp_name;
        $update_company->cmp_adress = $request->cmp_adress;
        $update_company->save();

        Alert::success('Berhasil Mengedit', 'Berhasil mengubah data jurusan');
        return redirect('/comitte/company');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destroy_company = Company::findOrFail($id);
        $destroy_company->delete();
        Alert::success('Berhasil Menghapus', 'Berhasil menghapus data jurusan');
        return redirect('/comitte/company');
    }
}
