@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default full-height">
        <div class="panel-body">
            <legend><i class="fa fa-users"></i> Student</legend>
            <p>
                <a class="btn btn-primary" href="{{ route('admin.student.show',$student_data->id) }}" role="button"> <i
                        class="fa fa-arrow-left"></i> Back</a>

            </p>

            <div class="row">
                <div class="col-sm-12">
                    {{-- registration Information --}}
                    <div class="form-section well">
                        <legend>Photo Upload</legend>
                        <div class="row form-horizontal">
                            <div class="col-sm-12">
                                {{-- image placeholder --}}
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <p class="text-center" id="uploaded-photo-registration">
                                            {{-- <img id="img" src="{{url('uploads/'.$student_data->photo)}}" width="200" class="img-responsive img-thumbnail center-block" alt="Image"> --}}
                                            {{ Html::image(Storage::url('public/uploads/'.$student_data->photo), 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>200)) }}
                                            <br>Current Photo
                                        </p>
                                    </div>

                                    <div class="col-sm-6">
                                        <p class="text-center" id="uploaded-photo-student">
                                            @if (Session::has('photo.student'))
                                                {{ Html::image(Storage::url('public/uploads/photo-changes/'.Session::get('photo.student')), 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>200)) }}
                                            @else
                                                {{ Html::image('assets/img/photo_placeholder.jpg', 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>200)) }}
                                            @endif
                                            <br>(300x400 Photo)
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group @if ($errors->has('photo_registration')) has-error @endif">
                                    {{-- <label for="input" class="control-label col-sm-3"></label> --}}

                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-6">{{-- phot student	 --}}
                                        <form method="POST"
                                              ic-trigger-on='change'
                                              ic-target='#uploaded-photo-student'
                                              enctype="multipart/form-data"
                                              ic-post-to="{{ route('admin.student.saveStudentPhoto') }}"
                                              ic-indicator="#indicator">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <input type="hidden" name="student_id" value="{{$student_data->id}}">
                                            <p class="error text-danger"></p>

                                            <p class="text-center">
                                                <!-- The fileinput-button span is used to style the file input field as button -->
                                                <span class="btn btn-primary fileinput-button">
                                                    <input
                                                        id="fileupload"
                                                        class="fileinput-item"
                                                        type="file"
                                                        name="photo"
                                                    >
                                                    <i class="fa fa-upload"></i>
                                                    <span>Upload/Change Photo</span>
                                                    <!-- The file input field used as target for the file upload widget -->
                                                </span>
                                            </p>
                                        </form>
                                    </div> {{-- photo student --}}

                                </div>

                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="input-id" class="control-label col-sm-4"></label>
                                    <div class="col-sm-8 text-right">

                                       <form method="POST" action="{{ route('admin.student.updateStudentPhoto')}}">
                                        @csrf
                                           <input type="hidden" name="student_id" value="{{$student_data->id}}">
                                           <a class="btn btn-danger"
                                              href="{{ route('admin.student.show',$student_data->id) }}" role="button"><i
                                                   class="fa fa-times"></i> Cancel</a>
                                        <button type="submit" id="submit" class="btn btn-success"
                                                onclick="return confirm('Are you sure?')">
                                            <i class="fa fa-save"></i> Update Photo
                                        </button>
                                       </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('css-extra')
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


