<div class="tab-pane fade active show" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Hello {{ Auth::user()->name }}</h3>
            <br>
            <img id="showImage" class="rounded avatar-lg mt-1"
                src="{{ !empty($userData->photo) ? asset('') . $userData->photo : asset('upload\no_image.jpg') }}"
                alt="Card image cap" style="width: 120px; height:150px;">
        </div>
        <div class="card-body">
            <form id="imageUploadForm" enctype="multipart/form-data">
                @csrf
                <input type="file" name="image" id="imageInput" class="form-control">
                <button type="submit" class="btn btn-primary mt-2">Change Image</button>
            </form>
            <div id="imagePreview"></div>
        </div>
        
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#imageUploadForm').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('upload.image') }}",
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    var fileUrl = data.data.file_url;
                    // Handle success response
                    $('#imagePreview').html('<img src="' + fileUrl + '" alt="Uploaded Image" style="width: 120px; height:150px;">');
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>