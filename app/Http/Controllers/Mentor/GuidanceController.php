<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\MentorAssignments;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\Auth;
use App\Models\NewsParticipant;
use App\Models\Mentor;
use App\Models\MentorAssignment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GuidanceController extends Controller
{
    public function index()
    {
        $news = News::where('news_parent_id', null)->get();
        // dd($news);
        $newsFollowUp = News::where('news_parent_id', '!=', null)->get();
        // dd($newsFollowUp);
        return view('mentor.guidance.index', compact(['news', 'newsFollowUp']));
    }

    public function create()
    {
        $mentorId = Auth::user()->mentor->mtr_id;
        $academicYears = AcademicYear::where('acy_status', 1)->first();
        // dd()
        // dd(Auth::user()->mentor->mtr_id);
        $students = collect(); // default kosong

        if ($academicYears) {
            $students = MentorAssignments::with('student.user')
                ->where('mas_mentor_id', $mentorId)
                ->where('mas_academic_id', $academicYears->acy_id)
                ->get()
                ->pluck('student')
                ->filter();
        }
        // dd($students);
        $weekNumber = 1;
        if ($academicYears) {
            $weekNumber = News::where('news_mentor_id', $mentorId)->where('news_academic_year', $academicYears->acy_id)->count() + 1;
        }
        // dd($news);
        return view('mentor.guidance.create', compact(['weekNumber', 'students']));
    }
    public function store(Request $request)
    {
        $request->validate([
            'news_start'             => 'required',
            'news_ended'             => 'required',
            'siswa_hadir'            => 'required|array|min:1',
            'siswa_hadir.*'          => 'exists:students,std_id',
            'news_guidance_material' => 'required|string',
            'news_problem'           => 'nullable|string',
            'news_note'              => 'nullable|string',
            'news_image'             => 'nullable|string',
        ]);
        // dd($request);

        DB::transaction(function () use ($request) {
            $mentor       = Mentor::where('mtr_usr_id', Auth::user()->usr_id)->firstOrFail();
            $academicYear = AcademicYear::where('acy_status', 1)->firstOrFail();

            // simpan foto base64
            $fotoPath = null;
            if (!empty($request->news_image)) {
                $base64   = $request->news_image;
                $image    = str_replace('data:image/jpeg;base64,', '', $base64);
                $image    = str_replace(' ', '+', $image);
                $decoded  = base64_decode($image);

                $filename = 'guidance/' . uniqid('foto_', true) . '.jpg';
                Storage::disk('public')->put($filename, $decoded);
                $fotoPath = $filename;
            }

            // hitung minggu ke
            $weekNumber = News::where('news_mentor_id', $mentor->mtr_id)
                ->whereNull('news_parent_id')
                ->count() + 1;

            // simpan berita acara
            $news = News::create([
                'news_mentor_id'         => $mentor->mtr_id,
                'news_academic_year'     => $academicYear->acy_id,
                'news_date'              => now()->toDateString(),
                'news_start'             => $request->news_start,
                'news_ended'             => $request->news_ended,
                'news_week_number'       => $weekNumber,
                'news_guidance_material' => $request->news_guidance_material,
                'news_problem'           => $request->news_problem,
                'news_note'              => $request->news_note,
                'news_image'             => $fotoPath,
                'news_created_by'        => Auth::user()->usr_id,
            ]);

            // simpan siswa hadir
            foreach ($request->siswa_hadir as $studentId) {
                NewsParticipant::create([
                    'nwp_student_id' => $studentId,
                    'nwp_news_id'    => $news->news_id,
                    'nwp_created_by' => Auth::user()->usr_id,
                ]);
            }
        });

        return redirect()->route('mentor.guidance.index')
            ->with('success', 'Bimbingan berhasil disimpan.');
    }

    public function show($id)
    {
        $news = News::findOrFail($id);
        $totalMentee = MentorAssignments::where('mas_mentor_id', $news->news_mentor_id)->count();
        // dd($totalMentee);

        return view('mentor.guidance.show', compact('news', 'totalMentee'));
    }

    public function followUp($id)
    {
        $news = News::findOrFail($id);
        $mentorId = Auth::user()->mentor->mtr_id;
        // $weekNumber = $news->
        $academicYears = AcademicYear::where('acy_status', 1)->first();
        $students = MentorAssignments::with('student.user')
            ->where('mas_mentor_id', $mentorId)
            ->where('mas_academic_id', $academicYears->acy_id)
            ->whereHas('student', function ($query) use ($news) {
                $query->whereDoesntHave('newsParticipants', function ($q) use ($news) {
                    $q->whereHas('news', function ($n) use ($news) {
                        $n->where('news_id', $news->news_id)
                            ->whereNull('news_parent_id'); // bukan susulan
                    });
                });
            })
            ->get()
            ->pluck('student')
            ->filter();
        // dd($students);
        return view('mentor.guidance.follow-up', compact('news', 'students'));
    }

    public function followUpStore(Request $request)
    {
        $request->validate([
            'news_start'             => 'required',
            'news_ended'             => 'required',
            'siswa_hadir'            => 'required|array|min:1',
            'siswa_hadir.*'          => 'exists:students,std_id',
            'news_guidance_material' => 'required|string',
            'news_problem'           => 'nullable|string',
            'news_note'              => 'nullable|string',
            'news_image'             => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $fotoPath = null;
            if (!empty($request->news_image)) {
                $base64   = $request->news_image;
                $image    = str_replace('data:image/jpeg;base64,', '', $base64);
                $image    = str_replace(' ', '+', $image);
                $decoded  = base64_decode($image);

                $filename = 'guidance/' . uniqid('foto_', true) . '.jpg';
                Storage::disk('public')->put($filename, $decoded);
                $fotoPath = $filename;
            }
            $newsCall = News::findOrFail($request->news_parent_id);

            $news = News::create([
                'news_mentor_id'         => $newsCall->news_mentor_id,
                'news_academic_year'     => $newsCall->news_academic_year,
                'news_date'              => now()->toDateString(),
                'news_start'             => $request->news_start,
                'news_ended'             => $request->news_ended,
                'news_week_number'       => $newsCall->news_week_number,
                'news_guidance_material' => $request->news_guidance_material,
                'news_problem'           => $request->news_problem,
                'news_note'              => $request->news_note,
                'news_image'             => $fotoPath,
                'news_parent_id'         => $request->news_parent_id,
                'news_created_by'        => Auth::user()->usr_id,
            ]);
            foreach ($request->siswa_hadir as $studentId) {
                NewsParticipant::create([
                    'nwp_student_id' => $studentId,
                    'nwp_news_id'    => $news->news_id,
                    'nwp_created_by' => Auth::user()->usr_id,
                ]);
            }
        });

         return redirect()->route('mentor.guidance.index')
            ->with('success', 'Bimbingan berhasil disimpan.');
    }
}
