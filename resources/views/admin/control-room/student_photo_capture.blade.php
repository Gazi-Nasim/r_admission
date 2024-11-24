@extends('layouts.master_remote_capture', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')

    <div class="panel panel-default full-height">
        <div class="panel-body">
            <legend>
                <i class="fa fa-picture-o"></i> Photo Capture
                <a class="btn btn-xs btn-danger pull-right"  href="{{route('controlRoom.getStudentInfo')}}" >
                    <i class="fa fa-arrow-left "></i> Back
                </a>
            </legend>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row">
                        <div id="d" class="col-xs-12 col-md-8 col-md-offset-2" style="position:relative;">
                            <div id="loading" class="panel panel-default"
                                 style="display: flex; align-items: center; justify-content: center ;min-height: 300px">
                                <p class="text-center lead"><i class="fa fa-spinner fa-spin"></i> Loading Camera...
                                    Please wait</p>
                            </div>
                            <video id="video" width="520" height="400" style="position: absolute" autoplay muted
                                   playsinline></video>

                            <p class="text-center">
                                <button id="captureButton" type="button" class="btn btn-primary btn-lg" style="z-index: 1200">
                                    <i class="fa fa-camera"></i> Capture Photo
                                </button>
                            </p>
                        </div>

                    </div>

                </div>
            </div>


        </div>
    </div>

    <div class="modal fade" id="my-modal" data-backdrop="static" style="z-index: 10000">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-camera"></i> Capture Photo</h4>
                </div>
                <div class="modal-body text-center" id="modal-body">
                    <canvas id="face-preview" width="300" height="400" style="border: 1px solid green"></canvas>
                </div>
                <div class="modal-footer" id="modal-footer">
                    <a class="btn btn-danger" href="{{ route('controlRoom.getStudentInfo') }}"><i
                            class="fa fa-times"></i> Cancel</a>
                    <button type="button" class="btn btn-success" data-dismiss="modal" onblur="reCapture()">
                        <i class="fa fa-camera"></i> Retake
                    </button>

                    <button type="button" class="btn btn-primary" id="save-button">
                        <i class="fa fa-save"></i> Save
                    </button>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('css-extra')
    <meta name="csrf-token" content="{{csrf_token()}}">
@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
    {{Html::script('assets/plugins/face-api/face-api.min.js')}}
    {{Html::script('assets/plugins/face-api/capture-script3.js')}}
    <script defer>

        $(document).ready(function () {

            {{--let intervalId = null;--}}

            {{--function pollUpload() {--}}
            {{--    fetch('{{route('final_application.pollSelfieUploaded',$student->updated_at)}}')--}}
            {{--        .then(response => response.json())--}}
            {{--        .then(data => {--}}
            {{--            console.log(data);--}}
            {{--            if (data.uploaded === 'true') {--}}
            {{--                clearInterval(intervalId);--}}
            {{--                window.location.href = data.redirect;--}}
            {{--            }--}}
            {{--        })--}}
            {{--        .catch(error => console.error('Error fetching data:', error));--}}
            {{--}--}}

            {{--// Set up polling every 5 seconds (adjust the interval as needed)--}}
            {{--const pollInterval = 2000; // 5 seconds in milliseconds--}}
            {{--intervalId = setInterval(pollUpload, pollInterval);--}}
            {{--initCaptureScript('{{route('final_application.getSelfieIndex')}}');--}}



        });


        function reCapture() {
            document.getElementById('box').getContext('2d').clearRect(0, 0, 520, 400);
            startVideo();
        }

    </script>

@stop
