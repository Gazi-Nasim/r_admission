@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')

    <div class="panel panel-default full-height">
        <div class="panel-body">
            <legend><i class="fa fa-picture-o"></i> Selfie Capture</legend>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row">
                        <div id="d" class="col-md-8 col-md-offset-2">
                            <div class="panel panel-default">
                                <div class="panel-body text-center">
                                    <h1 class="text-primary">QR কোড স্ক্যান করুন</h1>
                                    <p style="font-size: 1.2em"> নিচের QR কোডটি স্ক্যান করে প্রাপ্ত URL লিঙ্কটি আপনার
                                        ফ্রন্ট ক্যামেরা যুক্ত মোবাইল ফোনের ব্রাউজারে ওপেন করুন।  <u class="text-warning"> অথবা, নিচের "Copy URL" বাটনে ক্লিক করে লিঙ্কটি কপি করে অন্য ডিভাইস থেকেও সেলফি সাবমিট করতে পারবেন।</u>
                                    </p>

                                    <div class="text-center">
                                        <span class="img-thumbnail" style="display: inline-block">
                                            {!!DNS2D::getBarcodeSVG($tempUrl, 'QRCODE',4,4, '#021a2e')!!}
                                        </span>
                                        <br><br>
                                        <a id="tempUrl" class="btn btn-default" href="{{$tempUrl}}"> <i
                                                class="fa fa-copy"></i> Copy URL</a>
                                        <br>
                                        <br>
                                        <p class="alert alert-danger"><b>এই পেজটি বন্ধ করবেন না। অন্য ডিভাইসে সেলফি তুলে
                                                সাবমিট করলে পেজটি স্বয়ংক্রিয় ভাবে আপডেট হবে</b></p>
                                        <hr>
                                        <a id="tempUrl" class="btn btn-danger pull-right"
                                           href="{{route('getSelfieIndex')}}"> <i
                                                class="fa fa-times"></i> Cancel</a>

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
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
    <script defer>

        $(document).ready(function () {

            let intervalId = null;

            function pollUpload() {
                fetch('{{route('pollSelfieUploaded',$student->updated_at)}}')
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        if (data.uploaded === 'true') {
                            clearInterval(intervalId);
                            window.location.href = data.redirect;
                        }
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            // Set up polling every 5 seconds (adjust the interval as needed)
            //randomize the interval so that all users don't hit the server at the same time
            const pollInterval = Math.floor(Math.random() * 7000) + 5000;
            // console.log('Polling every ' + pollInterval + 'ms');

            intervalId = setInterval(pollUpload, pollInterval);

        });

    </script>

@stop
