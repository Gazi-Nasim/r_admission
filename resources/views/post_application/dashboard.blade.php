@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default full-height">

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
                                    <th colspan="2" class="text-center">Action</th>
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
                                        @elseif($bill->payment_purpose =='PR')
                                            <td>Photo/Selfie Collection Fee</td>
                                        @else
                                            <td>Undefined</td>
                                        @endif
                                        <td>{{$student->quota_string}}</td>
                                        @if ($bill->payment_status == '0')
                                            <td>
                                                <span class="text-danger"><i class="fa fa-clock-o"></i> Unpaid</span>
                                            </td>
                                            <td>
                                                <form  class="form-inline" method="post" action="{{ route('rocket.pay') }}">
                                                    @csrf
                                                    <input type="hidden" name="bill_id" id="bill_id" value="{{$bill->id}}">
                                                    <button type="submit" class="btn btn-sm btn-purple"><i class="fa fa-money"></i>
                                                        Pay Online
                                                    </button>
                                                </form>
                                            </td>
                                        @elseif($bill->payment_status == '1')
                                            <td>

                                                <span class="text-success"><i
                                                        class="fa fa-check-circle"></i> Paid</span>
                                            </td>

                                            <td>-</td>
                                        @endif
                                        <td>
                                            @if($bill->payment_purpose != 'PR')
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
                        <legend id="apply"><i class="fa fa-table"></i> আবেদীত ইউনিটসমূহ</legend>


                        @if(!$student->isEnrolled())
                            <blockquote class="alert alert-danger">
                                রাজশাহী বিশ্ববিদ্যালয়ে ২০২৩-২৪ সালের ১ম বর্ষ স্নাতক(সম্মান)/স্নাতক ভর্তি পরিক্ষার জন্য
                                আপনার কোন প্রাথমিক আবেদন পাওয়া যায়নি।
                            </blockquote>
                        @elseif ( array_sum($eligibility) <= 0 )
                            {{--not eligible in any unit--}}
                            <blockquote class="alert alert-warning">
                                রাজশাহী বিশ্ববিদ্যালয়ে ২০২৩-২৪ সালের ১ম বর্ষ স্নাতক/স্নাতক(সম্মান) ভর্তি পরিক্ষার
                                চূড়ান্ত আবেদনের জন্য আপনি নির্বাচিত হননি।
                            </blockquote>
                        @else
                            {{--eligible in at least one unit--}}

                            <div id="message"></div>
                            <table class="table table-condensed table-hover table-bordered">
                                <thead>
                                <tr class="bg-success">
                                    <th>Unit</th>
                                    <th width="50%">Faculty/Institute</th>
                                    <th>Application Status</th>
                                    <th> Admit Card</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($eligibility as $unit=> $value)
                                    @if ($value == 1 )
                                        {{--eligibile but not applied--}}
                                        <tr @if (in_array($unit, $paidUnits ?? ''))
                                            @elseif(in_array($unit, $pendingUnits)) class="bg-danger" @else    @endif>
                                            <td width="10%">Unit - {{$unit}}</td>
                                            <td>{{$unitNames[$unit]}}</td>
                                            <td>
                                                @if (in_array($unit,$pendingUnits))
                                                    <i class="fa fa-clock-o"></i> Bill Unpaid
                                                @elseif(in_array($unit,$paidUnits ?? ''))
                                                    <i class="fa fa-check-circle"></i> Complete
                                                @else
                                                    Not Applied
                                                @endif
                                            </td>
                                            <td>
                                                @if(setting('allow_admit_download', 0))
                                                    @if (in_array($unit, $paidUnits))
                                                        <a href="{{route('post_application.getDownloadAdmitCard',[$student->id,$unit])}}"
                                                           class="btn btn-primary btn-sm"><i class="fa fa-download"></i>
                                                            Download</a>

                                                        {{--<a href="{{route('site.getAdmitCard', encrypt(165853))}}"
                                                           class="btn btn-primary btn-sm"><i class="fa fa-download"></i>
                                                            Download 2</a>--}}
                                                    @endif
                                                @else
                                                    @if (in_array($unit, $paidUnits))
                                                        Admit Card download will be available from 19/02/2024, 12PM
                                                    @else
                                                        -
                                                    @endif
                                                @endif


                                            </td>
                                        </tr>
                                    @else
                                        {{--already applied--}}
                                        <tr class="bg-success text-success">
                                            <td>Unit - {{$unit}}</td>
                                            <td>{{$unitNames[$unit]}}</td>
                                            <td>{{$unit.$value}}</td>
                                            <td><i class="fa fa-check-circle"></i> Applied</td>
                                            <td></td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>

                            <legend id="apply"><i class="fa fa-table"></i> ফলাফল</legend>
                            @if(setting('show_results', '0') )
                            <table class="table table-condensed table-bordered">
                                <tr class="bg-warning">
                                    <th>Unit</th>
                                    <th>Exam Roll</th>
                                    <th>Group</th>
                                    <th>Quota</th>
                                    <th>Total Score</th>
                                    <th>Group Position</th>
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
                            @else
                                <blockquote class="alert alert-warning">
                                    পরীক্ষার ফলাফল প্রকাশের জন্য অপেক্ষা করুন।
                                </blockquote>
                            @endif

                            <div class="row no-print">
                                <div class="col-sm-12">
                                    <p class="text-right">
                                        <a class="btn btn-danger" href="{{ route('student.getLogout') }}" role="button">
                                            <i class="fa fa-home"></i> Exit
                                        </a>

                                        {{--show submit button only when some unit is not enrolled--}}
{{--                                        @if ( count($pendingUnits)+count($paidUnits) < array_sum($eligibility))--}}
{{--                                            @if(setting('allow_application_submission', 0))--}}
{{--                                                <input type="hidden" name="_token" id="_token"--}}
{{--                                                       value="{{ csrf_token() }}">--}}
{{--                                                <a class="btn btn-primary" ic-target='#message'--}}
{{--                                                   ic-include='.units,#_token'--}}
{{--                                                   ic-post-to='{{ route('final_application.postApply') }}'--}}
{{--                                                   role="button">--}}
{{--                                                    Apply <i class="fa fa-arrow-right"></i>--}}
{{--                                                </a>--}}
{{--                                            @endif--}}
{{--                                        @endif--}}
                                    </p>
                                </div>
                            </div>
                        @endif

                    @endif
                </div>
            </div>
        </div>
    </div>{{-- panel-default --}}

@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
@stop
