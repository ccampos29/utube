<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if($user->hasRole('user')){
            $videos = $user->videos()->orderBy('updated_at', 'desc')->paginate(5);
        }else if($user->hasRole('admin')){
            $videos = Video::orderBy('updated_at', 'desc')->paginate(5);
        }

        foreach($videos as $video){
            $video->comments = $video->comments()->orderBy('updated_at', 'desc')->get();
            foreach($video->comments as $comment){
                $comment->user;
            }
        }
        if(session("success_message")){
            Alert::toast(session("success_message"),'success');;
        }
        if(session("error_message")){
            Alert::toast(session("error_message"),'error');;
        }

        return view('video.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('video.create');
        // return view('video.create', compact(''));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title'       => 'required|string|min:5|max:50',
            'description' => 'required|string|min:3|max:250',
            'image_url'   => 'required|image|mimes:jpeg,jpg',
            'video_url'   => 'required|mimes:mp4',
        ])->validate();

        $input = $request->all();
        $video = new Video();
        $video->fill($input);
        $video->user_id = Auth::id();
        $video->image_name = $request->file('image_url')->getClientOriginalName();
        $video->image_url = "temp";
        $video->video_url = "temp";
        $video->save();

        $destinationPathImage = "users/$video->user_id/$video->id/image/";
        $image = $video->id . "." . $request->file('image_url')->getClientOriginalExtension();
        $request->file('image_url')->move($destinationPathImage, $image);
        $video->image_url = $destinationPathImage . $image;

        $destinationPathVideo = "users/$video->user_id/$video->id/video/";
        $video2 = $video->id . "." . $request->file('video_url')->getClientOriginalExtension();
        $request->file('video_url')->move($destinationPathVideo, $video2);
        $video->video_url = $destinationPathVideo . $video2;

        $video->save();

        return redirect()
            ->route('video.index')->withSuccessMessage("¡Video creado exitosamente!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        if(session("success_message")){
            Alert::toast(session("success_message"),'success');;
        }
        if(session("error_message")){
            Alert::toast(session("error_message"),'error');;
        }
        $video->comments = $video->comments()->orderBy('updated_at', 'desc')->paginate(5);
        foreach($video->comments as $comment){
            $comment->user;
        }

        return view('video.show', compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        $user = Auth::user();
        if($user->hasRole('admin') || $video->isOwnedByUser($user->id))
            return view('video.edit', compact('video'));
        return redirect()->route('video.index')->withErrorMessage("¡No tienes privilegios para acceder a este elemento!");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        $user = Auth::user();
        
        if(!$user->hasRole('admin') && !$video->isOwnedByUser($user->id))
            return redirect()->route('video.index')->withErrorMessage("¡No tienes privilegios para acceder a este elemento!");

        Validator::make($request->all(), [
            'title'       => 'required|string|min:5|max:50',
            'description' => 'required|string|min:3|max:250',
        ])->validate();

        $input = $request->all();
        $video->fill($input);
        
        if ($request->file('image_url') != null) {
            $video->image_name = $request->file('image_url')->getClientOriginalName();

            $destinationPathImage = "users/$video->user_id/$video->id/image/";
            $image = $video->id . "." . $request->file('image_url')->getClientOriginalExtension();
            $request->file('image_url')->move($destinationPathImage, $image);
            $video->image_url = $destinationPathImage . $image;
        }

        $video->save();

        return redirect()
            ->route('video.index')->withSuccessMessage("¡Video editado exitosamente!");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        $user = Auth::user();
        if($user->hasRole('admin') || $video->isOwnedByUser($user->id)){
            $video->delete();
            return redirect()
                   ->route('video.index')->withSuccessMessage("¡El video se ha removido!");
        }
        return redirect()->route('video.index')->withErrorMessage("¡No tienes privilegios para acceder a este elemento!");        
    }

    public function searchVideos(Request $request)
    {
        $title = $request->title;
        $videos = Video::where('title', 'LIKE', "%{$title}%")->paginate(5);
            // ->orWhere('email', 'LIKE', "%{$searchTerm}%") 
        foreach($videos as $video){
            $video->comments = $video->comments()->orderBy('updated_at', 'desc')->get();
            foreach($video->comments as $comment){
                $comment->user;
            }
        }
        return view('video.searchVideos', compact('videos'));
    }
}
