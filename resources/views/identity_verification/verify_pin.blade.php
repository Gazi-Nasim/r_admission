@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default full-height">

        <div class="panel-body">
            <legend><i class="fa fa-mobile"></i> মোবাইল নম্বর ভেরিফিকেশন</legend>
            {{--<pre>
                {{print_r(session('verification'))}}
            </pre>--}}
            <div class="row">
                <div class="col-sm-12">
                    <blockquote class="alert-success">
                        আপনার
                        @if(session('verification_type') == 'mobile')
                            মোবাইল ফোনে
                        @else
                            ইমেইল ঠিকানায়
                        @endif
                        <u>একটি OTP কোড</u> পাঠানো হয়েছে। প্রাপ্ত OTP টি
                        নিচের বক্সে লিখে "Verify OTP" এ ক্লিক করে কোডটি নিশ্চিত করুন ।  ভুল
                        হলে "Edit" লিংকে গিয়ে নম্বরটি সংশোধন করুন।
                    </blockquote>

                    @if(session('verification_type') == 'email')
                        <h4 class="alert alert-warning">
                            আপনার ইমেইল Inbox এ ভেরিফিকেশন কোডের মেইল না পেলে আপনার ইমেইল এর Spam ফোল্ডার এ খোঁজ করুন ।
                        </h4>
                    @endif


                    <div class="row">
                        <div class="col-sm-12">

                            {{Form::open(['route'=>'identity_verification.postVerifyPin', 'class'=>'form-horizontal well'])}}
                            <div class="form-group">
                                @if(session('verification_type') == 'mobile')
                                    <label for="mobile_no" class="control-label col-sm-3">Mobile No.</label>
                                    <div class="col-sm-6">
                                        <p>{{$verification['data']['mobile_no']}} <a
                                                href="{{ route('identity_verification.getMobile') }}"> <i class="fa fa-edit"></i> Edit
                                                </a></p>
                                    </div>
                                @else
                                    <label for="mobile_no" class="control-label col-sm-3">Email</label>
                                    <div class="col-sm-6">
                                        <p> {{$verification['data']['email']}}<a href="{{ route('identity_verification.getEmail') }}">
                                                <i class="fa fa-edit"></i> Edit
                                                </a></p>
                                    </div>
                                @endif
                            </div>
                            <br>
                            <div class="form-group @if ($errors->has('verification_code')) has-error @endif">
                                <label for="mobile_pin" class="control-label col-sm-3">Enter OTP</label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        {{ Form::text( 'verification_code', old('verification_code') , ['id'=>'verification_code','class' => 'form-control','placeholder'=>"Enter OTP code", 'autocomplete'=>'off']) }}
                                        <span class="input-group-btn">
                                        <button class="btn btn-primary"> <i class="fa fa-check-circle"></i> Verify OTP</button>
                                    </span>
                                    </div>
                                    {!! $errors->first('verification_code','<span id="help-mobile_no" class="help-block">:message</span>') !!}
                                </div>
                            </div>


                            {{--<div class="form-group @if ($errors->has('verification_code')) has-error @endif">
                                <label for="mobile_pin" class="control-label col-sm-3">Your OTP</label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <div class="alert alert-info">
                                            @if(session('verification_type') == 'mobile')
                                            উপরের বক্সে আপনার OTP হিসাবে <b style="font-size: 2em">{{$verification['data']['mobile_verification_code']}}</b> টাইপ করুন।
                                            @elseif(session('verification_type') == 'email')
                                            উপরের বক্সে আপনার OTP হিসাবে <b style="font-size: 2em">{{$verification['data']['email_verification_code']}}</b> টাইপ করুন।
                                            @endif
                                            <br><br><span class="text-danger"><b> <i
                                                        class="fa fa-exclamation-triangle"></i> চুড়ান্ত আবেদনের সময় আপনাকে আবার OTP এর মাধ্যমে মোবাইল নম্বর ভেরিফাই করতে হবে।</b></span>
                                        </div>
                                    </div>
                                </div>
                            </div>--}}

                            {{Form::close()}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>{{-- panel-default --}}

    {{-- @include('applications.popup',['title'=>'মোবাইল নম্বর নিশ্চিতকরণ']) --}}

@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-0.4.10.js') }}
@stop



