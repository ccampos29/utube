@push('scripts')

<script>
    $('#show-video-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var title = button.data('title')
        var video = button.data('video')
        var description = button.data('description')
        var modal = $(this)
        modal.find('.modal-title').text(title)
        modal.find('#description').text(description)
        modal.find('#video').attr("src", video)
    })

    $("#show-video-modal").on('hide.bs.modal', function(){
        var modal = $(this)
        modal.find('#video').attr("src", "")
    });
</script>

@endpush

<div class="modal fade" id="show-video-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe id="video" class="embed-responsive-item" src="" allowfullscreen></iframe>
                </div>
            </div>
            <div class="modal-footer myfooter-modal">
                <h5>Descripcion: </h5>
                <p id="description">Description</p>
            </div>
        </div>
    </div>
</div>