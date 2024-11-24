<form method="POST"
      ic-trigger-on='change'
      ic-target='#result-{{$quota}}'
      enctype="multipart/form-data"
      ic-post-to='{{ route('preliminary.postUploadQuotaPhoto') }}'
      ic-indicator="#indicator-{{$quota}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">

    <!-- The fileinput-button span is used to style the file input field as button -->
    <input type="hidden" name="quota" value="{{$quota}}">
    <span class="btn btn-info btn-sm btn-block fileinput-button" id="file-upload">
        <input
            {{-- id="fileupload"  --}}
            class="fileinput-item"
            type="file"
            name="quota_photo"
        >
        <i class="fa fa-plus-circle"></i>
        <span>Upload/Change {{$quota}} Document</span>&nbsp;
        <i id="indicator-{{$quota}}" class="fa fa-spinner fa-spin" style="display:none"></i>
        <!-- The file input field used as target for the file upload widget -->
    </span>
</form>

{{-- upload form end --}}
