@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default full-height">
        <div class="panel-body">
            <legend>
                <i class="fa fa-picture-o"></i> Student Details
                <a href="{{route('controlRoom.getDashboard')}}" class="btn btn-danger btn-xs pull-right">
                    <i class="fa fa-home"></i> Back</a>
            </legend>

            <div class="row">
                <div id="d" class="col-xs-12 col-md-8 col-md-offset-2">
                    <table class="table ">
                        <tr>
                            <th width="30%">Applicant ID</th>
                            <td>{{$student->id}}</td>
                        </tr>
                        <tr>
                            <th width="30%">Name</th>
                            <td>{{$student->NAME}}</td>
                        </tr>

                        <tr>
                            <th width="30%">Exams</th>
                            <td>
                                @foreach($applications as $unit=>$roll)
                                    Unit {{$unit}}: <b>{{$roll}}</b><br>
                                @endforeach
                            </td>
                        </tr>

                        <tr class="bg-info">
                            <th width="50%" class="text-center">Photo</th>
                            <th width="50%" class="text-center">Selfie</th>
                        </tr>


                        <tr>
                            <td>
                                @if ($student->photo)
                                    <img  @class(['img-responsive',
                                    'img-thumbnail',
                                    'center-block',
                                    'rejected' => $student->photo_status == 'R',
                                    'accepted' => $student->photo_status == 'A'
                                    ])
                                          src="{{Storage::url('public/uploads/'.$student->photo)}}?{{rand()}}"/>
                                @else
                                    <img class="img-responsive img-thumbnail center-block" src="{{asset('assets/img/no_image.jpg')}}"/>
                                @endif
                            </td>
                            <td>
                                @if ($student->selfie)
                                    <img  @class(['img-responsive',
                                    'img-thumbnail',
                                    'center-block',
                                    'rejected' => $student->selfie_status == 'R',
                                    'accepted' => $student->selfie_status == 'A'
                                    ])
                                          src="{{Storage::url('public/uploads/'.$student->selfie)}}?{{rand()}}"/>
                                @else
                                    <img class="img-responsive img-thumbnail center-block" src="{{asset('assets/img/Selfie.jpg')}}"/>
                                @endif
                            </td>
                        </tr>
                        @if ($student->suspect_photo)
                        <tr>
                            <td colspan="2" class="text-center">
                                    <img  @class(['img-responsive',
                                    'img-thumbnail',
                                    'center-block',
                                    ])
                                          src="{{Storage::url('public/uploads/'.$student->suspect_photo)}}?{{rand()}}"/>

                                <p class="text-danger"><b>Suspected Photo</b></p>
                            </td>
                        </tr>
                        @endif

                        <tr>
                            <th colspan="2" class="text-center">
                                <a class="btn btn-primary" href="{{route('controlRoom.getStudentPhotoCapture')}}">
                                    <i class="fa fa-camera"></i> Capture Photo
                                </a>
                            </th>
                        </tr>

                    </table>
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
@stop
