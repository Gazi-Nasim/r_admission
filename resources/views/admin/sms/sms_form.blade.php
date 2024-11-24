@if (session()->has('sms-success'))
    <blockquote class="alert-success">
        <strong><i class="fa fa-check"></i> {{session('sms-success')}}</strong>
    </blockquote>
@endif
<form class="form" role="form">
    @csrf
    <div class="form-group @if ($errors->has('mobile_no')) has-error @endif">
        <label class="control-label">Mobile No</label>
        {{Form::text('mobile_no', old('mobile_no', ''), ['class' => 'form-control','placeholder'=>'Mobile No', 'size'=>'15'])}}
        {!!$errors->first('mobile_no','<span class="help-block">:message</span>') !!}
    </div>
    <div class="form-group @if ($errors->has('message')) has-error @endif">
        <label class="control-label">Message</label>
        {{Form::textarea('message', old('message', ''), ['class' => 'form-control','placeholder'=>'message', 'rows'=>'4'])}}
        <p id="count">Character Remaining : </p>
        {!!  $errors->first('message','<span class="help-block">:message</span>') !!}
    </div>
    <p class="text-right">
        <button
            type="submit"
            ic-post-to="{{ route('admin.sms.send') }}"
            ic-target="#form"
            ic-confirm="Are you sure?"
            class="btn btn-primary"
        ><i class="fa fa-send"></i> Send
        </button>

    </p>
</form>
