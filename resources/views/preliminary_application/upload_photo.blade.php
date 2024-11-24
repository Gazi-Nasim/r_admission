@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')

    <div class="panel panel-default">
        <div class="panel-body">
            {{-- Photo --}}
            <legend><i class="fa fa-picture-o"></i> ফটো আপলোড</legend>
            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                   {{-- <pre>
                        {{print_r(session()->all())}}
                    </pre>--}}

                    <div class="alert alert-info">
                        <p>
                            <span class="label label-primary"> <i class="fa fa-upload"></i> Upload/Change Photo</span>
                            তে ক্লিক করে আপনার ছবিটি আপলোড করতে হবে।
                            আপলোডকৃত ছবি Photo Preview- তে দেখা যাবে।</p>
                        <p>প্রয়োজনে <span class="label label-primary"> <i
                                    class="fa fa-upload"></i> Upload/Change Photo</span> তে ক্লিক করে ছবি
                            পুনরায় আপলোড করা যাবে।</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6" style="border-right: 1px solid #ddd">
                            @if (Session::has('photo-message'))
                                <div class="alert alert-danger">
                                    <strong><i class="fa fa-exclamation-circle"></i> {{Session::get('photo-message')}}
                                    </strong>
                                </div>
                            @endif

                            {{--<pre>
                                {{print_r(Session::all())}}
                            </pre>--}}

                            <p class="text-center" id="uploaded-photo">
                                @if (Session::has('inputs.photo'))
                                    {{ Html::image('storage/uploads/'.Session::get('inputs.photo'), 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>150)) }}
                                @elseif (Session::has('inputs.tmp_photo'))
                                    {{ Html::image('storage/uploads/bill-photos/'.Session::get('inputs.tmp_photo'), 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>150)) }}
                                @else
                                    {{ Html::image('assets/img/Profile1.jpg', 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>150)) }}
                                @endif
                                <br> <span class="label label-default">Photo Preview</span>
                            </p>

                            <p class="text-center"><i id="indicator" class="fa fa-spinner fa-spin"
                                                      style="display:none"></i></p>
                            @if($hasUnpaidBill || session('authorize_this_session',0))
                                <form method="POST"
                                      ic-trigger-on='change'
                                      ic-target='#uploaded-photo'
                                      ic-on-complete="$('#save').removeAttr('disabled');"
                                      enctype="multipart/form-data"
                                      ic-post-to="{{ route('preliminary.postUploadStudentPhoto') }}"
                                      ic-indicator="#indicator">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
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
                            @else
                                <p class="text-center">
                                    <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
                                    <input type="hidden" id="route" name="route" value="{{route('preliminary.getUploadStudentPhoto')}}">

                                    <a class="btn btn-danger" data-toggle="modal" href='#modal-id'><i class="fa fa-lock"></i> Upload/Change Photo</a>
                                </p>

                                {{--modal--}}
                                @include('preliminary_application.verification_popup')


                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-info-circle"></i> Photo Requirements</h3>
                                </div>
                                <div class="panel-body">
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-asterisk"></i> ছবিটি 300x400 পিক্সেল আকারের হবে।</li>
                                        <li><i class="fa fa-asterisk"></i> ছবির ব্যাকগ্রাউন্ড সাদা রঙের হতে হবে।</li>
                                        <li><i class="fa fa-asterisk"></i> ছবির সাইজ 100 কিলোবাইটের বেশি হতে পারবে না।</li>
                                        <li><i class="fa fa-asterisk"></i> স্কুল/কলেজের ইউনিফর্ম পরিহিত ছবি গ্রহণযোগ্য হবে না।</li>
                                        <li class="text-danger"><b><i class="fa fa-asterisk"></i> প্রাথমিক আবেদনকালে প্রদত্ত ছবিটির বায়োমেট্রিক ভেরিফিকেশন করা হবে</b></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>

            {{-- Submit  --}}
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    {{Form::open(['route'=>'preliminary.saveStudentPhoto','id'=>'form'])}}
                    {{-- <input type="hidden" name="mobile_no" value="{{$student->mobile_no}}"> --}}
                    <p class="text-right">

                        @if ($student->photo)
                            <a class="btn btn-warning" href="{{ route('student.getDashboard') }}"><i
                                    class="fa fa-arrow-left"></i> Back</a>
                        @endif
                            <button class="btn btn-primary" id="save" disabled> @if($student->photo)<i class="fa fa-floppy-o"></i>  Save Photo @else Next <i class="fa fa-arrow-right"></i>  @endif

                        </button>
                            <a class="btn btn-danger" href="{{ route('student.getDashboard') }}" role="button">Cancel <i
                                    class="fa fa-times"></i></a>

                    </p>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>{{-- panel-default --}}
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
