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
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GuidanceController extends Controller
{
    public function index()
    {
        $news = News::where('news_parent_id', null)->where('news_mentor_id', Auth::user()->mentor->mtr_id)->get();
        // dd($news);
        $newsFollowUp = News::where('news_parent_id', '!=', null)->where('news_mentor_id', Auth::user()->mentor->mtr_id)->get();
        // dd($newsFollowUp);
        return view('mentor.guidance.index', compact(['news', 'newsFollowUp']));
    }

    public function guidanceStart()
    {
        $mentorId = Auth::user()->mentor->mtr_id;
        $academicYears = AcademicYear::where('acy_status', 1)->first();
        // dd()
        // dd(Auth::user()->mentor->mtr_id);

        // dd($students);
        $weekNumber = 1;
        if ($academicYears) {
            $weekNumber = News::where('news_mentor_id', $mentorId)->where('news_academic_year', $academicYears->acy_id)->count() + 1;
        }
        // dd($news);
        return view('mentor.guidance.guidance-start', compact(['weekNumber']));
    }
    public function guidanceStartStore(Request $request)
    {
        $request->validate([
            'news_method'   => 'required|string',
            'news_location' => 'required|string|max:255',
        ]);

        $mentor       = Mentor::where('mtr_usr_id', Auth::user()->usr_id)->firstOrFail();
        $academicYear = AcademicYear::where('acy_status', 1)->firstOrFail();


        $weekNumber = News::where('news_mentor_id', $mentor->mtr_id)
            ->whereNull('news_parent_id')
            ->count() + 1;

        News::create([
            'news_mentor_id'     => $mentor->mtr_id,
            'news_academic_year' => $academicYear->acy_id,
            'news_date'          => now()->toDateString(),
            'news_start'         => now()->toTimeString(),
            'news_week_number'   => $weekNumber,
            'news_method'        => $request->news_method,
            'news_place'      => $request->news_location,
            'news_created_by'    => Auth::user()->usr_id,
        ]);

        return redirect()->route('mentor.guidance.index')
            ->with('success', 'Bimbingan berhasil ditambahkan.');
    }

    public function finish($id)
    {
       $news    = News::findOrFail($id);
    $mentor  = Mentor::where('mtr_usr_id', auth()->id())->firstOrFail();
    $academicYear = AcademicYear::where('acy_status', 1)->first();

    $students = MentorAssignments::with('student.user')
        ->where('mas_mentor_id', $mentor->mtr_id)
        ->where('mas_academic_id', $academicYear->acy_id)
        ->get()
        ->pluck('student')
        ->filter();

    return view('mentor.guidance.finish', compact('news', 'students'));
    }
    public function finishStore(Request $request,$id)
    {
        $request->validate([
        // 'news_ended'             => 'required',
        'siswa_hadir'            => 'required|array|min:1',
        'siswa_hadir.*'          => 'exists:students,std_id',
        'news_guidance_material' => 'required|string',
        'news_problem'           => 'nullable|string',
        'news_note'              => 'nullable|string',
        'news_image'             => 'nullable|string',
    ]);

    DB::transaction(function () use ($request, $id) {
        $news = News::findOrFail($id);

        // simpan foto
        $fotoPath = $news->news_image;
        if (!empty($request->news_image)) {
            $image   = str_replace('data:image/jpeg;base64,', '', $request->news_image);
            $image   = str_replace(' ', '+', $image);
            $decoded = base64_decode($image);
            $filename = 'bimbingan/' . uniqid('foto_', true) . '.jpg';
            Storage::disk('public')->put($filename, $decoded);
            $fotoPath = $filename;
        }

        $news->update([
            'news_ended'             => now()->toTimeString(),
            'news_guidance_material' => $request->news_guidance_material,
            'news_problem'           => $request->news_problem,
            'news_note'              => $request->news_note,
            'news_image'             => $fotoPath,
            'news_updated_by'        => auth::user()->usr_id,
        ]);

        // simpan siswa hadir
        NewsParticipant::where('nwp_news_id', $news->news_id)->delete();
        foreach ($request->siswa_hadir as $studentId) {
            NewsParticipant::create([
                'nwp_student_id' => $studentId,
                'nwp_news_id'    => $news->news_id,
                'nwp_created_by' => auth()->id(),
            ]);
        }
    });

    return redirect()->route('mentor.guidance.index')
        ->with('success', 'Bimbingan berhasil diselesaikan.');
    }

    public function show($id)
    {
        $news = News::findOrFail($id);
        $audience = 0;
        if ($news->news_parent_id != null) {
            $audience = NewsParticipant::where('nwp_news_id', $news->news_parent_id)->count();
        }
        // dd($audience);

        $totalMentee = MentorAssignments::where('mas_mentor_id', $news->news_mentor_id)->count() - $audience;
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

    public function exportPdf($id)
    {
        $news = News::findOrFail($id);
        $mentorAssignments = MentorAssignments::where('mas_mentor_id', $news->news_mentor_id)->get();

        $totalMentee = $mentorAssignments->count();

        $allStudentIds = $mentorAssignments->pluck('mas_student_id');
        // $totalMentee = MentorAssignments::where('mas_mentor_id', $news->news_mentor_id)->count();
        $allStudentIds = MentorAssignments::where('mas_mentor_id', $news->news_mentor_id)->pluck('mas_student_id');
        $presentStudentIds = $news->participants->pluck('nwp_student_id');
        $absentStudents = Student::with('user')->whereIn('std_id', $allStudentIds->diff($presentStudentIds))->get();

        $pdf = Pdf::loadView(
            'mentor.guidance.news-pkl',
            compact('news', 'totalMentee', 'absentStudents')
        )->setPaper('a4', 'portrait');

        return $pdf->download(
            'berita-acara.pdf'
        );
    }
    public function downloadPhoto($id)
    {
        $news = News::findOrFail($id);

        return Storage::disk('public')->download(
            $news->news_image,
            basename($news->news_image)
        );
    }
}
