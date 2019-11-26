@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Video</h1>
    <p class="lead">Especificar los datos que desea editar.</p>

    <br>

    @include('layouts.subview_form_errors')

    {!! Form::model($video, [
    'method' => 'PUT',
    'route' => ['video.update', $video->id],'files' => true
    ]) !!}

    @include('video.subview_form_elements_edit')

    <button type="submit" class="btn btn-primary"><i class='fas fa-plus'></i> Guardar cambios</button>
    <a href="{{ request()->headers->get('referer') }}" class="btn btn-secondary">Cancelar</a>

    {!! Form::close() !!}

</div>
@endsection