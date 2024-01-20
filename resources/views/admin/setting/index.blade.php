@extends('admin.main')
@section('title','setting')
@section('css')

<link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
<!-- PAGE-HEADER -->
<div>
    <h1 class="page-title">Dashboard</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Setting</li>
    </ol>
</div>
<!-- PAGE-HEADER END -->
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="col-lg-6">
                    <h3 class="card-title">Setting</h3>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form id="form-setting" name="form-setting" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-md-6">
                                <input type="hidden" name="hiddenSettingId" id="hiddenSettingId" value="0">
                                <div class="form-group ">
                                    <label class="control-label">Company name</label>
                                    <input type="text" class="form-control" name="company_name" id="company_name" placeholder="give me your company name">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Company address</label>
                                    <input type="text" class="form-control" name="company_address" id="company_address" placeholder="give me your company ddress">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Website</label>
                                    <input type="text" class="form-control" name="website" id="website" placeholder="give me your website">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Email</label>
                                    <input type="text" class="form-control" name="email" id="email" placeholder="give me your email">
                                </div>
                                <div class="form-groupb pb-1">
                                    <label class="control-label">Phone</label>
                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="give me your phone number">
                                </div>
                                <div class="form-group mt-6">
                                    <label class="control-label">Company logo :</label>

                                    <input type="file" class="form-control" name="company_logo" id="company_logo" accept="image/*" placeholder="give photo">

                                    <label class="col-md-3 control-label">Preview Logo:</label>
                                    <div id="imagePreviewLogo"></div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Facebook</label>
                                    <input type="text" class="form-control" name="facebook" id="facebook" placeholder="give me your facebook">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">LinkedIn</label>
                                    <input type="text" class="form-control" name="linkedIn" id="linkedIn" placeholder="give me your linkedIn">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Instagram</label>
                                    <input type="text" class="form-control" name="instagram" id="instagram" placeholder="give me your instagram">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Site title </label>
                                    <input type="text" class="form-control" name="site_title" id="site_title" placeholder="give me your site title">
                                </div>
                                <div class="form-group">
                                    <label>Meta description</label>

                                    <textarea class="form-control" name="meta_description" id="meta_description" placeholder="Write your description ..."></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Favicon :</label>

                                    <input type="file" class="form-control" name="favicon" id="favicon" accept="image/*" placeholder="give photo">

                                    <label class="col-md-3 control-label">Preview favicon:</label>
                                    <div id="imagePreview"></div>

                                </div>

                            </div>

                        </div>
                        <div class="model-footer text-right">
                            <label class="wc-error pull-left" id="form_error"></label>
                            <input type="submit" name="submit" value="Save" class="btn btn-primary mr-3" id="btnUserFormSubmit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- COL END -->

</div>

@endsection

@section('js')

<script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>

