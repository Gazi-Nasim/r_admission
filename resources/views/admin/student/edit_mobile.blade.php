<form ic-post-to='{{ route('admin.student.updateMobile') }}' method="POST" ic-target=".modal-body"
      class="form-horizontal" role="form">
    @csrf
    <p class="text-danger text-center">আপনার নতুন মোবাইল নম্বর টি নিচের বক্সে লিখে সাবমিট
        করুন।</p>
    {{-- title --}}
    <div class="form-group">
        {{ Form::label('mobile_no', 'Old Mobile No.', array('class' => 'control-label col-sm-3')) }}
        <div class="col-sm-8">
            <p style="padding-top: 5px;">{{$student_data->mobile_no}}</p>
        </div>
    </div>
    <div class="form-group @if ($errors->has('mobile_no')) has-error @endif">
        {{ Form::label('mobile_no', 'Mobile No.', array('class' => 'control-label col-sm-3')) }}
        <div class="col-sm-8">
            {{Form::hidden('student_id', $student_data->id)}}
            {{ Form::text('mobile_no', old('mobile_no', request()->mobile_no),['class' => 'form-control','maxlength'=>'11']) }}
            <span class="help-block">{{ $errors->first('mobile_no') }}</span>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
    </div>
</form>





