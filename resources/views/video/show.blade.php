@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="title">{{$video->title}}</h2>
                    <hr>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe id="video" class="embed-responsive-item" src="../{{$video->video_url}}"
                            allowfullscreen></iframe>
                    </div>
                    <hr>
                    <h4>Descripcion: </h4>
                    <hr>
                    <p id="description">{{$video->description}}</p>
                    <hr>
                    <h4>Comentarios: </h4>
                    <hr>
                    <div id="comments">
                        <div class='content-comments'>
                            @foreach ($video->comments as $comment)
                            <p><span class='name-user'>{{$comment->user->name}}: </span>{{$comment->description}}</p>

                            <div class="actionsAlign">
                                <div class="inline">
                                    <p class='card-text inline'><small class='text-muted'>Publicado
                                            {{$comment->updated_at}}</small>
                                    </p>
                                </div>
                                <div class="inline">
                                    @if(Auth::check())
                                        @if(auth()->user()->id == $comment->user_id)
                                        <a href="{{ route('video.comment.edit', [$video, $comment]) }}" class="btn btn-link"
                                            data-toggle="tooltip" data-placement="bottom" title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        {!! Form::open(['method' => 'DELETE', 'route' => ['video.comment.destroy',$video,
                                        $comment], 'class' => ['inline']]) !!}
                                        <button class="btn btn-link" data-toggle="tooltip" data-placement="bottom"
                                            title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        {!! Form::close() !!}
                                        @endif
                                    @endif
                                    <hr>
                                    {{ $video->comments->links() }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @if (Auth::check())
                    @include('comment.create', ["video" => $video])
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection