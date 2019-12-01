<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Video $video, Request $request)
    {
        Validator::make($request->all(), [
            'description' => 'required|string|min:3|max:250',
        ])->validate();
        
        $input = $request->all();
        $comment = new Comment();
        $comment->fill($input);
        $comment->user_id = Auth::id();
        $comment->video_id = $video->id;
        $comment->save();

        return redirect()
            ->route('video.show', ["video" => $video])
            ->withSuccessMessage("¡comentario agregado!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video, Comment $comment)
    {
        $user = Auth::user();
        if($user->hasRole('admin') || $comment->isOwnedByUser($user->id))
            return view('comment.edit', compact('video', 'comment'));

        return redirect()
            ->route('video.show', $video)
            ->withErrorMessage("¡No tienes privilegios para acceder a este elemento!");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video, Comment $comment)
    {
        $user = Auth::user();
        
        if(!$user->hasRole('admin') && !$comment->isOwnedByUser($user->id))
            return redirect()
                ->route('video.show', $video)
                ->withErrorMessage("¡No tienes privilegios para acceder a este elemento!");

        $comment->description = $request->description;
        $comment->save();
        
        return redirect()
            ->route('video.show', $video)
            ->withSuccessMessage("¡El comentario se ha editado!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video, Comment $comment)
    {
        $user = Auth::user();
        if($user->hasRole('admin') || $comment->isOwnedByUser($user->id)){
            $comment->delete();

            return redirect()
                ->route('video.show', $video)
                ->withSuccessMessage("¡El comentario se ha removido!");
        }
        return redirect()
            ->route('video.show', $video)
            ->withErrorMessage("¡No tienes privilegios para acceder a este elemento!");
    }
}
