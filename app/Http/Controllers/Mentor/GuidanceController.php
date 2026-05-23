<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class GuidanceController extends Controller
{
    public function index(){
        $news = News:: where('news_parent_id',null)->get();
        // dd($news);
        $newsFollowUp = News::where('news_parent_id','!=',null)->get();
        // dd($newsFollowUp);
        return view('mentor.guidance.index',compact(['news','newsFollowUp']));
    }
}
