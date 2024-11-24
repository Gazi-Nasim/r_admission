@extends('layouts.master_remote_capture', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')

    <div class="panel panel-default full-height">
        <div class="panel-body">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row">
                        <div id="d" class="col-md-8 col-md-offset-2">
                            <div class="panel panel-default">
                                <div class="panel-body text-center">
                                    <h1><i class="fa fa-check-circle fa-2x text-success"></i></h1>
                                    <p class="text-success" style="font-size: 1.5em">{{$name}} এর সেলফি আপলোড সম্পন্ন
                                        হয়েছে।</p>
                                    <p>আপনার অন্য ডিভাইস থেকে বাকি কাজ সম্পন্ন করুন</p>
                                    <div class="text-center">
                                        <p>
                                            {{ Html::image('storage/uploads/'.$selfie, 'Photo', ['class'=>'img-responsive img-thumbnail']) }}
                                        </p>

                                        <hr>
                                        <a class="btn btn-danger" href="{{route('site.home')}}"> <i
                                                class="fa fa-sign-out"></i> Close</a>

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

