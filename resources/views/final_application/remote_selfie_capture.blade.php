@extends('layouts.master_remote_capture', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')

    <div class="panel panel-default full-height">
        <div class="panel-body">
            <legend><i class="fa fa-picture-o"></i> Remote Selfie Capture</legend>

            <div class="alert alert-info">
                <p>
                    ক্যামেরা চালু হলে ক্যামেরার দিকে স্থির ভাবে তাকিয়ে কিছুক্ষণ অপেক্ষা করুন। ভিডিওতে আপনার মুখের
                    চারপাশে একটি <b>নীল বক্স</b> দেখা গেলে <u>"বাংলাদেশ"</u> শব্দটি উচ্চারণ করুন। স্বয়ংক্রিয়ভাবে আপনার ছবি তোলা হবে।
                    ছবিটি ঠিক থাকলে "Save" বাটনে চাপ দিয়ে সেলফি আপলোড সম্পন্ন করুন। অন্যথায় "Retake" বাটনে চাপ দিয়ে পুনরায়
                    ছবি তুলুন।</p>
            </div>
            <div class="row">
                <div id="d" class="col-xs-12 col-md-8 col-md-offset-2"  style="position:relative;">
                    {{--No camera--}}
                    <div  id="no-camera" style="display:none">
                        <div class="panel-body text-center">
                            <h1>No camera found</h1>
                            <p>This process requires a camera to be available.</p>
                            <p>Please scan the QR code with your phone to continue.</p>
                            <div class="text-center">
                                        <span class="img-thumbnail" style="display: inline-block">
                                            {!!DNS2D::getBarcodeSVG($tempUrl, 'QRCODE',4,4, '#000080')!!}
                                        </span>
                                <br><br>
                                <a id="tempUrl" class="btn btn-default" href="{{$tempUrl}}"> <i
                                        class="fa fa-copy"></i> Copy URL</a>
                                <script defer>

                                    document.getElementById("tempUrl").addEventListener("click", function (event) {
                                        event.preventDefault();

                                        var hrefValue = this.getAttribute('href');
                                        var tempInput = document.createElement('input');
                                        tempInput.value = hrefValue;

                                        // Append the input element to the document
                                        document.body.appendChild(tempInput);

                                        // Select the value inside the input element
                                        tempInput.select();

                                        // Execute the "copy" command
                                        navigator.clipboard.writeText(tempInput.value);

                                        // Remove the temporary input element
                                        document.body.removeChild(tempInput);

                                        // Optionally, provide user feedback
                                        this.innerHTML = '<i class="fa fa-check-circle"></i> Copied';
                                        this.setAttribute('href', '#');
                                        this.removeEventListener('click', arguments.callee)

                                    });
                                </script>


                            </div>
                        </div>
                    </div>
                    {{--/No camera--}}
                    <div id="loading" class="panel panel-default"  style="display: flex; align-items: center; justify-content: center ;min-height: 300px" >
                        <p class="text-center lead"><i class="fa fa-spinner fa-spin"></i> Loading Camera... Please wait</p>
                    </div>

                    <video id="video"  style="position: absolute;" autoplay muted playsinline></video>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="my-modal" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-camera"></i> Capture Photo</h4>
                </div>
                <div class="modal-body text-center" id="modal-body">
                    <canvas id="face-preview" width="300" height="400" style="border: 1px solid green"></canvas>
                </div>
                <div class="modal-footer" id="modal-footer">
                    <a class="btn btn-danger" href="{{ route('remoteCaptureError') }}"><i
                            class="fa fa-times"></i> Cancel</a>
                    <button type="button" class="btn btn-success" data-dismiss="modal" onblur="reCapture()">
                        <i class="fa fa-camera"></i> Retake
                    </button>

                    <button type="button" class="btn btn-primary" id="save-button" >
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
    {{Html::script('assets/plugins/face-api/capture-script2.js')}}
    <script>

        {{--$(document).ready(function () {--}}
        {{--    initCaptureScript('{{route('remoteCaptureComplete')}}');--}}
        {{--});--}}

        function reCapture() {
           document.getElementById('box').getContext('2d').clearRect(0, 0, 520, 400);
           startVideo();
        }
        
    </script>
@stop