<script>
    // input photo preview image
    $(document).ready(function() {
        // Event listener for file input change
        $("#favicon").change(function() {
            // Get selected file
            var file = this.files[0];
            // Check if the file is an image
            if (file && file.type.startsWith('image/')) {
                var reader = new FileReader();
                // Read the image file as a data URL
                reader.onload = function(e) {
                    // Display the image preview
                    $('#imagePreview').html('<img src="' + e.target.result + '" alt="Thumbnail" class="img-thumbnail" style="max-width: 100%; max-height: 100px; padding-top:5px;">');
                };
                reader.readAsDataURL(file); // Read the image file
            } else {
                // Clear the image preview if the selected file is not an image
                $('#imagePreview').html('Invalid File. Please select an image.');
            }
        });
    });

    $(document).ready(function() {
        // Event listener for file input change
        $("#company_logo").change(function() {
            // Get selected file
            var file = this.files[0];
            // Check if the file is an image
            if (file && file.type.startsWith('image/')) {
                var reader = new FileReader();
                // Read the image file as a data URL
                reader.onload = function(e) {
                    // Display the image preview
                    $('#imagePreviewLogo').html('<img src="' + e.target.result + '" alt="Thumbnail" class="img-thumbnail" style="max-width: 100%; max-height: 100px; padding-top:5px;">');
                };
                reader.readAsDataURL(file); // Read the image file
            } else {
                // Clear the image preview if the selected file is not an image
                $('#imagePreviewLogo').html('Invalid File. Please select an image.');
            }
        });
    });

    $('#form-setting').on("submit", function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        // Append file inputs to the FormData object
        formData.append('company_logo', $("#company_logo")[0].files[0]);
        formData.append('favicon', $("#favicon")[0].files[0]);


        $.ajax({
            url: "{{ route('store.setting') }}",
            data: formData,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(response) {

                Toast.fire({
                    type: 'success',
                    title: response.msg,
                });
                $('#imagePreviewLogo').html('');
                $('#imagePreview').html('');

                loadDataIntoForm(response.setting);
                setTimeout(function() {
                    location.reload(true);
                }, 2000);
            },

            error: function(error) {
                Toast.fire({
                    type: 'error',
                    title: 'Something Error Found, Please try again.',
                });
            }
        });
    });

    // $(document).ready(function() {
    //     $.ajax({
    //         url: '/show-setting',
    //         type: 'GET',
    //         dataType: 'json',
    //         success: function(data) {

    //             $('#hiddenSettingId').val(data.id);
    //             $('#company_name').val(data.company_name);
    //             $('#company_address').val(data.company_address);
    //             $('#website').val(data.website);
    //             $('#email').val(data.email);
    //             $('#phone').val(data.phone);
    //             $('#facebook').val(data.facebook);
    //             $('#linkedIn').val(data.linkedIn);
    //             $('#instagram').val(data.instagram);
    //             $('#site_title').val(data.site_title);
    //             $('#meta_description').val(data.meta_description);
    //             var companylogoPath = "{{asset('assets/images/users/company-logo')}}/" + data.company_logo;

    //             $('#com_logo').attr('src', companylogoPath);
    //             var faviconPath = "{{ asset('assets/images/users/favicon') }}" + "/" + data.favicon;
    //             // Set the src attribute of the image preview element
    //             $('#favicon1').attr('src', faviconPath);


    //         }

    //     })
    // })
    // Load data when the document is ready
    $(document).ready(function() {
        $.ajax({
            url: '/show-setting',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // Call the function to populate form fields with data
                loadDataIntoForm(data);
            }
        });
    });

    function loadDataIntoForm(data) {
        $('#hiddenSettingId').val(data.id);
        $('#company_name').val(data.company_name);
        $('#company_address').val(data.company_address);
        $('#website').val(data.website);
        $('#email').val(data.email);
        $('#phone').val(data.phone);
        $('#facebook').val(data.facebook);
        $('#linkedIn').val(data.linkedIn);
        $('#instagram').val(data.instagram);
        $('#site_title').val(data.site_title);
        $('#meta_description').val(data.meta_description);
        var companylogoPath = "{{ asset('assets/images/users/company-logo') }}/" + data.company_logo;

        if (data.company_logo) {
            // Display the image preview for the existing image
            $('#imagePreviewLogo').html('<img src="' + companylogoPath + '" alt="Thumbnail" class="img-thumbnail" style="max-width: 100%; max-height: 100px; padding-top:5px;">');
        } else {
            // If the image is empty, display the demo image
            var demoImagePath = "{{ asset('assets/images/logos/demo1.jpg') }}"; // Replace this with the path to your demo image
            $('#imagePreviewLogo').html('<img src="' + demoImagePath + '" alt="Demo Image" class="img-thumbnail" style="max-width: 100%; max-height: 100px; padding-top:5px;">');
        }

        // Corrected favicon path concatenation
        var faviconPath = "{{ asset('assets/images/users/favicon') }}/" + data.favicon;

        // Checking if data.favicon exists
        if (data.favicon) {
            // Display the image preview for the existing favicon
            $('#imagePreview').html('<img src="' + faviconPath + '" alt="Thumbnail" class="img-thumbnail" style="max-width: 100%; max-height: 100px; padding-top:5px;">');
        } else {
            // If the favicon is empty, display the demo favicon
            var demoFaviconIcon = "{{ asset('assets/images/logos/demo1.jpg') }}"; // Replace this with the path to your demo favicon
            $('#imagePreview').html('<img src="' + demoFaviconIcon + '" alt="Demo Image" class="img-thumbnail" style="max-width: 100%; max-height: 100px; padding-top:5px;">');
        }


    }
</script>

@endsection