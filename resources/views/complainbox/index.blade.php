@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">
            <blockquote class="alert-warning">
                <strong> <i class="fa fa-exclamation-triangle"></i> আপনার সমস্যার কথা জানান</strong>
            </blockquote>

            {{--<pre>
                {{print_r(session()->all())}}
            </pre>--}}

            <div class="row">
                <div class="col-sm-12">
                    {{Form::open(['route' => 'complainbox.postInfo'])}}
                    {{-- ssc Information --}}
                    <div class="form-section well">
                        <legend>ব্যক্তিগত তথ্য</legend>
                        <div class="row form-horizontal">
                            <div class="col-sm-12">
                                {{-- name --}}
                                <div class="form-group @if ($errors->has('name')) has-error @endif">
                                    <label for="input-id" class="control-label col-sm-3">Candidate Name</label>
                                    <div class="col-sm-8">
                                        {{ Form::text('name', old('name', session('complain.name')), array('class' => 'form-control','placeholder'=>"Candidate Name")) }}
                                        {!! $errors->first('name','<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                                {{-- father's name --}}
                                <div class="form-group @if ($errors->has('fname')) has-error @endif">
                                    <label for="input" class="control-label col-sm-3">Father's Name</label>
                                    <div class="col-sm-8">
                                        {{ Form::text('fname', old('fname', session('complain.fname')), array('class' => 'form-control','placeholder'=>"Father's Name")) }}
                                        {!! $errors->first('fname','<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                                {{-- mother's name --}}
                                <div class="form-group @if ($errors->has('mname')) has-error @endif">
                                    <label for="input" class="control-label col-sm-3">Mother's Name</label>
                                    <div class="col-sm-8">
                                        {{ Form::text('mname', old('mname', session('complain.mname')), array('class' => 'form-control','placeholder'=>"Mother's Name")) }}
                                        {!! $errors->first('mname','<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>

                                {{-- gender  --}}
                                <div class="form-group @if ($errors->has('sex')) has-error @endif">
                                    <label for="input" class="control-label col-sm-3">Gender</label>
                                    <div class="col-sm-8">
                                        <label class="radio-inline">
                                            {{ Form::radio('sex', 'M',old('sex', session('complain.sex'))=='M') }} Male
                                        </label>
                                        <label class="radio-inline">
                                            {{ Form::radio('sex', 'F',old('sex', session('complain.sex'))=='F') }} Female
                                        </label><br>
                                        {!! $errors->first('sex','<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>

                                {{-- dob --}}
                                <div class="form-group @if ($errors->has('dob')) has-error @endif">
                                    <label for="input" class="control-label col-sm-3">Date of Birth</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            {{ Form::text('dob', old('dob', session('complain.dob')), array('class' => 'form-control datepicker','placeholder'=>"dd/mm/yyyy")) }}
                                            <span class="input-group-addon" id="basic-addon1"><i
                                                    class="fa fa-calendar"></i></span>
                                        </div>
                                        {!! $errors->first('dob','<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>

                                {{-- Mobile No --}}
                                <div class="form-group @if ($errors->has('mobile_no')) has-error @endif">
                                    <label for="input" class="control-label col-sm-3">Mobile No</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><b>+88</b></span>
                                            {{ Form::text('mobile_no', old('mobile_no', session('complain.mobile_no')), array('class' => 'form-control','placeholder'=>"Mobile No.")) }}
                                        </div>
                                        {!! $errors->first('mobile_no','<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                        <br>
                        <legend>HSC/সমমানের তথ্য</legend>
                        <div class="row">
                            {{-- HSC/Equivalent Roll --}}
                            <div class="form-group col-sm-3 @if ($errors->has('hsc_roll')) has-error @endif">
                                <label for="input" class="control-label">Roll</label>
                                {{ Form::text('hsc_roll', old('hsc_roll', session('complain.hsc_roll')), array('class' => 'form-control','placeholder'=>"HSC Roll")) }}
                                {!! $errors->first('hsc_roll','<span class="help-block">:message</span>') !!}
                            </div>

                            {{-- HSC/Equivalent Board --}}
                            <div class="form-group col-sm-3 @if ($errors->has('hsc_board')) has-error @endif">
                                <label for="input-id" class="control-label">Board</label>
                                {{ Form::select('hsc_board', array(""=>'Please Select')+$hsc_board , old('hsc_board', session('complain.hsc_board')), array('class' => 'form-control') ) }}
                                {!! $errors->first('hsc_board','<span class="help-block">:message</span>') !!}
                            </div>
                            {{-- HSC/Equivalent Year --}}
                            <div class="form-group col-sm-3 @if ($errors->has('hsc_pass_year')) has-error @endif">
                                <label for="input-id" class="control-label">Year</label>
                                {{ Form::select('hsc_pass_year', array(""=>'Please Select')+$hsc_year , old('hsc_pass_year', session('complain.hsc_pass_year')), array('class' => 'form-control') ) }}
                                {!! $errors->first('hsc_pass_year','<span class="help-block">:message</span>') !!}
                            </div>

                            {{-- HSC/Equivalent REG No --}}
                            <div class="form-group col-sm-3 @if ($errors->has('hsc_reg_no')) has-error @endif">
                                <label for="input" class="control-label">Reg. No.</label>
                                {{ Form::text('hsc_reg_no', old('hsc_reg_no', session('complain.hsc_reg_no')), array('class' => 'form-control','placeholder'=>"HSC Reg No")) }}
                                {!! $errors->first('hsc_reg_no','<span class="help-block">:message</span>') !!}
                            </div>

                            {{-- CGPA --}}
                            <div class="form-group col-sm-3 @if ($errors->has('hsc_gpa')) has-error @endif">
                                <label for="input" class="control-label">CGPA</label>
                                {{ Form::text('hsc_gpa', old('hsc_gpa', session('complain.hsc_gpa')), array('class' => 'form-control','placeholder'=>"HSC GPA")) }}
                                {!! $errors->first('hsc_gpa','<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <br>
                        <legend>SSC/সমমানের তথ্য</legend>
                        <div class="row">
                            {{-- SSC/Equivalent Roll --}}
                            <div class="form-group col-sm-3 @if ($errors->has('ssc_roll')) has-error @endif">
                                <label for="input" class="control-label">Roll</label>
                                {{ Form::text('ssc_roll', old('ssc_roll', session('complain.ssc_roll')), array('class' => 'form-control','placeholder'=>"SSC Roll")) }}
                                {!! $errors->first('ssc_roll','<span class="help-block">:message</span>') !!}
                            </div>

                            {{-- SSC/Equivalent Board --}}
                            <div class="form-group col-sm-3 @if ($errors->has('ssc_board')) has-error @endif">
                                <label for="input-id" class="control-label">Board</label>
                                {{ Form::select('ssc_board', array(""=>'Please Select')+$ssc_board , old('ssc_board', session('complain.ssc_board')), array('class' => 'form-control') ) }}
                                {!! $errors->first('ssc_board','<span class="help-block">:message</span>') !!}
                            </div>
                            {{-- SSC/Equivalent Year --}}
                            <div class="form-group col-sm-3 @if ($errors->has('ssc_pass_year')) has-error @endif">
                                <label for="input-id" class="control-label">Year</label>
                                {{ Form::select('ssc_pass_year', array(""=>'Please Select')+$ssc_year , old('ssc_pass_year', session('complain.ssc_pass_year')), array('class' => 'form-control') ) }}
                                {!! $errors->first('ssc_pass_year','<span class="help-block">:message</span>') !!}
                            </div>

                            {{-- SSC/Equivalent REG No --}}
                            <div class="form-group col-sm-3 @if ($errors->has('ssc_reg_no')) has-error @endif">
                                <label for="input" class="control-label">Reg No.</label>
                                {{ Form::text('ssc_reg_no', old('ssc_reg_no', session('complain.ssc_reg_no')), array('class' => 'form-control','placeholder'=>"HSC Reg No")) }}
                                {!! $errors->first('hsc_reg_no','<span class="help-block">:message</span>') !!}
                            </div>

                            {{-- CGPA --}}
                            <div class="form-group col-sm-3 @if ($errors->has('ssc_gpa')) has-error @endif">
                                <label for="input" class="control-label">CGPA</label>
                                {{ Form::text('ssc_gpa', old('ssc_gpa', session('complain.ssc_gpa')), array('class' => 'form-control','placeholder'=>"SSC GPA")) }}
                                {!! $errors->first('ssc_gpa','<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <br>

                        <legend>সমস্যার বিবরণ</legend>
                        <div class="row">
                            {{-- Mesage --}}
                            <div class="form-group col-sm-12 @if ($errors->has('message')) has-error @endif">
                                 <label for="input" class="control-label">সমস্যার ধরণ</label>
                                {{ Form::select('complain_type_id', array(""=>'Please Select')+$complainTypes->toArray() , old('complain_type_id', session('complain.complain_type_id')), array('class' => 'form-control') ) }}
                                {!! $errors->first('complain_type_id','<span class="help-block">:message</span>') !!}
                            </div>

                            {{-- Mesage --}}
                            <div class="form-group col-sm-12 @if ($errors->has('message')) has-error @endif">
                                 <label for="input" class="control-label">সমস্যার বিবরণ</label>
                                {{ Form::textarea('message', old('message', session('complain.message')), ['class' => 'form-control', 'placeholder'=>"সমস্যার বিবরণ এখানে সংক্ষিপ্ত ভাবে লিখুন", 'size' => '20x6']) }}
                                {!! $errors->first('message','<span class="help-block">:message</span>') !!}
                            </div>
                        </div>


                        {{-- captcha --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-warning ">
                                    <div class="panel-body bg-warning">
                                        <h4>নিচের ছবিতে প্রদর্শিত ইংরেজী লেখাটি পাশের টেক্সটবক্সে হুবহু লিখুন। </h4>
                                    </div>
                                </div>
                                <div class="form-group  @if ($errors->has('captcha')) has-error @endif">
                                    <label for="input-id" class="control-label col-sm-3"> &nbsp;</label>
                                    <div class="col-sm-4 text-center">
                                        <img src="{{captcha_src('flat')}}"
                                             class="img-responsive img-thumbnail class image-right"
                                             alt="Please enable image in your browser"/>
                                    </div>
                                    <div class="col-sm-4">
                                        {{ Form::text('captcha', old('captcha'), array('class' => 'form-control', 'autocomplete'=>'off')) }}
                                        {!! $errors->first('captcha','<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="input-id" class="control-label col-sm-4"></label>
                                    <div class="col-sm-8 text-right">
                                        <a class="btn btn-danger" href="{{route('site.home')}}">Cancel</a>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i> Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </div>

        </div>
    </div>
@stop

@section('css-extra')
    {{ Html::style('assets/plugins/datepicker2/css/datepicker.css') }}
@stop

@section('script-extra')
    {{ Html::script('assets/plugins/datepicker2/js/bootstrap-datepicker.js') }}
    <script type="text/javascript">

        jQuery(document).ready(function ($) {
            $('.datepicker').datepicker({
                format: "dd/mm/yyyy",
                startView: 2,
                autoclose: true,
                todayHighlight: true
            });
        });

    </script>
@stop
