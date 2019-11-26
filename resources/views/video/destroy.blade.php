@push('scripts')

<script>
    $('#delete-video-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var title = button.data('title')
        var id = button.data('id')
        var modal = $(this)
        modal.find('#video-title').text(title)
        modal.find('#form-delete').attr('action', "{{ route('video.index') }}/" + id);
    })

    $("#delete-video-modal").on('hide.bs.modal', function(){

    });
</script>

@endpush

<div class="modal fade" id="delete-video-modal" tabindex="-1" role="dialog" aria-labelledby="delete-video-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete-video-modalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Esta seguro que desea eliminar el video: <span id="video-title"></span>?
            </div>
            <div class="modal-footer">
                {!! Form::open(['method' => 'DELETE', 'id' => 'form-delete', 'route' => ['video.destroy',
                isset($video) ? $video->id : 0 ]]) !!}
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Aceptar</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>