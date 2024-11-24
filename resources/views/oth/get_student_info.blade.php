@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">

            <blockquote class="alert-warning">
                <strong> আপনার এইচএসসি/এসএসসি (অথবা সমমান) তথ্য আমাদের ডাটাবেজে নেই।
                    নিচের ফরমে আপনার এইচএসসি ও এসএসসি (অথবা সমমান) এর মার্কশিট আপলোড করুন এবং
                    অন্যান্য ব্যক্তিগত ও শিক্ষাগত তথ্য দিন। </strong>
            </blockquote>

            <legend><i class="fa fa-photo"></i> Upload HSC/SSC Equivalent Transcipt</legend>
{{--            <pre>--}}
{{--                {{print_r(Session::all())}}--}}
{{--            </pre>--}}


            @if (Session::has('error'))
                <blockquote class="alert-danger">
                    <strong> <i class="fa fa-exclamation-triangle"></i> {{session('error')}}</strong>
                </blockquote>
            @endif

            {{-- image placeholder --}}
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">{{-- ssc photo --}}
                    <p class="text-center" id="uploaded-photo-ssc">
                        @if (Session::has('oth.photo_ssc'))
                            {{ Html::image(Storage::url('public/uploads/oth-temp/'.session('oth.photo_ssc')), 'Photo', ['class'=>'img-responsive img-thumbnail', 'width'=>250]) }}
                        @else
                            {{ Html::image('assets/img/ssc_placeholder.jpg', 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>250)) }}
                        @endif
                    </p>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">{{-- hsc photo --}}
                    <p class="text-center" id="uploaded-photo-hsc">
                        @if (Session::has('oth.photo_hsc'))
                            {{ Html::image(Storage::url('public/uploads/oth-temp/'.session('oth.photo_hsc')), 'Photo', ['class'=>'img-responsive img-thumbnail', 'width'=>250]) }}
                        @else
                            {{ Html::image('assets/img/hsc_placeholder.jpg', 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>250)) }}
                        @endif
                    </p>
                </div>
            </div>
            {{-- /image placeholder --}}

            {{-- upload forms --}}
            <div class="row">
                <div class="col-sm-6">{{-- ssc photo upload from --}}
                    {{-- new upload --}}
                    <p class="error text-danger"></p>

                    <p class="text-center" id="indicator-ssc" style="display:none"><i class="fa fa-spinner fa-spin"></i>
                        Please wait for upload to finish</p>
                    <form method="POST"
                          ic-trigger-on='change'
                          ic-target='#uploaded-photo-ssc'
                          enctype="multipart/form-data"
                          ic-post-to="{{ route('oth.postUploadDocument','SSC') }}"
                          ic-indicator="#indicator-ssc">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        <p class="text-center">
                            <!-- The fileinput-button span is used to style the file input field as button -->
                            <span class="btn btn-primary fileinput-button">
                            <input
                                id="fileupload"
                                class="fileinput-item"
                                type="file"
                                name="photo_ssc"
                            >
                            <i class="fa fa-plus-circle"></i>
                            <span>Upload/Change SSC Equivalent Transcript</span>
                        </span>
                        </p>
                    </form>
                    {{-- /new upload --}}
                </div>{{-- photo-ssc --}}

                <div class="col-sm-6">{{-- hsc photo upload from --}}
                    {{-- new upload  --}}
                    <p class="error text-danger"></p>

                    <p class="text-center" id="indicator-hsc" style="display:none"><i class="fa fa-spinner fa-spin"></i>
                        Please wait for upload to finish.</p>
                    <form method="POST"
                          ic-trigger-on='change'
                          ic-target='#uploaded-photo-hsc'
                          enctype="multipart/form-data"
                          ic-post-to="{{ route('oth.postUploadDocument','HSC') }}"
                          ic-indicator="#indicator-hsc">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        <p class="text-center">
                            <!-- The fileinput-button span is used to style the file input field as button -->
                            <span class="btn btn-primary fileinput-button">
                            <input
                                id="fileupload"
                                class="fileinput-item"
                                type="file"
                                name="photo_hsc"
                            >
                            <i class="fa fa-plus-circle"></i>
                            <span>Upload/Change HSC Equivalent Transcript</span>
                                <!-- The file input field used as target for the file upload widget -->
                        </span>
                        </p>
                    </form>
                    {{-- /new upload  --}}
                </div> {{-- phot hsc --}}
            </div>
            {{-- /upload forms  --}}

            <br><br>
            <legend><i class="fa fa-user"></i> Student information form for GCE/BFA</legend>
            <blockquote class="alert-warning">
                <strong> আপনার এইচএসসি/এসএসসি (অথবা সমমান) তথ্য আমাদের ডাটাবেজে নেই।
                    নিচের ফরমে আপনার ব্যক্তিগত ও শিক্ষাগত তথ্য দিন। </strong>
            </blockquote>
            <div class="row">
                <div class="col-sm-12">
                    {{Form::open( ['route'=>'oth.postStudentInfo','files'=>'true'])}}
                    {{-- hsc Information --}}
                    <div class="form-section well">
                        <legend>HSC or Equivalent</legend>
                        <div class="row">
                            {{-- SSC/Equivalent Roll --}}
                            <div class="form-group col-sm-3 @if ($errors->has('hsc_roll')) has-error @endif">
                                <label for="input" class="control-label">Roll</label>
                                {{ Form::text('hsc_roll', old('hsc_roll',session('inputs.hsc_roll')), array('class' => 'form-control','placeholder'=>"HSC Roll")) }}
                                {!! $errors->first('hsc_roll','<span class="help-block">:message</span>') !!}
                            </div>

                            {{-- HSC/Equivalent Board --}}
                            <div class="form-group col-sm-3 @if ($errors->has('hsc_board')) has-error @endif">
                                <label for="input-id" class="control-label">Board</label>
                                <input type="hidden" name="hsc_board" value="oth">
                                <input type="text" class="form-control"  value="Other" disabled>
                                {!! $errors->first('hsc_board','<span class="help-block">:message</span>') !!}
                            </div>
                            {{-- HSC/Equivalent Year --}}
                            <div class="form-group col-sm-3 @if ($errors->has('hsc_pass_year')) has-error @endif">
                                <label for="input-id" class="control-label">Year</label>
                                {{ Form::select('hsc_pass_year', array(""=>'Please Select')+$hsc_year , old('hsc_pass_year', session('inputs.hsc_pass_year')), array('class' => 'form-control') ) }}
                                {!! $errors->first('hsc_pass_year','<span class="help-block">:message</span>') !!}
                            </div>
                            {{-- HSC/Equivalent reg no --}}
                            {{--                             <div class="form-group col-sm-3 @if ($errors->has('hsc_regno')) has-error @endif">--}}
                            {{--                                <label for="input-id" class="control-label">Reg. No.</label>--}}
                            {{--                                {{ Form::text('hsc_regno', old('hsc_regno',session('inputs.hsc_regno')), array('class' => 'form-control', 'placeholder'=>'Reg. No.') ) }}--}}
                            {{--                                {!! $errors->first('hsc_regno','<span class="help-block">:message</span>')}}-- !!}
                            {{--                            </div> --}}

                            {{-- CGPA --}}
                            <div class="form-group col-sm-3 @if ($errors->has('hsc_gpa')) has-error @endif">
                                <label for="input" class="control-label">CGPA</label>
                                {{ Form::text('hsc_gpa', old('hsc_gpa', session('inputs.hsc_gpa')), array('class' => 'form-control','placeholder'=>"HSC GPA")) }}
                                {!! $errors->first('hsc_gpa','<span class="help-block">:message</span>') !!}
                            </div>

                        </div>
                        <br>
                        <legend>SSC/Equivalent</legend>
                        <div class="row">
                            {{-- SSC/Equivalent Roll --}}
                            <div class="form-group col-sm-3 @if ($errors->has('ssc_roll')) has-error @endif">
                                <label for="input" class="control-label">Roll</label>
                                {{ Form::text('ssc_roll', old('ssc_roll',session('inputs.ssc_roll')), array('class' => 'form-control','placeholder'=>"SSC Roll")) }}
                                {!! $errors->first('ssc_roll','<span class="help-block">:message</span>') !!}
                            </div>

                            {{-- SSC/Equivalent Board --}}
                            <div class="form-group col-sm-3 @if ($errors->has('ssc_board')) has-error @endif">
                                <label for="input-id" class="control-label">Board</label>
                                {{ Form::select('ssc_board', array(""=>'Please Select')+$ssc_board , old('ssc_board',session('inputs.ssc_board')), array('class' => 'form-control') ) }}
                                {!! $errors->first('ssc_board','<span class="help-block">:message</span>') !!}
                            </div>
                            {{-- SSC/Equivalent Year --}}
                            <div class="form-group col-sm-3 @if ($errors->has('ssc_pass_year')) has-error @endif">
                                <label for="input-id" class="control-label">Year</label>
                                {{ Form::select('ssc_pass_year', array(""=>'Please Select')+$ssc_year , old('ssc_pass_year', session('inputs.ssc_pass_year')), array('class' => 'form-control') ) }}
                                {!! $errors->first('ssc_pass_year','<span class="help-block">:message</span>') !!}
                            </div>

                            {{-- CGPA --}}
                            <div class="form-group col-sm-3 @if ($errors->has('ssc_gpa')) has-error @endif">
                                <label for="input" class="control-label">CGPA</label>
                                {{ Form::text('ssc_gpa', old('ssc_gpa', session('inputs.ssc_gpa')), array('class' => 'form-control','placeholder'=>"SSC GPA")) }}
                                {!! $errors->first('ssc_gpa','<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <br>
                        <legend>Personal Information</legend>
                        <div class="row form-horizontal">
                            <div class="col-sm-12">
                                {{-- name --}}
                                <div class="form-group @if ($errors->has('name')) has-error @endif">
                                    <label for="input-id" class="control-label col-sm-3">Candidate Name</label>
                                    <div class="col-sm-8">
                                        {{ Form::text('name', old('name', session('inputs.name')), array('class' => 'form-control','placeholder'=>"Candidate Name")) }}
                                        {!! $errors->first('name','<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                                {{-- father's name --}}
                                <div class="form-group @if ($errors->has('fname')) has-error @endif">
                                    <label for="input" class="control-label col-sm-3">Father's Name</label>
                                    <div class="col-sm-8">
                                        {{ Form::text('fname', old('fname', session('inputs.fname')), array('class' => 'form-control','placeholder'=>"Father's Name")) }}
                                        {!! $errors->first('fname','<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                                {{-- mother's name --}}
                                <div class="form-group @if ($errors->has('mname')) has-error @endif">
                                    <label for="input" class="control-label col-sm-3">Mother's Name</label>
                                    <div class="col-sm-8">
                                        {{ Form::text('mname', old('mname', session('inputs.mname')), array('class' => 'form-control','placeholder'=>"Mother's Name")) }}
                                        {!! $errors->first('mname','<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>

                                {{-- gender  --}}
                                <div class="form-group @if ($errors->has('sex')) has-error @endif">
                                    <label for="input" class="control-label col-sm-3">Gender</label>
                                    <div class="col-sm-8">
                                        <label class="radio-inline">
                                            {{ Form::radio('sex', 'MALE',old('sex', session('inputs.sex'))=='MALE') }}
                                            Male
                                        </label>
                                        <label class="radio-inline">
                                            {{ Form::radio('sex', 'FEMALE',old('sex', session('inputs.sex'))=='FEMALE') }}
                                            Female
                                        </label><br>
                                        {!! $errors->first('sex','<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>

                                {{-- dob --}}
                                <div class="form-group @if ($errors->has('dob')) has-error @endif">
                                    <label for="input" class="control-label col-sm-3">Date of Birth</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            {{ Form::text('dob', old('dob', session('inputs.dob')), array('class' => 'form-control datepicker','placeholder'=>"dd/mm/yyyy")) }}
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
                                            {{ Form::text('mobile_no', old('mobile_no', session('inputs.mobile_no')), array('class' => 'form-control','placeholder'=>"Mobile No.")) }}
                                        </div>
                                        {!! $errors->first('mobile_no','<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                                <hr>


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
                                    <label for="input-id" class="control-label col-sm-3">&nbsp;</label>
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
                                        {{Form::button('Submit <i class="fa fa-arrow-right"></i>', array('type' => 'submit', 'class' => 'btn btn-primary', 'id'=>'submit'))}}
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

    {{-- {{Html::style('assets/plugins/jQuery-File-Upload/css/jquery.fileupload.css')}} --}}
    <style type="text/css">
        .fileinput-button {
            position: relative;
            overflow: hidden;
        }

        .fileinput-item {
            position: absolute;
            font-size: 50px;
            opacity: 0;
            right: 0;
            top: 0;

        }
    </style>

@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
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
