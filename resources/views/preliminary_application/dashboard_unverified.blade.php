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

                        {{--                        Unit list--}}
                        <legend id="apply"><i class="fa fa-table"></i> প্রাথমিক আবেদনযোগ্য ইউনিট সমূহ</legend>

                        @if ( array_sum($eligibility) <= 0 )
                            {{--not eligible in any unit--}}
                            <blockquote class="alert-danger">
                                রাজশাহী বিশ্ববিদ্যালয়ে ভর্তির জন্য প্রয়োজনীয় GPA না থাকায় আপনি কোন ইউনিটে আবেদনের জন্য
                                বিবেচিত হননি।
                            </blockquote>
                        @else
                            {{--eligible in at least one unit--}}
                            <h4 class="alert alert-info" style="line-height: 1.3em">
                                আপনি রাজশাহী বিশ্ববিদ্যালয়ে নিচের ইউনিট গুলিতে ভর্তির প্রাথমিক আবেদন করতে পারবেন। আবেদনের পূর্বে
                                আপনার মোবাইল নম্বর নিশ্চিত করতে নিচের "Mobile No. Verification" লিংকে যান

                                <hr>
                                <p class="text-center">
                                    <a class="btn btn-primary" href="{{route('identity_verification.index')}}">Mobile No. Verification</a>
                                </p>
                            </h4>

                            <div id="message"></div>
                            <table class="table  table-hover table-bordered">
                                <thead>
                                <tr class="bg-primary">
                                    <th>Unit</th>
                                    <th>Faculty/Institute</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($eligibility as $unit=> $value)
                                    @if ($value != 0)
                                        <tr>
                                            <td>Unit - {{$unit}}</td>
                                            <td>{{$unitNames[$unit]}}</td>
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
