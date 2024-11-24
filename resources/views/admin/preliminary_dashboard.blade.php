@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default full-height">
        <div class="panel-body">
            <legend><i class="fa fa-dashboard"></i> Dashboard</legend>
            @if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Operator'))
                {{-- row 1 --}}
                <div class="row">
                    @if (Auth::user()->hasRole('Admin'))
                        {{-- pending tasks --}}
                        <div class="col-sm-3">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Pending Tasks</h3>
                                </div>

                                <div class="list-group">
                                    <a href="{{ route('admin.oth.index') }}" class="list-group-item">
                                        OTH Applications<span class="badge">{{$num_oth}}</span>
                                    </a>
                                    <a href="{{ route('admin.complainbox.index') }}" class="list-group-item">
                                        Complain Box <span class="badge">{{$num_review}}</span>
                                    </a>

                                    <a href="{{ route('admin.photo_review.index') }}" class="list-group-item">
                                        Photo Change <span class="badge">{{$num_photo_review}}</span>
                                    </a>
                                    <a href="{{ route('admin.mobile-change.index') }}" class="list-group-item">
                                        Mobile No Change <span class="badge">{{$num_mobile_changes}}</span>
                                    </a>
                                </div>
                            </div>

                            <div class="panel panel-danger">
                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        Admit Downloaded<span class="badge">{{ number_format($admitCardDownloadCount,0,'.',',')}}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-sm-3">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Pending Tasks</h3>
                                </div>

                                <div class="list-group">
                                    <p class="list-group-item">
                                        OTH Applications<span class="badge">{{$num_oth}}</span>
                                    </p>
                                    <p class="list-group-item">
                                        Complain Box <span class="badge">{{$num_review}}</span>
                                    </p>

                                    <p class="list-group-item">
                                        Photo Change <span class="badge">{{$num_photo_review}}</span>
                                    </p>

                                    <p class="list-group-item">
                                        Photo Change <span class="badge">{{$num_mobile_changes}}</span>
                                    </p>
                                </div>
                            </div>

                        </div>
                    @endif


                    {{-- payment donut --}}
                    {{--                    @if (Auth::user()->hasRole('Admin'))--}}
                    {{--                        <div class="col-sm-3">--}}
                    {{--                            <div class="panel panel-info">--}}
                    {{--                                <div class="panel-heading">--}}
                    {{--                                    <h3 class="panel-title">Payment Summary</h3>--}}
                    {{--                                </div>--}}
                    {{--                                <div class="panel-body" id="payment-summary" style="height: 200px;">--}}
                    {{--                                </div>--}}
                    {{--                                <div class="panel-footer">--}}
                    {{--                                    <b>Total : TK. {{number_format (array_sum($payment_summary),0,'',',')}}</b>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    @endif--}}

                    {{--unit application summery--}}
                    <div @if (Auth::user()->hasRole('Admin')) class="col-sm-6" @else class="col-sm-6" @endif>
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">Unit Summary</h3>
                            </div>
                            <div class="panel-body" id="unit-summery" style="height: 200px;">
                            </div>
                            <div class="panel-footer">
                                <b>Total : {{number_format (array_sum($enrollments->toArray()),0,'',',')}}</b>
                            </div>
                        </div>
                    </div>
                    <div @if (Auth::user()->hasRole('Admin')) class="col-sm-3" @else class="col-sm-3" @endif>
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title">Payment Status</h3>
                            </div>
                            <div class="list-group">
                                @foreach($paidThrough as $method=>$total)
                                    <a href="#" class="list-group-item">
                                        {{$method}} <span class="badge">{{number_format($total,0,'',',')}}</span>
                                    </a>
                                    {{--                                    <a href="#" class="list-group-item">--}}
                                    {{--                                        {{$method}} <span class="badge">{{number_format($total,0,'',',')}}</span>--}}
                                    {{--                                    </a>--}}

                                @endforeach
                                {{--<a href="#" class="list-group-item">
                                    bKash<span class="badge">{{number_format($paidThrough['B'] ?? 0 ,0,'',',')}}</span>
                                </a>
                                <a href="#" class="list-group-item">
                                    Rocket <span class="badge">{{number_format($paidThrough['R'],0,'',',')}}</span>
                                </a>--}}
                            </div>
                        </div>

                        <div class="panel panel-danger">
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-envelope"></i> SMS Credit<span class="badge">{{ setting('sms_credit', 0)  }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- row 2 --}}
                <div class="row">
                    {{-- daily application summery --}}
                    <div class="col-sm-3">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">Daily Applications</h3>
                            </div>
                            <ul class="list-group">
                                @foreach ($daily_enrollments as $date=>$total)
                                    <li class="list-group-item">
                                        <span class="badge">{{$total}}</span>
                                        {{$date}}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- daily application bar --}}
                    <div class="col-sm-9">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Daily Applications</h3>
                            </div>
                            <div class="panel-body" id="daily-applications" style="height: 250px;">
                            </div>
                            <div class="panel-footer">
                                <b>Total : {{number_format (array_sum($daily_enrollments->toArray()),0,'',',')}}</b>
                            </div>
                        </div>
                    </div>

                    @role('Admin')
                        <div class="col-sm-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Bill Summary</h3>
                                </div>
                                <ul class="list-group">
                                    @foreach ($bills as $payment_status=>$total)
                                        <li class="list-group-item">
                                            <span class="badge">{{$total}}</span>
                                            @if ($payment_status=='1')
                                                Paid
                                            @elseif ($payment_status=='0')
                                                Pending
                                            @else
                                                Canceled
                                            @endif

                                        </li>
                                    @endforeach
                                    <li class="list-group-item">
                                        <span class="badge">{{array_sum($bills->toArray())}}</span>
                                        <b>Total Bill</b>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endrole
                    <div class="col-sm-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"> Application Summery</h3>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Unit</th>
                                    <th>Commerce</th>
                                    <th>Humanities</th>
                                    <th>Science</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($applicationByGroup as $application)
                                    <tr>
                                        <td><b>{{$application[0]['unit']}}</b></td>
                                        <td>{{$application[0]['total']?? 0}}</td>
                                        <td>{{$application[1]['total']?? 0}}</td>
                                        <td>{{$application[2]['total']?? 0}}</td>
                                        <td>
                                            <span
                                                class="badge">{{($application[0]['total'] ?? 0) +($application[1]['total'] ?? 0) + ($application[2]['total']??0) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>


                </div>


                {{-- row 3 --}}
                <div class="row">


                    {{--bill summery--}}

                    {{-- Preliminary application summery --}}
                    {{--                    <div class="col-sm-6">--}}
                    {{--                        <div class="panel panel-primary">--}}
                    {{--                            <div class="panel-heading">--}}
                    {{--                                <h3 class="panel-title">Preliminary Applications</h3>--}}
                    {{--                            </div>--}}
                    {{--                            <table class="table table-striped">--}}
                    {{--                                <thead>--}}
                    {{--                                <tr>--}}
                    {{--                                    <th>Unit</th>--}}
                    {{--                                    <th>Commerce</th>--}}
                    {{--                                    <th>Humanities</th>--}}
                    {{--                                    <th>Science</th>--}}
                    {{--                                    <th>Total</th>--}}
                    {{--                                </tr>--}}
                    {{--                                </thead>--}}
                    {{--                                <tbody>--}}
                    {{--                                @foreach ($prili_brakdown as $preli)--}}
                    {{--                                    <tr>--}}
                    {{--                                        <td><b>{{$preli[0]['unit']}}</b></td>--}}
                    {{--                                        <td>{{$preli[0]['total']}}</td>--}}
                    {{--                                        <td>{{$preli[1]['total']}}</td>--}}
                    {{--                                        <td>{{$preli[2]['total']}}</td>--}}
                    {{--                                        <td><span class="badge">{{$preli[0]['total']+$preli[1]['total']+$preli[2]['total']}}</span></td>--}}
                    {{--                                    </tr>--}}
                    {{--                                @endforeach--}}
                    {{--                                </tbody>--}}
                    {{--                            </table>--}}

                    {{--                        </div>--}}
                    {{--                    </div>--}}

                    {{--
                    {{--                        <div class="col-sm-3">--}}
                    {{--                            <div class="panel panel-primary">--}}
                    {{--                                <div class="panel-heading">--}}
                    {{--                                    <h3 class="panel-title">Bill Summary :: Total</h3>--}}
                    {{--                                </div>--}}
                    {{--                                <ul class="list-group">--}}
                    {{--                                    @foreach ($bills as $payment_status=>$total)--}}
                    {{--                                        <li class="list-group-item">--}}
                    {{--                                            <span class="badge">{{$total}}</span>--}}
                    {{--                                            @if ($payment_status=='1')--}}
                    {{--                                                Paid--}}
                    {{--                                            @elseif ($payment_status=='0')--}}
                    {{--                                                Pending--}}
                    {{--                                            @else--}}
                    {{--                                                Canceled--}}
                    {{--                                            @endif--}}
                    {{--                                            --}}{{-- Unit - {{$payment_status}} --}}
                    {{--                                        </li>--}}
                    {{--                                    @endforeach--}}
                    {{--                                    <li class="list-group-item">--}}
                    {{--                                        <span class="badge">{{array_sum($bills)}}</span>--}}
                    {{--                                        <b>Total Bill</b>--}}
                    {{--                                    </li>--}}
                    {{--                                    <li class="list-group-item">--}}
                    {{--                                        <span class="badge">TK. {{number_format ($total_payment,0,'',',')}}</span>--}}
                    {{--                                        <b>Paid Amount</b>--}}
                    {{--                                    </li>--}}
                    {{--                                </ul>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    @endif--}}
                </div>

                {{-- row 4 --}}

                {{--        <pre>--}}
                {{--            {{print_r($applications_brakdown)}}--}}
                {{--        </pre>--}}
                {{--                <div class="row">--}}
                {{--                    --}}{{-- application summery --}}
                {{--                    <div class="col-sm-6">--}}
                {{--                        <div class="panel panel-primary">--}}
                {{--                            <div class="panel-heading">--}}
                {{--                                <h3 class="panel-title">Final Applications</h3>--}}
                {{--                            </div>--}}
                {{--                            <table class="table table-striped">--}}
                {{--                                <thead>--}}
                {{--                                <tr>--}}
                {{--                                    <th>Unit</th>--}}
                {{--                                    <th>Commerce</th>--}}
                {{--                                    <th>Humanities</th>--}}
                {{--                                    <th>Science</th>--}}
                {{--                                    <th>Total</th>--}}
                {{--                                    <th>Remaining</th>--}}
                {{--                                </tr>--}}
                {{--                                </thead>--}}
                {{--                                <tbody>--}}
                {{--                                @foreach ($applications_breakdown as $app_breakdown)--}}
                {{--                                    <tr>--}}
                {{--                                        <td><b>{{$app_breakdown[0]['unit']}}</b></td>--}}
                {{--                                        <td>{{$app_breakdown[0]['total']}}</td>--}}
                {{--                                        <td>{{$app_breakdown[1]['total']}}</td>--}}
                {{--                                        <td>{{$app_breakdown[2]['total']}}</td>--}}
                {{--                                        <td><span class="label label-primary">{{$app_breakdown['unit_total']}}</span></td>--}}
                {{--                                        <td><span class="label label-success">{{$app_breakdown['unit_remaining']}}</span></td>--}}
                {{--                                    </tr>--}}
                {{--                                @endforeach--}}
                {{--                                </tbody>--}}
                {{--                            </table>--}}

                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            @endif
        </div>
    </div>

@stop

@section('script-extra')
    {{ Html::script('assets/plugins/morris-js/raphael-min.js') }}
    {{ Html::script('assets/plugins/morris-js/morris.min.js') }}

    <script type="text/javascript">
        $(document).ready(function () {
            $(window).resize(function () {
                window.applications.redraw();
                window.payment.redraw();
                window.unit.redraw();
            });


            window.unit = Morris.Bar({
                element: 'unit-summery',
                data: [
                        @foreach ($enrollments as $unit=>$total)
                    {
                        unit: '{{$unit}}', total: {{$total}}
                    },
                    @endforeach
                ],
                xkey: 'unit',
                ykeys: ['total'],
                labels: ['total'],
                barColors: ["#1AB244"],
            });

            window.applications = Morris.Line({
                element: 'daily-applications',
                data: [
                        @foreach ($daily_enrollments as $date=>$total)
                    {
                        date: '{{$date}}', total: {{$total}}
                    },
                    @endforeach
                ],
                xkey: 'date',
                ykeys: ['total'],
                labels: ['Total'],
                xLabelAngle: 45
            });

            {{--window.payment=Morris.Donut({--}}
            {{--    element: 'payment-summary',--}}
            {{--    data: [--}}
            {{--            @foreach ($payment_summary as $method=>$total)--}}
            {{--        { label: '{{$method}}', value: {{round($total)}} },--}}
            {{--        @endforeach--}}
            {{--    ],--}}
            {{--    colors:["#E3106E","#89288F", "#FFD400" ]--}}
            {{--});--}}

        });

    </script>

@stop

@section('css-extra')
    {{ Html::style('assets/plugins/morris-js/morris.css') }}
    {{-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css"> --}}
@stop
