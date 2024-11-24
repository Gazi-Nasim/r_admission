@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default full-height">

        <div class="panel-body">
            <legend><i class="fa fa-mobile"></i> মোবাইল নম্বর ভেরিফিকেশন</legend>


            <div class="row">
                <div class="col-sm-12">
                    <blockquote class="alert-warning">
                        ভর্তি পরীক্ষার আবেদন শুরু করার পূর্বে আপনার মোবাইল নম্বর নিশ্চিত করুন।
                        <br><br>
                        <ul>
                            <li><b class="text-danger">মোবাইল নম্বরটি অবশ্যই প্রার্থীর নিজের অথবা অভিভাবকের হতে
                                    হবে । </b></li>
                            {{--<li>প্রার্থী ভর্তি পরিক্ষায় অংশগ্রহণের জন্য বিবেচিত হলে প্রদত্ত মোবাইল নম্বর/ইমেইল এ যোগাযোগ করা
                                হবে।
                            </li>--}}
                            <li><u>একই মোবাইল নম্বর একাধিক প্রার্থীর জন্য ব্যবহার করা যাবে না।</u></li>

                        </ul>
                        <br>
                        <p class="alert alert-danger">মোবাইল নম্বর সতর্কতার সাথে প্রদান করুন। মোবাইল নম্বর
                            প্রদানের পর ভুল হলে তা সংশোধন করার পদ্ধতি অত্যন্ত জটিল।</p>

                    </blockquote>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-primary rounded">
                        <div class="panel-body">
                            মোবাইল নম্বর ভেরিফিকেশনের জন্য আপনার ব্যক্তিগত অথবা অভিভাবকের মোবাইল নম্বরটি পরবর্তী
                            পেজে প্রদান করুন। মোবাইল নম্বর নিশ্চিত করার জন্য আপনার মোবাইলে একটি ভেরিফিকেশন
                            কোড পাঠানো হবে।
                            <hr>
                            <div class="text-center">
                                @if($student->mobile_no_verified)
                                    <div class="alert alert-success rounded">
                                        <i class="fa fa-check-circle"></i>
                                        <b>মোবাইল নম্বর নিশ্চিত করা হয়েছে</b>
                                    </div>
                                @else
                                    <a class="btn btn-primary rounded btn-lg btn-block"
                                       href="{{ route('identity_verification.getMobile') }}">মোবাইল নম্বর নিশ্চিত
                                        করুন</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

{{--                <div class="col-md-5">--}}
{{--                    <div class="panel panel-primary rounded">--}}
{{--                        <div class="panel-body">--}}
{{--                            ইমেইল ভেরিফিকেশনের জন্য আপনার ইমেইল ঠিকানা পরবর্তী পেজে প্রদান করুন। ইমেইল ঠিকানা নিশ্চিত--}}
{{--                            করার জন্য আপনার ইমেইল এ একটি ভেরিফিকেশন কোড পাঠানো হবে।<br><br>--}}
{{--                            <hr>--}}
{{--                            <div class="text-center">--}}
{{--                                @if($student->email_verified)--}}
{{--                                    <div class="alert alert-success rounded">--}}
{{--                                        <i class="fa fa-check-circle"></i>--}}
{{--                                        <b>Email Verified</b>--}}
{{--                                    </div>--}}
{{--                                @else--}}
{{--                                    <a class="btn btn-primary btn-lg btn-block rounded"--}}
{{--                                       href="{{ route('identity_verification.getEmail') }}">ইমেইল--}}
{{--                                        ভেরিফিকেশন</a>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}


            </div>

        </div>
    </div>{{-- panel-default --}}

    {{-- @include('applications.popup',['title'=>'মোবাইল নম্বর নিশ্চিতকরণ']) --}}

@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-0.4.10.js') }}
@stop
