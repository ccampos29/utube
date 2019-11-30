@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="title">Mis videos</h2>
                    <hr>
                    @forelse ($videos as $video)
                    <div class="card mb-3">
                        <div class="row no-gutters">
                            <a class="col-md-4 content-image" href="{{ route('video.show', $video) }}">
                                <img src="{{ asset("$video->image_url") }}" class="card-img" alt="..." width="240px"
                                    height="200px">
                            </a>
                            <div class="col-md-8">
                                <div class="card-body content-video">
                                    <div class="title-video">
                                        <h5 class="card-title">{{$video->title}}</h5>
                                    </div>

                                    <div class="content-panel">
                                        <div class="panel-btns">
                                            <a href="{{ route('video.edit', $video) }}" type="button" class="btn btn-success btn-setting">Editar</a>
                                            <button type="button" class="btn btn-danger btn-setting" data-toggle="modal"
                                                data-target="#delete-video-modal" data-title="{{$video->title}}"
                                                data-id="{{$video->id}}">Eliminar</button>
                                        </div>
                                    </div>

                                    <div class="content-update">
                                        <p class="card-text"><small class="text-muted">Last updated {{ $video->updated_at->diffForHumans() }}.</small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="alert alert-primary alert-content" role="alert">
                        No hay contenido subido.
                    </div>
                    @endforelse
                    <div class="text-xs-center">

                        {{ $videos->links() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<a href="{{ route('video.create') }}" class="float">
    <i class="fa fa-plus my-float"></i>
</a>

@include('video.destroy')