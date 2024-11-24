@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <style>
        .rejected {
            border: 2px solid red;
        }

        .accepted {
            border: 2px solid green;
        }

    </style>
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><i class="fa fa-users"></i> Student Details</legend>
            <p>
                <a href="{{ route('admin.student.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i>
                    Back</a>
            </p>

            @if ($student_data)
                <div class="row">
                    {{-- <pre>
                        {{ print_r($student_data)}}
                    </pre> --}}
                    <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
                    <div class="col-sm-2">{{-- image block --}}
                        @if ($student_data->photo)
                            <img id="img" src="{{Storage::url('public/uploads/'.$student_data->photo)}}?{{rand()}}"
                                 width="200"
                                 @class(['img-responsive',
                                        'img-thumbnail',
                                        'center-block',
                                        'rejected' => $student_data->photo_status == 'R',
                                        'accepted' => $student_data->photo_status == 'A'
                                        ])
                                 alt="Image">
                                <p class="text-center">
                                    <a class="btn btn-xs btn-success" ic-confirm='Are you sure?'
                                       ic-post-to="{{ route('admin.photo_check.setStatus',[$student_data->id,'AP']) }}"
                                       ic-include='#_token'
                                       ic-target="closest p" role="button">
                                        <i class="fa fa-times"></i> AP
                                    </a>
                                    <a class="btn btn-xs btn-danger" ic-confirm='Are you sure?'
                                       ic-post-to="{{ route('admin.photo_check.setStatus',[$student_data->id,'RP']) }}"
                                       ic-include='#_token'
                                       ic-target="closest p" role="button">
                                        <i class="fa fa-times"></i> RP
                                    </a>
                                </p>

                                <p class="text-center">Checked By:<br> <b>{{$checked_by}}</b></p>
                                @role ('Admin')
                                <p class="text-center">
                                    <a class="btn btn-sm btn-primary" target="_blank" href="{{route('admin.student.allImages',$student_data->id)}}"><i class="fa fa-users"></i> All Images</a>
                                </p>
                                @endrole
                        @else
                            <img id="img" src="{{url('assets/img/Profile1.jpg')}}" width="200"
                                 class="img-responsive img-thumbnail center-block" alt="Image">
                            <br>
                            <p class="col-sm-10 col-sm-offset-1 bg-warning"><i class="fa fa-times"></i> Not Applied</p>
                        @endif
                    </div>


                    <div class="col-sm-2">{{-- selfie block --}}
                        @if ($student_data->selfie)
                            <img  @class(['img-responsive',
                                        'img-thumbnail',
                                        'center-block',
                                        'rejected' => $student_data->selfie_status == 'R',
                                        'accepted' => $student_data->selfie_status == 'A'
                                        ])
                                  src="{{Storage::url('public/uploads/'.$student_data->selfie)}}?{{rand()}}"/>
                        @else
                            <img id="img" src="{{url('assets/img/Selfie.jpg')}}" width="200"
                                 class="img-responsive img-thumbnail center-block" alt="Image">
                            <p class="col-sm-10 col-sm-offset-1 bg-warning"><i class="fa fa-times"></i> Not Applied</p>
                        @endif
                        <p class="text-center">
                            <a class="btn btn-success btn-xs"
                               ic-replace-target=true
                               ic-include='#_token'
                               ic-post-to="{{ route('admin.photo_check.setStatus',[$student_data->id,'AS']) }}">
                                <i class="fa fa-check-circle"></i> AS
                            </a>

                            <a class="btn btn-danger btn-xs"
                               ic-replace-target=true
                               ic-include='#_token'
                               ic-confirm='Are you sure?'
                               ic-post-to="{{ route('admin.photo_check.setStatus',[$student_data->id,'RS']) }}">
                                <i class="fa fa-times-circle"></i> RS
                            </a>

                        </p>
                        <br>
                        <br>
                    </div>

                    <div class="col-sm-8">{{-- student info --}}

                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                <i class="fa fa-check-circle"></i> {{ session('message') }}
                            </div>
                        @endif


                        <div class="table-responsive">
                            <table class="table table-bordered  table-condensed">
                                <tr class="bg-warning">
                                    <th colspan="2">Applicant ID.</th>
                                    <td colspan="6">{{$student_data->id}}</td>
                                </tr>
                                <tr class="bg-warning">
                                    <th width="20%" colspan="2">Applicant's Name</th>
                                    <td colspan="6">{{$student_data->NAME}}</td>
                                </tr>
                                <tr class="bg-warning">
                                    <th colspan="2">Father's Name</th>
                                    <td colspan="6">{{$student_data->FNAME}}</td>
                                </tr>
                                <tr class="bg-warning">
                                    <th colspan="2">Mother's Name</th>
                                    <td colspan="6">{{$student_data->MNAME}}</td>
                                </tr>
                                <tr class="bg-warning">
                                    <th colspan="2">Mobile No</th>
                                    <td colspan="6">{{$student_data->mobile_no}}</td>
                                </tr>
                                <tr class="bg-warning">
                                    <th colspan="2">Eligible for</th>
                                    <td colspan="6">
                                        @foreach ($elegiblility as $unit=>$value)
                                            @if ($value>0)
                                                <span class="badge">{{$unit}}</span>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr class="bg-success">
                                    <th colspan="2">Enrolled</th>
                                    <th colspan="6">
                                        @foreach ($enrollments as $enrollment)
                                            @if ($enrollment->status < 0)
                                                <span class="label label-danger">{{$enrollment->unit}} - Canceled</span>
                                            @elseif($enrollment->status == 0)
                                                <span
                                                    class="label label-default">{{$enrollment->unit}} - <i
                                                        class="fa fa-square-o"></i></span>
                                            @else
                                                <span
                                                    class="label label-success">{{$enrollment->unit}} - <i
                                                        class="fa fa-check-square-o"></i></span>
                                            @endif
                                        @endforeach
                                    </th>
                                </tr>
                                <tr class="bg-success">
                                    <th colspan="2">Quotas</th>
                                    <th colspan="6">
                                        @forelse($student_data->quota_document_array as $quota=>$document)
                                            <a target="_blank"
                                               href="{{ Storage::url('public/uploads/'.$document) }}?{{time()}}">{{$quota}}
                                                @if($quota =='FFQ')
                                                    ({{$student_data->FFQ_type}})
                                                @endif

                                            </a>
                                            |
                                        @empty
                                            No Quotas
                                        @endforelse
                                    </th>
                                </tr>
                                <tr class="bg-success">
                                    <th colspan="2">Question Language</th>
                                    <td colspan="6">{{$student_data->is_english ? 'English': 'Bangla'}}</td>
                                </tr>
                                <tr class="bg-success">
                                    <th colspan="2">Applied</th>
                                    <td colspan="6">
                                        @foreach ($applications as $app)
                                            <a ic-get-from="{{ route('admin.student.showApplication',$app->id) }}"
                                               ic-target="#application-details"
                                               class="btn btn-info btn-xs">{{$app->unit}}</a>
                                        @endforeach
                                        <div id="application-details"></div>
                                    </td>
                                </tr>
                                <tr class="bg-success">
                                    <th colspan="2">Pending Bills</th>
                                    <td colspan="6">
                                        @if (count($pending_bill))
                                            @foreach ($pending_bill as $bill)
                                                <a target="_blank"
                                                   href="{{route('admin.bill.getDownloadBill',$bill->id)}}">{{$bill->id}}
                                                    ({{$bill->units}})</a>,&nbsp;
                                            @endforeach
                                        @else
                                            No Pending Bill.
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8"></td>
                                </tr>
                                {{-- heading --}}
                                <tr class="bg-warning">
                                    <th>Exam</th>
                                    <th>Roll</th>
                                    <th>Board</th>
                                    <th>Reg No.</th>
                                    <th>Year</th>
                                    <th>Group</th>
                                    <th>CGPA</th>
                                    <th>Result</th>
                                </tr>
                                {{-- hsc data --}}
                                <tr>
                                    <td>HSC/Equiv.</td>
                                    <td>{{$student_data->HSC_ROLL_NO}}</td>
                                    <td>{{$student_data->HSC_BOARD_NAME}}</td>
                                    <td>{{$student_data->HSC_REGNO}}</td>
                                    <td>{{$student_data->HSC_PASS_YEAR}}</td>
                                    <td>{{$student_data->HSC_GROUP}}</td>
                                    <td>
                                        @if (!empty($student_data->HSC_GPA))
                                            {{number_format($student_data->HSC_GPA,2)}}
                                        @endif
                                    </td>
                                    <td @if($student_data->HSC_RESULT=='FAIL') class="text-danger" @endif>{{$student_data->HSC_RESULT}}</td>
                                </tr>
                                {{-- ssc data --}}
                                <tr>
                                    <td>SSC/Equiv.</td>
                                    <td>{{$student_data->SSC_ROLL_NO}}</td>
                                    <td>{{$student_data->SSC_BOARD_NAME}}</td>
                                    <td>{{$student_data->SSC_REGNO}}</td>
                                    <td>{{$student_data->SSC_PASS_YEAR}}</td>
                                    <td>{{$student_data->SSC_GROUP}}</td>
                                    <td>
                                        @if (!empty($student_data->SSC_GPA))
                                            {{number_format($student_data->SSC_GPA,2)}}
                                        @endif
                                    </td>
                                    <td @if($student_data->SSC_RESULT=='FAIL') class="text-danger" @endif>{{$student_data->SSC_RESULT}}</td>
                                </tr>
                                <tr>
                                    <td colspan="8"></td>
                                </tr>
                                <tr class="bg-info">
                                    <th>HSC_LTRGRD</th>
                                    <td colspan="7">{{$student_data->HSC_LTRGRD}}</td>
                                </tr>
                                <tr class="bg-info">
                                    <th>C_TYPE</th>
                                    <td colspan="7">{{$student_data->C_TYPE}}</td>
                                </tr>
                            </table>
                            @role('Admin')
                            <div class="text-right" style="display: flex; gap: 5px; flex-wrap: wrap; flex-direction: row-reverse">
                                @if ($student_data->photo != NULL)
                                    <a class="btn btn-info"
                                       href="{{ route('admin.student.uploadStudentPhoto', $student_data->id) }}"
                                       role="button"><i
                                            class="fa fa-upload"></i> Change Photo</a>

                                    {{--<a class="btn btn-primary" href="{{ route('site.home') }}" role="button"><i
                                            class="fa fa-bars"></i> Update Quota(Single)</a>--}}
                                    <a class="btn btn-danger"
                                       ic-confirm="Are you sure you want to delete this?"
                                       ic-post-to="{{route('admin.student.clearQuotas',$student_data->id)}}"
                                       ic-replace-target="true"
                                       ic-include='#_token'
                                    ><i class="fa fa-trash-o"></i> Clear Quota</a>
                                    <a class="btn btn-primary"
                                       href="{{route('admin.student.editQuota',$student_data->id)}}"
                                    ><i class="fa fa-upload"></i> Update Quota</a>

                                    <a class="btn btn-success"
                                       data-toggle="modal"
                                       href='#modal-id'
                                       ic-get-from='{{ route('admin.student.editMobile', $student_data) }}'
                                       ic-target='.modal-body'
                                    ><i class="fa fa-mobile-phone"></i> Update Mobile</a>
                                @endif

                                    <a class="btn btn-primary" ic-replace-target="true"
                                       ic-post-to="{{ route('admin.student.postTempSelfie', $student_data) }}"
                                       ic-include="#_token"
                                       ic-confirm="Are you sure you want to Update Selfie?"
                                       role="button"><i class="fa fa-user"></i>
                                        Temp. Selfie</a>

                                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">

                                <a class="btn btn-primary" ic-target='#board_lookup'
                                   ic-post-to="{{ route('admin.student.boardLookup', $student_data) }}"
                                   ic-include="#_token"
                                   role="button"><i class="fa fa-search"></i>
                                    Board Lookup</a>

                                <a class="btn btn-danger" href="{{route('admin.student.edit', $student_data)}}"
                                   role="button"><i class="fa fa-edit"></i> Edit</a>



                                <a class="btn btn-warning" target="_blank" href="{{route('admin.student.loginAsStudent', $student_data)}}"
                                       role="button"><i class="fa fa-sign-in"></i> Login</a>

                            </div>
                            @endrole
                        </div>

                        <div id="board_lookup"></div>
                    </div>
                </div>{{-- student data --}}
            @else
                <div class="alert alert-info">
                    <strong><i class="fa fa-info-circle"></i> No data found</strong>
                </div>
            @endif
        </div>
    </div>
@stop


@include('admin.popup',['title'=>'মোবাইল নম্বর নিশ্চিতকরণ'])

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
@stop

