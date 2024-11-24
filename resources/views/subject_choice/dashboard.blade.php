@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
    <div class="panel panel-default">

        <div class="panel-body">
            <legend><i class="fa fa-user"></i> এইচএসসি/এসএসসি (অথবা সমমান) সংক্রান্ত তথ্য</legend>


            @if(Session::has('message'))
                <blockquote class="alert-success">
                    <strong><i class="fa fa-check-circle"></i> {{Session::get('message')}}</strong>
                </blockquote>
            @endif

            <div class="row">
                <div class="col-sm-12">

                    {{-- Personal Info --}}
                    @if ($student )
                        {{-- student data --}}
                        @include('preliminary_application.student_info_partial')
                        <br>

                        {{-- Result --}}
                        <legend id="apply"><i class="fa fa-table"></i> ফলাফল</legend>
                        <table class="table table-condensed table-bordered">
                            <tr class="bg-warning">
                                <th>Unit</th>
                                <th>Exam Roll</th>
                                <th>Group</th>
                                <th>Quota</th>
                                <th>Total Score</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Subject Choice</th>
                            </tr>
                            @forelse($results as $result)
                                <tr>
                                    <td>{{$result->unit}}</td>
                                    <td>{{$result->exam_roll}}</td>
                                    <td>{{$result->unit}}-{{$result->group_number}}</td>
                                    <td>{{$result->quota}}</td>
                                    <td>{{$result->total_score}}</td>
                                    <td>{{$result->position}}</td>
                                    <td>{{$result->status}}</td>
                                    <td>{{$result->interview_date}}</td>
                                    <td>{{$result->subject_choice}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">No Result Found</td>
                                </tr>
                            @endforelse
                        </table>

                        <br>

                        {{--                        bill status--}}
                        <legend><i class="fa fa-usd"></i> বিলের বিবরণ</legend>
                        @if ($validBills->count()>0)
                            {{--                             Bill description --}}
                            <table class="table table-striped table-condensed table-bordered">
                                <thead>
                                <tr class="bg-success">
                                    <th>Bill No.</th>
                                    <th>Amount</th>
                                    <th>Purpose</th>
                                    <th>Quota</th>
                                    <th>Payment Status</th>
                                    {{--                                    <th>Pay Slip</th>--}}
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($validBills as $bill)
                                    <tr>
                                        <td>{{$bill->id}}</td>
                                        <td>TK. {{$bill->amount}}</td>
                                        @if ($bill->payment_purpose =='A')
                                            <td>Unit- {{$bill->units}}</td>
                                        @elseif($bill->payment_purpose =='E')
                                            <td>Preliminary Application</td>
                                        @elseif($bill->payment_purpose =='P')
                                            <td>Photo Change</td>
                                        @elseif($bill->payment_purpose =='R')
                                            <td>Admission</td>
                                        @else
                                            <td>Undefined</td>
                                        @endif
                                        <td>{{$student->quota_string}}</td>
                                        @if ($bill->payment_status == '0')
                                            <td>
                                                <span class="text-danger"><i class="fa fa-clock-o"></i> Unpaid</span> |
                                                <form style="margin-top: 10px; display: inline" class="form-inline"
                                                      method="post" action="{{ route('rocket.pay') }}">
                                                    @csrf
                                                    <input type="hidden" name="bill_id" id="bill_id"
                                                           value="{{$bill->id}}">
                                                    <button type="submit" class="btn btn-xs btn-primary"><i
                                                            class="fa fa-money"></i>
                                                        Pay Online
                                                    </button>
                                                </form>

                                            </td>
                                        @elseif($bill->payment_status == '1')
                                            <td>

                                                <span class="text-success"><i
                                                        class="fa fa-check-circle"></i> Paid</span>
                                            </td>

                                        @endif
                                        {{--<td>-</td>--}}
                                        <td>
                                            @if($bill->payment_purpose!='R')
                                                <a href="{{ route('preliminary.getDownloadBill',$bill->id) }}"><i
                                                        class="fa fa-download"></i> download </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-info">
                                <strong><i class="fa fa-info-circle"></i> এখনো আপনার কোন বিল প্রস্তুত হয়নি</strong>
                            </div>
                        @endif



                        <br>
                        {{--                        Unit list--}}
                        <legend id="apply"><i class="fa fa-table"></i> ভর্তিযোগ্য ইউনিট সমূহ</legend>


                        {{--eligible in at least one unit--}}

                        <div id="message"></div>
                        <table class="table table-condensed table-hover table-bordered">
                            <thead>
                            <tr class="bg-primary">
                                <th width="5%">Admission Roll</th>
                                <th> Subject</th>
                                <th>Subject Choice</th>
                                <th>Admission</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($student->applications as $application)
                                <tr>
                                    <td>{{$application->unit}}-{{$application->admission_roll}}</td>
                                    <td>
                                        {{$application?->subjectOption?->admission_subject?->name ?? 'N/A' }}
                                    </td>
                                    <td>
                                        @if($application?->subjectOption?->sub_allow=='1')
                                            <a class="btn btn-success btn-xs"
                                               ic-target='#message'
                                               ic-include="#_token"
                                               ic-post-to='{{ route('subject_choice.apply', $application->subjectOption->id) }}'
                                               role="button">
                                                @if($application?->subjectOption?->choices?->count())
                                                    <i class="fa fa-edit"></i> Edit Subject Choice
                                                @else
                                                    <i class="fa fa-list"></i> Subject Choice
                                                @endif
                                            </a> |
                                        @endif

                                        @if($application?->subjectOption?->sub_completed =='1')

                                            <a class="btn btn-primary btn-xs"
                                               href='{{ route('subject_choice.showDetails',$application?->subjectOption?->id) }}'
                                               role="button">
                                                <i class="fa fa-search"></i> View Choice Status
                                            </a>

                                        @endif
                                    </td>

                                    {{-- Admission--}}
                                    <td>
                                        {{--admission form--}}
                                        @if($application?->subjectOption?->admission_allow ==1 && empty($application?->subjectOption?->admission_completed))
                                            <a class="btn btn-success btn-xs"
                                               ic-target='#message'
                                               ic-include="#_token"
                                               ic-post-to='{{ route('hons_admission.apply', [$application->subjectOption->id]) }}'
                                               role="button">
                                                <i class="fa fa-file-text-o"></i> Admission Form
                                            </a>
                                        @endif

                                        @if($application?->subjectOption?->admission_completed ==1 && $application?->subjectOption?->office_status!='-1')
                                            <a class="btn btn-success btn-xs"
                                               href="{{ route('hons_admission.showAdmissionForm',[$application->subjectOption->id]) }}">
                                                <i class="fa fa-file-text"></i> Show Admission Form
                                            </a> |

                                            <a class="btn btn-success btn-xs"
                                               href="{{ route('hons_admission.downloadAdmissionForm',[$application->subjectOption->id]) }}">
                                                <i class="fa fa-download"></i> Download
                                            </a>
                                        @endif

                                        {{--opt out--}}
                                        @if(setting('allow_opt_out_C', 0))
                                            @if($application?->subjectOption?->sub_completed =='1' && $application?->subjectOption?->unit=='C' && $application?->subjectOption?->sub_allow !=1 )
                                                <hr>
                                                | <a
                                                    class="btn btn-danger btn-xs"
                                                    data-toggle="modal"
                                                    href='#modal-id'><i class="fa fa-edit"></i> Choice Opt-Out
                                                </a>

                                                {{-- modal --}}
                                                <div class="modal fade" id="modal-id">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-hidden="true">&times;
                                                                </button>
                                                                <h4 class="modal-title">
                                                                    <i class="fa fa-exclamation-circle"></i> লক্ষ্য করুন
                                                                </h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>
                                                                    Unit-C এ ভর্তির জন্য নির্বাচিত শিক্ষার্থী কোন
                                                                    অপেক্ষমান বিভাগ/বিভাগসমূহে ভর্তি হতে ইচ্ছুক না হলে
                                                                    তা পছন্দের তালিকা থেকে বাদ দিতে পারবে। তাতে তার
                                                                    প্রার্থীতা বাতিল হবে না। তবে পূর্বে প্রদত্ত পছন্দের
                                                                    ক্রম পরিবর্তন করা যাবে না এবং <b
                                                                        class="text-danger">কোন বিভাগ পছন্দের
                                                                        ক্রম থেকে একবার বাদ দিলে পরে তা আর পছন্দের
                                                                        তালিকায়
                                                                        অন্তর্ভূক্ত করা যাবে না।</b>
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">Close
                                                                </button>
                                                                <input type="hidden" name="for" id="for-opt"
                                                                       value="opt-out">
                                                                <a class="btn btn-danger"
                                                                   ic-target='#message'
                                                                   ic-include='#_token'
                                                                   ic-post-to='{{ route('hons_admission.postOptOut', $application?->subjectOption?->id) }}'
                                                                   role="button">
                                                                    <i class="fa fa-edit"></i> Choice Opt-Out
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- modal end --}}

                                            @endif
                                        @endif
                                        {{-- /opt out--}}

                                        {{-- Stop Auto Migration --}}
                                        @if( $application?->subjectOption?->office_status=='1' && setting('allow_stop_auto_migration_'.$application?->subjectOption?->unit, 0)=='1')
                                            {{-- if not done yet --}}
                                            @if (empty($application?->subjectOption?->migration_stop))

                                                | <a class="btn btn-info btn-xs"
                                                     ic-target='#message'
                                                     ic-include='#_token'
                                                     ic-post-to='{{ route('hons_admission.postStopAutoMigrationApply',$application?->subjectOption?->id) }}'
                                                     role="button">
                                                    <i class="fa fa-times-circle-o"></i> Stop Auto
                                                    Migration
                                                </a>
                                            @else
                                                {{-- show warning message and stop --}}
                                                <a
                                                    class="btn btn-danger btn-xs"
                                                    data-toggle="modal"
                                                    href='#modal-id2'><i
                                                        class="fa fa-exclamation-circle"></i> Auto
                                                    Migration Stopped
                                                </a>
                                                <div class="modal fade" id="modal-id2">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close"
                                                                        data-dismiss="modal"
                                                                        aria-hidden="true">
                                                                    &times;
                                                                </button>
                                                                <h4 class="modal-title text-danger"><i
                                                                        class="fa fa-exclamation-circle"></i>
                                                                    Migration Already Stopped</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>আপনি ইতিমধ্যেই অটো মাইগ্রেশন বন্ধ করেছেন।
                                                                    নতুন করে আবার অটো মাইগ্রেশন চালু করা
                                                                    যাবে না। </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                        class="btn btn-default"
                                                                        data-dismiss="modal">Close
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                        {{-- /Stop Auto Migration --}}


                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>


                        {{-- Hall selection--}}
                        @if($student?->subjectOption?->office_status ==1 && $student?->subjectOption?->hall_choice_allow==1)

                        <div class="panel panel-primary">

                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-building-o"></i> হলের পছন্দক্রম</h3>
                            </div>
                            <div class="panel-body">
                                <p style="font-size: 1.3em; line-height: 1.6em">হলের পছন্দক্রম প্রদান/পরিবর্তন করতে নিচের <span class="label label-primary">Update Hall
                                        Choice</span> এ ক্লিক করুন।
                                @if($student?->subjectOption?->hall_choice_complete =='1')
                                    হল এর পছন্দক্রম দেখতে অথবা ডাউনলোড করতে <span class="label label-success">View Hall Choices</span> এ ক্লিক করুন।
                                @endif
                                </p>
                                <hr>

                                <p class="text-center">

                                    @if($student?->subjectOption?->hall_choice_complete =='1')

                                        <a class="btn btn-success"
                                           href='{{ route('hall_choice.showDetails',$student?->subjectOption?->id) }}'
                                           role="button">
                                            <i class="fa fa-search"></i> View Hall Choices
                                        </a>

                                    @endif


                                    <a class="btn btn-primary"
                                       ic-target='#message'
                                       ic-include="#_token"
                                       ic-post-to='{{ route('hall_choice.apply', $application->subjectOption->id) }}'
                                       role="button">
                                        @if($application?->subjectOption?->hallChoices()?->count())
                                            <i class="fa fa-edit"></i> Update Hall Choice
                                        @else
                                            <i class="fa fa-list"></i> Update Hall Choice
                                        @endif
                                    </a>
                                </p>
                            </div>
                        </div>
                        @endif





                        <div class="row no-print">
                            <div class="col-sm-12">
                                <p class="text-right">
                                    <a class="btn btn-danger" href="{{ route('student.getLogout') }}" role="button">
                                        <i class="fa fa-home"></i> Exit
                                    </a>

                                </p>
                            </div>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>{{-- panel-default --}}

@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
@stop
