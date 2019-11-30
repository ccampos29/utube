@include('layouts.subview_form_errors')

{!! Form::open(['route' => ['video.comment.store', $video->id], "id" => "createCommentForm"]) !!}

<div class="form-group">
    {!! Form::label('description', 'Agregar comentario', ['class' => 'control-label']) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'maxlength' => 250, 'required' => true,'rows' => 5]) !!}
</div>

<button type="submit" class="btn btn-primary"><i class='fas fa-plus'></i>Agregar</button>
{!! Form::close() !!}