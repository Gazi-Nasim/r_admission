@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
<div class="panel panel-default">

    <div class="panel-body">
        <legend><i class="fa fa-user"></i> এসএসসি ও এইচএসসি (অথবা সমমান) সংক্রান্ত তথ্য</legend>

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

                {{-- bill status--}}
                <legend><i class="fa fa-usd"></i> বিলের বিবরণ</legend>
                @if ($validBills->count()>0)
                <div class="alert alert-info">
                    বিল পরিশোধের ২ ঘন্টার মধ্যে Payment Status আপডেট না হলে হেল্প লাইনে কল করুন।
                </div>
                {{-- Bill description --}}
                <table class="table table-striped table-condensed table-bordered">
                    <thead>
                        <tr class="bg-success">
                            <th>Bill No.</th>
                            <th>Amount</th>
                            <th>Purpose</th>
                            <th>Quota</th>
                            <th>Language</th>
                            <th>Payment Status</th>
                            {{-- <th>Pay Slip</th>--}}
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
                                    <button type="submit" class="btn btn-sm btn-pink"><i class="fa fa-money"></i>
                                        Pay Online
                                    </button>
                                </form>
                            </td>

                            {{--<td>
                                                <a ic-get-from="{{ route('reg.get_bill_edit',$bill->id) }}"
                            ic-target=".modal-body" data-toggle="modal" href='#modal-id'><i
                                class="fa fa-recycle"></i> Change Payslip </a>
                            </td>--}}
                            @elseif($bill->payment_status == '1')
                            <td>
                                <span class="text-success"><i
                                        class="fa fa-check-circle"></i> Paid</span>
                            </td>

                            {{-- <td>-</td>--}}
                            @endif
                            <td>
                                <a href="{{ route('preliminary.getDownloadBill',$bill->id) }}"><i
                                        class="fa fa-download"></i> download </a>
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
                {{-- Unit list--}}
                <legend id="apply"><i class="fa fa-table"></i> প্রাথমিক আবেদনযোগ্য ইউনিট সমূহ</legend>


                @if(!$student->mobile_no_verified)
                <div class="alert alert-warning" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong><a href="{{route('identity_verification.index')}}"><i
                                class="fa fa-mobile-phone"></i> মোবাইল ফোন ভেরিফিকেশন</a> এখনো বাকি আছে ...</strong>
                </div>
                @endif

                @if(!$student->zone_submitted)
                <div class="alert alert-warning" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong><a href="{{route('preliminary.getZones')}}"><i
                                class="fa fa-mobile-phone"></i> অঞ্চল সমূহ সিলেক্ট</a> এখনো বাকি আছে ...</strong>
                </div>
                @endif

                {{-- @if(!$student->email_verified)--}}
                {{-- <div class="alert alert-warning" role="alert">--}}
                {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
                {{-- <span aria-hidden="true">&times;</span>--}}
                {{-- </button>--}}
                {{-- <strong><a href="{{route('identity_verification.index')}}"><i--}}
                    {{--                                            class="fa fa-envelope"></i> ইমেইল ভেরিফিকেশন (ঐচ্ছিক)</a> এখনো বাকি আছে...</strong>--}}
                    {{--                            </div>--}}
                    {{--                        @endif--}}


                    @if ( array_sum($eligibility) <=0 )
                    {{--not eligible in any unit--}}
                    <blockquote class="alert-danger">
                    রাজশাহী বিশ্ববিদ্যালয়ে ভর্তির জন্য প্রয়োজনীয় GPA না থাকায় আপনি কোন ইউনিটে আবেদনের জন্য
                    বিবেচিত হননি।
                    </blockquote>
                    @else
                    {{--eligible in at least one unit--}}
                    <p class="alert alert-info">
                        যে ইউনিট গুলোতে আবেদন করতে চান তার পাশের বক্সে টিক(<i class="fa fa-check"></i>) দিন। <b>আপনি
                            একবারে একাধিক ইউনিট সিলেক্ট করতে পারবেন।</b>
                    </p>

                    <div id="message"></div>
                    <table class="table table-condensed table-hover table-bordered">
                        <thead>
                            <tr class="bg-success">
                                <th>Unit</th>
                                <th>Faculty/Institute</th>
                                <th>Application Status</th>
                                <th> Apply</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($eligibility as $unit=> $value)
                            @if ($value != 0)
                            @if ($value == 1 )
                            {{--eligibile but not applied--}}
                            <tr @if (in_array($unit, $paidUnits ?? '' )) class="bg-success"
                                @elseif(in_array($unit, $pendingUnits)) class="bg-danger" @else @endif>
                                <td width="10%">Unit - {{$unit}}</td>
                                <td>{{$unitNames[$unit]}}</td>
                                <td>
                                    @if (in_array($unit,$pendingUnits))
                                    <i class="fa fa-clock-o"></i> Bill Unpaid
                                    @elseif(in_array($unit,$paidUnits ?? ''))
                                    <i class="fa fa-check-circle"></i> Completed
                                    @else
                                    Not Applied
                                    @endif
                                </td>
                                <td>
                                    @if (in_array($unit, $pendingUnits))
                                    @elseif(in_array($unit, $paidUnits))
                                    @else
                                    <label class="checkbox-inline">
                                        {{Form::checkbox('units[]', $unit, old('unit')==$unit, ['class'=>'units'])}}
                                        Select
                                    </label>
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
                                @if ( count($student->enrollments) < array_sum($eligibility))
                                    @if(setting('allow_application_submission', 0))
                                    <input type="hidden" name="_token" id="_token"
                                    value="{{ csrf_token() }}">
                                    <a class="btn btn-primary" ic-target='#message'
                                        ic-include='.units,#_token'
                                        ic-post-to='{{ route('preliminary.postApply') }}' role="button">
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