@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
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

                        {{--                        bill status--}}
                        <legend><i class="fa fa-usd"></i> বিলের বিবরণ</legend>
                        @if ($validBills->count()>0)
                            <div class="alert alert-info">
                                বিল পরিশোধের ২ ঘন্টার মধ্যে Payment Status আপডেট না হলে হেল্প লাইনে কল করুন।
                            </div>
                            {{--                             Bill description --}}
                            <table class="table table-striped table-condensed table-bordered">
                                <thead>
                                <tr class="bg-success">
                                    <th>Bill No.</th>
                                    <th>Amount</th>
                                    <th>Purpose</th>
                                    <th>Quota</th>
                                    <th>Language</th>
                                    <th>Payment Status</th>
                                    {{--<th>Pay Slip</th>--}}
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
                                        @else
                                            <td>Undefined</td>
                                        @endif
                                        <td>{{$student->quota_string}}</td>
                                        <td>{{$student->is_english ? 'English':'Bangla'}}</td>
                                        @if ($bill->payment_status == '0')
                                            <td>
                                                <span class="text-danger"><i class="fa fa-clock-o"></i> Unpaid</span>
                                            </td>
                                            <td>
                                                <form class="form-inline" method="post" action="{{ route('rocket.pay') }}">
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
                                            {{--<td>-</td>--}}
                                        @endif
                                        <td>
                                            <a href="{{ route('preliminary.getDownloadBill',$bill->id) }}"><i
                                                    class="fa fa-download"></i> download </a>
                                            {{--
                                            @if($bill->payment_status == '0')
                                                <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
                                                <input type="hidden" id="route" name="route"
                                                       value="{{route('student.getDashboard')}}">
                                                @if(session('authorize_this_session',0))
                                                    | <a class="text-danger"
                                                         ic-post-to='{{route('final_application.postDeleteBill',$bill )}}'
                                                         ic-include='#_token'
                                                         ic-confirm='Are you sure you want to delete?'
                                                         href="#"
                                                    >
                                                        <i class="fa fa-trash-o"></i> Cancel Bill </a>
                                                @else
                                                    |  <a class="text-danger" data-toggle="modal" href='#modal-id'><i
                                                            class="fa fa-lock"></i> Cancel Bill</a>

                                                    --}}{{--modal--}}{{--
                                                    @include('final_application.verification_popup')

                                                @endif

                                            @endif
                                            --}}
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
                        <legend id="apply"><i class="fa fa-table"></i> চূড়ান্ত আবেদনযোগ্য ইউনিট সমূহ</legend>


                        @if(!$student->mobile_no_verified)
                            <div class="alert alert-warning" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong><a href="{{route('identity_verification.index')}}"><i
                                            class="fa fa-mobile-phone"></i> মোবাইল ফোন ভেরিফিকেশন</a> এখনো বাকি আছে ...</strong>
                            </div>
                        @endif

                        @if(!$student->isEnrolled())
                            <blockquote class="alert alert-danger">
                                রাজশাহী বিশ্ববিদ্যালয়ে ২০২৩-২৪ সালের ১ম বর্ষ স্নাতক(সম্মান)/স্নাতক ভর্তি পরিক্ষার জন্য
                                আপনার কোন প্রাথমিক আবেদন পাওয়া যায়নি।
                            </blockquote>
                        @elseif ( array_sum($eligibility) <= 0 )
                            {{--not eligible in any unit--}}
                            {{--<blockquote class="alert alert-warning">
                                রাজশাহী বিশ্ববিদ্যালয়ে ২০২৩-২৪ সালের ১ম বর্ষ স্নাতক(সম্মান)/স্নাতক ভর্তি পরিক্ষার
                                প্রাথমিক আবেদনের ফলাফল এখনো প্রকাশিত হয় নি। দয়া করে অপেক্ষা করুন।
                            </blockquote>--}}
                             {{--<blockquote class="alert alert-warning">
                                রাজশাহী বিশ্ববিদ্যালয়ে ২০২৩-২৪ সালের ১ম বর্ষ স্নাতক/স্নাতক(সম্মান) ভর্তি পরিক্ষার
                                চূড়ান্ত আবেদনের জন্য বর্তমান পর্যায়ে আপনি নির্বাচিত হননি। দয়া করে অপেক্ষা করুন।
                            </blockquote>--}}
							<blockquote class="alert alert-warning">
                                রাজশাহী বিশ্ববিদ্যালয়ে ২০২৩-২৪ সালের ১ম বর্ষ স্নাতক/স্নাতক(সম্মান) ভর্তি পরিক্ষার
                                চূড়ান্ত আবেদনের জন্য বর্তমান পর্যায়ে আপনি নির্বাচিত হননি। দয়া করে পরবর্তী পর্যায়ের জন্য অপেক্ষা করুন।
                            </blockquote>
                        @else
                            {{--eligible in at least one unit--}}
                            <h4 class="alert alert-info" style="line-height: 1.4em">
                                রাজশাহী বিশ্ববিদ্যালয়ে ২০২৩-২৪ সালের ১ম বর্ষ স্নাতক(সম্মান)/স্নাতক
                                ভর্তি পরিক্ষার জন্য আপনি নিচের ইউনিট গুলোর জন্য প্রাথমিক ভাবে বিবেচিত হয়েছেন।
                                চূড়ান্ত আবেদনের জন্য যে ইউনিট গুলিতে আবেদন করতে চান তার পাশের বক্সে টিক(<i
                                    class="fa fa-check"></i>) দিন। <u>আপনি
                                    একবারে একাধিক ইউনিট সিলেক্ট করতে পারবেন।</u></b>
                            </h4>

                            <div id="message"></div>
                            <table class="table table-condensed table-hover table-bordered">
                                <thead>
                                <tr class="bg-success">
                                    <th>Unit</th>
                                    <th>Faculty/Institute</th>
                                    <th>Final Application</th>
                                    <th> Apply</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($eligibility as $unit=> $value)
                                    @if ($value == 1 )
                                        {{--eligibile but not applied--}}
                                        <tr @if (in_array($unit, $paidUnits ?? ''))    class="bg-success"
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
                                                @if (in_array($unit, $pendingUnits))
                                                @elseif(in_array($unit, $paidUnits))
                                                @else
                                                    @if(setting('allow_application_submission', 0))
                                                        <label class="checkbox-inline">
                                                            {{Form::checkbox('units[]', $unit, old('unit')==$unit, ['class'=>'units'])}}
                                                            Select
                                                        </label>
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
                            <div class="row no-print">
                                <div class="col-sm-12">
                                    <p class="text-right">
                                        <a class="btn btn-danger" href="{{ route('student.getLogout') }}" role="button">
                                            <i class="fa fa-home"></i> Exit
                                        </a>

                                        {{--show submit button only when some unit is not enrolled--}}
                                        @if ( count($pendingUnits)+count($paidUnits) < array_sum($eligibility))
                                            @if(setting('allow_application_submission', 0))
                                                <input type="hidden" name="_token" id="_token"
                                                       value="{{ csrf_token() }}">
                                                <a class="btn btn-primary" ic-target='#message'
                                                   ic-include='.units,#_token'
                                                   ic-post-to='{{ route('final_application.postApply') }}'
                                                   role="button">
                                                    Apply <i class="fa fa-arrow-right"></i>
                                                </a>
                                            @endif
                                        @endif
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
