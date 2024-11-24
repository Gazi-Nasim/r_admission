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
                                        Photo Change <span class="badge">0</span>
                                    </p>
                                </div>
                            </div>

                        </div>
                    @endif


                    {{--unit application summery--}}
                    <div @if (Auth::user()->hasRole('Admin')) class="col-sm-6" @else class="col-sm-6" @endif>
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">Unit Summary</h3>
                            </div>
                            <div class="panel-body" id="unit-summery" style="height: 200px;">
                            </div>
                            <div class="panel-footer">
                                <b>Total : {{number_format (array_sum($subjectChoices->toArray()),0,'',',')}}</b>
                            </div>
                        </div>
                    </div>
                    <div @if (Auth::user()->hasRole('Admin')) class="col-sm-3" @else class="col-sm-3" @endif>
                        <div class="panel panel-danger">
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-envelope"></i> SMS Credit<span
                                        class="badge">{{ setting('sms_credit', 0)  }}</span>
                                </a>
                            </div>
                        </div>

                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title">Subject Choice Completed</h3>
                            </div>
                            <div class="list-group">
                                @foreach($subjectChoices as $key=>$subjectChoice)
                                    <a href="#" class="list-group-item">
                                        Unit- {{$key}}<span class="badge">{{ $subjectChoice  }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>


                    </div>
                </div>
                {{-- row 2 --}}


                {{-- row 3 --}}
                <div class="row">


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
                                @foreach ($subjectChoices as $unit=>$total)
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
