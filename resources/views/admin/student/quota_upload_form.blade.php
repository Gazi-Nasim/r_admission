<form method="POST"
    ic-target='#result-{{$quota}}'
    enctype="multipart/form-data"
    ic-post-to='{{ route('admin.student.updateQuotaPhoto') }}'
    ic-indicator="#indicator-{{$quota}}" class="form-horizontal">

    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="student_id" id="student_id" value="{{$student->id}}">

    <!-- The fileinput-button span is used to style the file input field as button -->

    <input type="hidden" name="quota" value="{{$quota}}">
    <input  type="file" name="quota_photo" >
    @if ($quota == 'FFQ')
        <p>
            <label>
                {{Form::radio('ffq_type', 'FFQ-C','' , [])}} Child
            </label><br>
            <label>
                {{Form::radio('ffq_type', 'FFQ-G','' , [])}} Grand Child
            </label>
        </p>
    @endif
    <br>
    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i> Upload </button>
    <i id="indicator-{{$quota}}" class="fa fa-spinner fa-spin" style="display:none"></i>
</form>
{{-- upload form end --}}
