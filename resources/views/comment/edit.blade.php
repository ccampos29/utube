@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar comentario</h1>
    
    <br>

    @include('layouts.subview_form_errors')

    {!! Form::model($comment, ['route' => ['video.comment.update', $video, $comment], 'method' => 'PUT']) !!}

    <div class="form-group">
        {!! Form::label('description', 'Comentario', ['class' => 'control-label']) !!}
        {!! Form::textarea('description', null, ['class' => 'form-control', 'maxlength' => 250, 'required' => true,'rows' => 5]) !!}
    </div>

    <button type="submit" class="btn btn-primary"><i class='fas fa-pen'></i> Editar</button>
    {!! Form::close() !!}
@endsection