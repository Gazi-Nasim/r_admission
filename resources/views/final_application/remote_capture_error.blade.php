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
                                    <h1><i class="fa fa-times-circle fa-2x text-danger"></i></h1>
                                    <p class="text-danger" style="font-size: 1.3em">সেলফি আপলোড প্রক্রিয়া সম্পন্ন হয়নি</p>
                                    <p class="text-danger">পুনরায় চেষ্টা করুন</p>
                                    <div class="text-center">
                                        <p>
                                            {{ Html::image('assets/img/Profile1.jpg', 'Photo', ['class'=>'img-responsive img-thumbnail']) }}
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

