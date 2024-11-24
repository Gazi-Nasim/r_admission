@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><i class="fa fa-photo"></i> মোবাইল নম্বর পরিবর্তনের আবেদন</legend>

            <div class="alert alert-info">
                <p>মোবাইল নম্বরটি পরিবর্তনের জন্য নিচের তথ্যাদি প্রদান করতে হবে।</p>
            </div>


            @if (Session::has('error'))
                <blockquote class="alert-danger">
                    <strong> <i class="fa fa-exclamation-triangle"></i> {{Session::get('error')}}</strong>
                </blockquote>
            @endif

            <div class="row">
                <div class="col-sm-12">
                    {{-- registration Information --}}
                    <div class="form-section well">
                        <legend class="text-center">Upload Document (HSC Reg. Card/NID)</legend>
                        <div class="row form-horizontal">
                            {{-- image placeholder --}}
                            <div class="col-sm-6 col-sm-offset-3">{{-- hsc photo --}}
                                <p class="text-center" id="uploaded-photo-hsc">
                                    @if (Session::has('photo.photo_1'))
                                        {{ Html::image(Storage::url('public/uploads/mobile-change/'.session('photo.photo_1')), 'Photo', ['class'=>'img-responsive img-thumbnail', 'width'=>250]) }}
                                    @else
                                        {{ Html::image('assets/img/mobile_change_placeholder.jpg', 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>250)) }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">

                                <div class="form-group">
                                    <div class="col-sm-12">{{-- ssc photo upload from --}}
                                        {{-- new upload --}}
                                        <p class="error text-danger"></p>

                                        <p class="text-center" id="indicator-ssc" style="display:none"><i
                                                class="fa fa-spinner fa-spin"></i>
                                            Please wait for upload to finish</p>
                                        <form method="POST"
                                              ic-trigger-on='change'
                                              ic-target='#uploaded-photo-hsc'
                                              enctype="multipart/form-data"
                                              ic-post-to="{{ route('mobile_change.uploadPhoto','PHOTO') }}"
                                              ic-indicator="#indicator-ssc">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">

                                            <p class="text-center">
                                                <!-- The fileinput-button span is used to style the file input field as button -->
                                                <span class="btn btn-primary fileinput-button">
                                                    <input
                                                        id="fileupload"
                                                        class="fileinput-item"
                                                        type="file"
                                                        name="photo_1"
                                                    >
                                                    <i class="fa fa-plus-circle"></i>
                                                    <span>Upload/Change Document</span>
                                                </span>
                                            </p>
                                        </form>
                                        {{-- /new upload --}}
                                    </div>{{-- photo-ssc --}}

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                {{Form::open( ['route'=>'mobile_change.saveMobileChangeRequest'])}}
                                {{-- hsc Information --}}
                                <div class="">
                                    <br>
                                    <legend class="text-center">Personal Information</legend>
                                    <div class="row form-horizontal">
                                        <div class="col-sm-12">

                                            {{-- Mobile No --}}
                                            <div class="form-group @if ($errors->has('mobile_no')) has-error @endif">
                                                <label for="input" class="control-label col-sm-3">New Mobile No</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1"><b>+88</b></span>
                                                        {{ Form::text('mobile_no', old('mobile_no', session('inputs.mobile_no')), array('class' => 'form-control','placeholder'=>"New Mobile No.")) }}
                                                    </div>
                                                    {!! $errors->first('mobile_no','<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>

                                            {{-- name --}}
                                            <div class="form-group @if ($errors->has('reason')) has-error @endif">
                                                <label for="input-id" class="control-label col-sm-3">Reason for Change</label>
                                                <div class="col-sm-8">
                                                    {{ Form::textarea('reason', old('reason', session('inputs.reason')), array('class' => 'form-control','placeholder'=>"Reason for Change")) }}
                                                    {!! $errors->first('reason','<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input-id" class="control-label col-sm-3"></label>
                                                <div class="col-sm-8">
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
                                                    <a href="{{route('student.getDashboard')}}" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
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
@stop
