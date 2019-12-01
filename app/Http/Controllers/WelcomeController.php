<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Video;

class WelcomeController extends Controller
{
    public function index()
    {
        $videos = Video::orderBy('updated_at', 'desc')->paginate(5);
        foreach($videos as $video){
            $video->comments = $video->comments()->orderBy('updated_at', 'desc')->get();
            foreach($video->comments as $comment){
                $comment->user;
            }
        }
        return view('welcome', compact('videos'));
    }
}
