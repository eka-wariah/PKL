<?php

namespace App\Http\Controllers\Comitte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mentor;
use App\Models\MentorAssignments;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;



class TeacherController extends Controller
{
    public function index()
    {
        $mentor = User::Role('mentor')->get();
        // $check = Mentor::all();
        // dd($check);
        $title = 'Hapus Data Guru!';
        $text = "Apakah Anda yakin ingin menghapus?";
        confirmDelete($title, $text);


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

    public function editPassword($id)
    {
        $mentor = User::findOrFail($id);
        // dd($mentor);
        return view('comitte.teacher.edit-password', compact(['mentor']));
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

        return redirect()->route('comitte.teacher.index')
            ->with('success', 'Password guru berhasil diubah.');
    }

    public function destroy($id)
    {
        $mentor = User::findOrFail($id);

        $mentor->delete();
        Alert::success('Berhasil Menghapus', 'Password berhasil Dihapus');
        return redirect()->route('comitte.teacher.index')
            ->with('success', 'Data BErhasil Dihapus.');
    }

    public function mentee($id)
    {
        $mentor = Mentor::with('user')->where('mtr_usr_id',$id)->first();
        // dd($mentor->user);
        $students = MentorAssignments::with([
            'student.user',
            'student.class',
        ])
            ->where('mas_mentor_id', $mentor->mtr_id)
            ->get();
            // dd($students);

        return view('comitte.teacher.mentee', compact('mentor', 'students'));
    }
}
