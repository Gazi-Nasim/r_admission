@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')

    <div class="panel panel-default full-height">
        <div class="panel-body">
            <legend><i class="fa fa-camera"></i> সেলফি আপলোড</legend>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <div class="alert alert-info">
                        <p style="line-height: 1.5em; font-size: 1.2em">
                            <span class="label label-primary" style="display: inline-block"> <i class="fa fa-video-camera"></i> Capture/Change Selfie</span>
                            তে ক্লিক করে আপনার এই ডিভাইসের ক্যামেরা দিয়ে সেলফি তুলুন। এই ডিভাইসে ক্যামেরা না থাকলে
                            <span class="label label-primary" style="display: inline-block"> <i class="fa fa-qrcode"></i> Capture with another device</span>
                            এ ক্লিক দিয়ে পরবর্তী পেজে প্রদর্শিত QR কোডটি অন্য কম্পিউটার (ওয়েবক্যাম যুক্ত) /স্মার্ট ফোনের ক্যামেরা দিয়ে
                            স্ক্যান করে সেখান থেকে সেলফি তুলুন। <b>সেলফির মাধ্যমে প্রদত্ত ফটোটি পরবর্তীতে আবেদনকারীর বায়োমেট্রিক ভেরিফিকেশনে ব্যবহৃত হবে।</b>
                        </p>
                    </div>

                    @if( session()->has('inputs.units') &&  $student->selfie!=null )
                        <div class="alert alert-warning lead">
                            <i class="fa fa-exclamation-circle"></i> আপনার বর্তমান সেলফি পরিবর্তন করতে না চাইলে "Next" বাটনে
                            ক্লিক করে পরবর্তী ধাপে যান

                        </div>
                    @endif

                    <div class="row">

                        <div class="col-sm-6" style="border-right: 1px solid #ddd">

                            <p class="text-center" id="uploaded-photo">
                                @if ($student->photo)
                                    {{ Html::image('storage/uploads/'.$student->photo, 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>180)) }}
                                @else
                                    {{ Html::image('assets/img/Profile1.jpg', 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>180)) }}
                                @endif
                                <br> <span class="label label-default">Photo Preview</span>
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <p class="text-center" id="uploaded-photo">
                                @if ($student->selfie)
                                    {{ Html::image('storage/uploads/'.$student->selfie, 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>180)) }}
                                @else
                                    {{ Html::image('assets/img/Selfie.jpg', 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>180)) }}
                                @endif
                                <br> <span class="label label-default">Selfie Preview</span>
                            </p>

                            @if(session('authorize_this_session',0))
                                <div class="text-center">
                                    <a class="btn btn-primary" href="{{route('getSelfieCapture')}}"><i
                                            class="fa fa-video-camera"></i> Capture/Change Selfie</a> <br>
                                    <a class="btn btn-primary" style="margin-top: 10px"
                                       href="{{route('getSelfieQR')}}"><i class="fa fa-qrcode"></i>
                                        Capture with another device</a>
                                </div>
                            @else
                                <div class="text-center">
                                    <a class="btn btn-primary" href="{{route('getSelfieCapture')}}"><i
                                            class="fa fa-video-camera"></i> Capture/Change Selfie</a> <br>
                                    <a class="btn btn-primary" style="margin-top: 10px"
                                       href="{{route('getSelfieQR')}}"><i class="fa fa-qrcode"></i>
                                        Capture with another device</a>
                                </div>
                                {{--                                <p class="text-center">--}}
                                {{--                                    <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">--}}
                                {{--                                    <input type="hidden" id="route" name="route"--}}
                                {{--                                           value="{{route('getSelfieCapture')}}">--}}

                                {{--                                    <a class="btn btn-danger" data-toggle="modal" href='#modal-id'><i--}}
                                {{--                                            class="fa fa-lock"></i> Capture/Change Selfie</a>--}}
                                {{--                                </p>--}}
                            @endif

                            {{--modal--}}
                            @include('preliminary_application.verification_popup')

                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-12">
                            <p class="text-right">
                                <a class="btn btn-primary" href="{{route('student.getDashboard')}}"> <i
                                        class="fa fa-arrow-right"></i> Next</a>
                                @if( session()->has('inputs.units') )

                                    @if($student->photo && $student->selfie)
                                        <a class="btn btn-primary"
                                           href="{{route('getConfirmation')}}">Next
                                            <i class="fa fa-arrow-right"></i> </a>
                                    @else
                                        <a id="alert" class="btn btn-primary" href="#">Next
                                            <i class="fa fa-arrow-right"></i> </a>
                                        <script>
                                            document.getElementById("alert").addEventListener("click", function (event) {
                                                event.preventDefault();
                                                alert('Please capture your selfie first.');
                                            });
                                        </script>
                                    @endif
                                @endif
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
@stop
