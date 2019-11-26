<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::where('user_id', Auth::id())->paginate(3);
        if(session("success_message")){
            Alert::toast(session("success_message"),'success');;
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        return view('video.edit', compact('video'));
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
        $video->delete();

        return redirect()
            ->route('video.index')->withSuccessMessage("¡El video se ha removido!");
    }
}