<?php

namespace App\Http\Controllers\Comitte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mentor;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;



class TeacherController extends Controller
{
    public function index()
    {
        $mentor = User::Role('mentor')->get();
        // $check = Mentor::all();
        // dd($check);


        return view('comitte.teacher.index', compact(['mentor']));
    }

    public function create()
    {
        return view('comitte.teacher.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'mtr_gtk'               => 'required|string|unique:mentors,mtr_gtk',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
            ]);
            $user->assignRole('mentor');

            Mentor::create([
                'mtr_usr_id'        => $user->usr_id,
                'mtr_gtk'           => $request->mtr_gtk,
                // 'mtr_created_by'    => auth()->id(),
            ]);
        });
        Alert::success('Berhasil Menambah', 'Data guru berhasil ditambahkan');


        return redirect()->route('comitte.teacher.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mentor = User::with('mentor')->findOrFail($id);

        return view('comitte.teacher.edit', compact('mentor'));
    }

    public function update(Request $request, $id)
    {
        $mentor = Mentor::with('user')->findOrFail($id);

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $mentor->mtr_usr_id . ',usr_id',
            'mtr_gtk' => 'required|string|unique:mentors,mtr_gtk,' . $id . ',mtr_id',
        ]);

        DB::transaction(function () use ($request, $mentor) {
            $mentor->user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);

            $mentor->update([
                'mtr_gtk'        => $request->mtr_gtk,
                // 'mtr_updated_by' => auth()->id(),
            ]);
        });
        Alert::success('Berhasil Mengedit', 'Data guru berhasil diperbarui');

        return redirect()->route('comitte.teacher.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }
}
