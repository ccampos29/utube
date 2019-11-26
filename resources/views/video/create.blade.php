@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear un nuevo video</h1>
    <p class="lead">Especificar los datos del nuevo video.</p>
    
    <br>
    
    @include('layouts.subview_form_errors')

    {!! Form::open(['route' => 'video.store', 'files' => true]) !!}

        @include('video.subview_form_elements')

        <button type="submit" class="btn btn-primary"><i class='fas fa-plus'></i> Crear</button>
        <a href="{{ request()->headers->get('referer') }}" class="btn btn-secondary">Cancelar</a>
    {!! Form::close() !!}
</div>
@endsection