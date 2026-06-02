<?php

namespace App\Http\Controllers\comitte;

use App\Http\Controllers\Controller;
use App\Models\MentorAssignments;
use App\Models\News;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuidanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::where('news_parent_id', null)->get();
        // dd($news);
        $newsFollowUp = News::where('news_parent_id', '!=', null)->get();
        // dd($newsFollowUp);
        return view('comitte.guidance.index', compact(['news', 'newsFollowUp']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $news = News::findOrFail($id);
        $totalMentee = MentorAssignments::where('mas_mentor_id',$news->news_mentor_id)->count();
        // dd($totalMentee);

        return view('comitte.guidance.show', compact('news','totalMentee'));
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
    public function exportPdf($id)
{
    $news = News::findOrFail($id);
    $mentorAssignments = MentorAssignments::where('mas_mentor_id',$news->news_mentor_id)->get();
    
    $totalMentee = $mentorAssignments->count();
    
    $allStudentIds = $mentorAssignments->pluck('mas_student_id');
    // $totalMentee = MentorAssignments::where('mas_mentor_id', $news->news_mentor_id)->count();
    $allStudentIds = MentorAssignments::where('mas_mentor_id',$news->news_mentor_id)->pluck('mas_student_id');
    $presentStudentIds = $news->participants->pluck('nwp_student_id');
    $absentStudents = Student::with('user') ->whereIn( 'std_id',$allStudentIds->diff($presentStudentIds))->get();

    $pdf = Pdf::loadView(
        'comitte.guidance.news-pkl',
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
