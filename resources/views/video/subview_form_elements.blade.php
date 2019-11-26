@push('scripts')

<script>
    $(document).ready(function() {
        $("input[name=image_url]").on("change", function(e) {
            $(".content-preview").css("border-style", "dotted");
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".image-label").addClass("selected").html(fileName);
            let reader = new FileReader();
            reader.onload = function(){
                let preview = document.getElementById('preview'),
                        image = document.createElement('img');
                image.src = reader.result;
                preview.innerHTML = '';
                preview.append(image);
            };
            reader.readAsDataURL(e.target.files[0]);
        }); 
        $("input[name=video_url]").on("change", function(e) {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".video-label").addClass("selected").html(fileName);
        });
    });
</script>

@endpush

<div class="form-group">
    {!! Form::label('title', 'Titulo', ['class' => 'control-label']) !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'maxlength' => 50, 'autocomplete' => 'off']) !!}
</div>

<div class="form-group">
    {!! Form::label('image_url', 'Miniatura', ['class' => 'control-label']) !!}
    <div class="custom-file">
        <input type="file" class="custom-file-input" name="image_url" accept="image/jpeg">
        <label class="custom-file-label image-label" for="image_url">Choose file</label>
    </div>
    <div class="content-preview">
        <div id="preview"></div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('video_url', 'Video', ['class' => 'control-label']) !!}
    <div class="custom-file">
        <input type="file" class="custom-file-input" name="video_url" accept="video/mp4">
        <label class="custom-file-label video-label" for="video_url">Choose file</label>
    </div>
</div>

<div class="form-group">
    {!! Form::label('description', 'Descripción', ['class' => 'control-label']) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>