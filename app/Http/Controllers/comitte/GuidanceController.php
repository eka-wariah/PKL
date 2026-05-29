<?php

namespace App\Http\Controllers\comitte;

use App\Http\Controllers\Controller;
use App\Models\MentorAssignments;
use App\Models\News;
use Illuminate\Http\Request;

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
}
