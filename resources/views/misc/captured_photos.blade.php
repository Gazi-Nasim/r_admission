@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><i class="fa fa-check-square"></i> Captured Photo</legend>

            {{-- result --}}
            <div class="row">
                <div class="col-sm-12" id="result">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>RoLL</th>
                                <th>time</th>
                                <th>Photo</th>
                                <th>Selfie</th>
                                <th>Suspected</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $today = today()->addHours(8);
                            @endphp
                            @foreach ($applications as $application)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$application->unit}}-{{$application->admission_roll}}</td>
                                    <td>
                                        {{$application->exam_time}}
                                    </td>
                                    <td>
                                        <img id="img" src="{{Storage::url('public/uploads/'.$application->student->photo)}}?{{rand()}}"
                                             width="100"
                                             @class(['img-responsive',
                                                    'img-thumbnail',
                                                    'center-block',
                                                    'rejected' => $application->student->photo_status == 'R',
                                                    'accepted' => $application->student->photo_status == 'A'
                                                    ])
                                             alt="Image">

                                    </td>
                                    <td>
                                        <img id="img" src="{{Storage::url('public/uploads/'.$application->student->selfie)}}?{{rand()}}"
                                             width="100"
                                             loading="lazy"
                                             @class(['img-responsive',
                                                    'img-thumbnail',
                                                    'center-block',
                                                    'rejected' => $application->student->selfie_status == 'R',
                                                    'accepted' => $application->student->selfie_status == 'A'
                                                    ])
                                             alt="Image">
                                        </td>
                                    <td>
                                        <img id="img" src="{{Storage::url('public/uploads/'.$application->student->suspect_photo)}}?{{rand()}}"
                                             width="100"
                                             loading="lazy"
                                             @class(['img-responsive',
                                                    'img-thumbnail',
                                                    'center-block',
                                                    ])
                                             alt="Image">
                                    </td>
                                    <td>
                                        <a class="btn  btn-primary" target="_blank" href="{{route('admin.student.show',$application->student->id)}}"><i class="fa fa-user"></i> </a>
                                    </td>
                                    <td>
                                        @if($application->student->updated_at->gte($today))
                                            <i class="fa fa-check-square fa-2x text-success"></i>
                                        @else
                                            <i class="fa fa-square-o fa-2x text-success"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
@stop

