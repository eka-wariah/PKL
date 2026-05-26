<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\Auth;

class GuidanceController extends Controller
{
    public function index(){
        $news = News:: where('news_parent_id',null)->get();
        // dd($news);
        $newsFollowUp = News::where('news_parent_id','!=',null)->get();
        // dd($newsFollowUp);
        return view('mentor.guidance.index',compact(['news','newsFollowUp']));
    }

    public function create(){
        $mentorId= Auth::user()->mentor->mtr_id;
        $academicYears = AcademicYear::where('acy_status',0)->first();
        // dd()
        // dd(Auth::user()->mentor->mtr_id);

        $newsCount = collect();
        if($academicYears){
        $newsCount = News::where('news_mentor_id',$mentorId)->where('news_academic_year',$academicYears->acy_id)->count();

        }
        // dd($news);
        return view('mentor.guidance.create',compact(['newsCount']));
    }
    public function store(Request $request){
        // dd($request);
    }
}
