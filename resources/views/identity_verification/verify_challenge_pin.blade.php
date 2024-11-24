@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default full-height">

        <div class="panel-body">
            <legend><i class="fa fa-mobile"></i> মোবাইল নম্বর ভেরিফিকেশন</legend>
{{--            <pre>--}}
{{--                {{print_r(session('verification'))}}--}}
{{--            </pre>--}}
            <div class="row">
                <div class="col-sm-12">
                    <blockquote class="alert-success">
                        আপনার মোবাইল ফোনে
                        <u>একটি OTP কোড </u> পাঠানো হয়েছে। প্রাপ্ত OTP টি
                        নিচের বক্সে লিখে "Verify OTP" এ ক্লিক করে কোডটি নিশ্চিত করুন ।
                    </blockquote>

                    <div class="row">
                        <div class="col-sm-12">

                            {{Form::open(['route'=>'identity_verification.postVerifyChallengePin', 'class'=>'form-horizontal well'])}}
                            <div class="form-group">
                                    <label for="mobile_no" class="control-label col-sm-3">Mobile No.</label>
                                    <div class="col-sm-6">
                                        <input type="text"  class="form-control" value="{{Str::mask($student->mobile_no,'*',3,-2)}}" readonly>
                                    </div>
                            </div>

                            {{--<div class="form-group">
                                <label for="mobile_no" class="control-label col-sm-3">Email</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" value="{{Str::mask($student->email,'*',3,-3)}}" readonly>
                                    </div>
                            </div>--}}
                            <div class="form-group @if ($errors->has('verification_code')) has-error @endif">
                                <label for="mobile_pin" class="control-label col-sm-3">Enter OTP </label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        {{ Form::text( 'verification_code', old('verification_code') , ['id'=>'verification_code','class' => 'form-control','placeholder'=>"Enter OTP", 'autocomplete'=>'off']) }}
                                        <span class="input-group-btn">
                                        <button class="btn btn-primary">Verify</button>
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
                                            উপরের বক্সে আপনার OTP হিসাবে <b style="font-size: 2em">{{$student->mobile_verification_code}}</b> টাইপ করুন।
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



