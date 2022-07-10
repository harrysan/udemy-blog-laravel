@extends('admin.admin_master')

@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Portofolio Edit Page</h4>
                        
                        <form method="POST" action="{{ route('update.portofolio') }}" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id" value="{{ $portofolio->id }}">

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Portofolio Name</label>
                                <div class="col-sm-10">
                                    <input name="portofolio_name" class="form-control" type="text" value="{{ $portofolio->portofolio_name }}" id="portofolio_name">
                                    @error('portofolio_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Portofolio Title</label>
                                <div class="col-sm-10">
                                    <input name="portofolio_title" class="form-control" type="text" value="{{ $portofolio->portofolio_title }}" id="portofolio_title">
                                    @error('portofolio_title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Portofolio Description</label>
                                <div class="col-sm-10">
                                    <textarea id="elm1" name="portofolio_description">
                                        {{ $portofolio->portofolio_description }}
                                    </textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Portofolio Image </label>
                                <div class="col-sm-10">
                                    <input name="portofolio_image" class="form-control" type="file" id="image">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <img id="showImage" class="rounded avatar-lg" src="{{ (!empty($portofolio->portofolio_image))? url($portofolio->portofolio_image):url('upload/no_image.jpg') }}" alt="Card image cap">
                                </div>
                            </div>

                            <input type="submit" value="Update Portofolio Data" class="btn btn-info waves-effect waves-light">
                        </form>
                    
                    </div>
                </div>
            </div> <!-- end col -->
        </div>

    </div>
</div>

<script type="text/javascript">

    $(document).ready(function () {
        $('#image').change(function (e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });

</script>

@endsection