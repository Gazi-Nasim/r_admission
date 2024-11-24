@if (count((array)$application))
    <div class="col-lg-8">
        <legend>Admission Seat info</legend>
        <div class="table-responsive">

            <table class="table table-striped table-bordered table-condensed">
                <tbody>
                <tr>
                    <th width="20%">Exam Roll</th>
                    <td>{{$application->unit}} - {{$application->admission_roll}}</td>
                </tr>
                <tr>
                    <th>
                        Applicant Name
                    </th>
                    <td>
                        {{$application->name}}
                        <a target="_blank" class="btn btn-xs btn-info"
                           href="{{ route('admin.student.show', $application->applicant_id)}}"><i
                                class="fa fa-user"></i>
                            Applicant Details</a>

                        <a target="_blank" class="btn btn-xs btn-success"
                           href="{{ route('admin.student.getDownloadAdmitCard', $application)}}"><i
                                class="fa fa-download"></i>
                            Admit Card</a>

                        @if ($application->subjectOption  && $application->subjectOption?->choices?->count())
                            <a target="_blank" class="btn btn-xs btn-primary"
                               href="{{route('admin.student.showSubjectOption',$application->subjectOption->id) }}"><i
                                    class="fa fa-eye"></i>Subject Choices</a>
                        @endif

                        @if ($application->subjectOption  && $application->subjectOption?->admission_completed)
                            <a target="_blank" class="btn btn-xs btn-primary"
                               href="{{route('admin.student.showHonsAdmissionForm',$application->subjectOption->id) }}"><i
                                    class="fa fa-eye"></i>Admission Form</a>
                        @endif

                    </td>
                </tr>
                <tr>
                    <th>MNAME</th>
                    <td>{{$application->mname}}</td>
                </tr>
                <tr>
                    <th>FNAME</th>
                    <td>{{$application->fname}}</td>
                </tr>
                @role('Admin')
                <tr>
                    <th>Mobile No</th>
                    <td>{{$application->mobile_no}}</td>
                </tr>
                @endrole
                <tr>
                    <th>Applicant ID</th>
                    <td>{{$application->applicant_id}}</td>
                </tr>
                <tr>
                    <th>Exam Location</th>
                    <td>
                        <b>ROOM:</b>{{$application->room}},<br>
                        <b>SEAT: </b>{{$application->seat}}<br>
                        <b>BUILDING:</b> {{$application->building}},<br>
                    </td>
                </tr>
                <tr>
                    <th>Exam Date</th>
                    <td>{{$application->exam_date}}, {{$application->exam_time}}</td>
                </tr>
                <tr>
                    <th>Downloaded</th>
                    <td>
                        @if($application->download_count > 0 )
                            Yes
                        @else
                            No
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{--<div class="col-lg-5">
        @if ($application->unit =='A')
            @include('admin.admit_card_search.unit_a_result')
        @elseif($application->unit =='B')
            @include('admin.admit_card_search.unit_b_result')
        @elseif($application->unit =='C')
            @include('admin.admit_card_search.unit_c_result')
        @endif
    </div>--}}

    <div class="col-lg-2">
        <legend>Photo</legend>
        <img id="img"
             src="{{Storage::url('public/uploads/'.$application->student->photo)}}"
             width="200"
             @class(['img-responsive',
                    'img-thumbnail',
                    'center-block',
                    'rejected' => $application->student->selfie_status == 'R',
                    'accepted' => $application->student->selfie_status == 'A'
                    ])
             alt="Image">
    </div>

    <div class="col-lg-2">
        <legend>Selfie</legend>
        <img id="img"
             src="{{Storage::url('public/uploads/'.$application->student->selfie)}}"
             width="200"
             @class(['img-responsive',
                    'img-thumbnail',
                    'center-block',
                    'rejected' => $application->student->selfie_status == 'R',
                    'accepted' => $application->student->selfie_status == 'A'
                    ])
             alt="Selfie">
    </div>

@else
    <div class="alert alert-danger col-lg-12">
        <strong> Application Not Found  </strong>
    </div>
@endif
