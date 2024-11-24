@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><i class="fa fa-photo"></i> ফটো পরিবর্তন আবেদন ফরম</legend>

{{--            <pre>--}}
{{--                {{print_r(Session::all())}}--}}
{{--            </pre>--}}

            <blockquote class="alert-warning">
                <strong> আবেদনকারী একাধিক ইউনিটে ভর্তির আবেদন করলেও ফটো পরিবর্তন একবার করাই যথেষ্ঠ।</strong>
            </blockquote>

            @if (Session::has('error'))
                <blockquote class="alert-danger">
                    <strong> <i class="fa fa-exclamation-triangle"></i> {{Session::get('error')}}</strong>
                </blockquote>
            @endif

            {{-- image placeholder --}}
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">{{-- hsc photo --}}
                    <p class="text-center" id="uploaded-photo-ssc">
                        @if (Session::has('photo.registration'))
                            {{ Html::image(Storage::url('public/uploads/photo-changes/'.session('photo.registration')), 'Photo', ['class'=>'img-responsive img-thumbnail', 'width'=>250]) }}
                        @else
                            {{ Html::image('assets/img/regcard_placeholder.jpg', 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>250)) }}
                        @endif
                    </p>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">{{-- ssc photo --}}
                    <p class="text-center" id="uploaded-photo-hsc">
                        @if (Session::has('photo.student'))
                            {{ Html::image(Storage::url('public/uploads/photo-changes/'.session('photo.student')), 'Photo', ['class'=>'img-responsive img-thumbnail', 'width'=>250]) }}
                        @else
                            {{ Html::image('assets/img/photo_placeholder.jpg', 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>250)) }}
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
                          ic-post-to="{{ route('photo_change.postUploadFile','ID-CARD') }}"
                          ic-indicator="#indicator-ssc">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        <p class="text-center">
                            <!-- The fileinput-button span is used to style the file input field as button -->
                            <span class="btn btn-primary fileinput-button">
                            <input
                                id="fileupload"
                                class="fileinput-item"
                                type="file"
                                name="photo_registration"
                            >
                            <i class="fa fa-plus-circle"></i>
                            <span>Upload/Change HSC Equivalent Reg. Card</span>
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
                          ic-post-to="{{ route('photo_change.postUploadFile','PHOTO') }}"
                          ic-indicator="#indicator-hsc">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        <p class="text-center">
                            <!-- The fileinput-button span is used to style the file input field as button -->
                            <span class="btn btn-primary fileinput-button">
                            <input
                                id="fileupload"
                                class="fileinput-item"
                                type="file"
                                name="photo_student"
                            >
                            <i class="fa fa-plus-circle"></i>
                            <span>Upload/Change New Photo</span>
                                <!-- The file input field used as target for the file upload widget -->
                        </span>
                        </p>
                    </form>
                    {{-- /new upload  --}}
                </div> {{-- phot hsc --}}
            </div>
            {{-- /upload forms  --}}


            {{Form::open(array('route' => array('photo_change.store'),'files'=>'true'))}}

            {{-- captcha --}}
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="alert alert-warning text-center">নিচের ছবিতে প্রদর্শিত ইংরেজী লেখাটি পাশের টেক্সটবক্সে
                        হুবহু লিখুন। </h4><br>
                    <div class="form-group  @if ($errors->has('captcha')) has-error @endif">
                        <label for="input-id" class="control-label col-sm-3">Input text shown in the
                            image. </label>
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
                            {{Form::button('<i class="fa fa-check"></i> Submit Photo', array('type' => 'submit', 'class' => 'btn btn-primary', 'id'=>'submit'))}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{Form::close()}}

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
