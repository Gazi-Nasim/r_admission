@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default full-height">

        <div class="panel-body">
            <legend><i class="fa fa-envelope"></i> ইমেইল ভেরিফিকেশন</legend>

            <div class="row">
                <div class="col-sm-12">
                    <blockquote class="alert-warning">
                        ভর্তি পরীক্ষা জন্য আবেদন শুরু করার পূর্বে আপনার ইমেইল ঠিকানা নিশ্চিত করুন।
                        <br><br>
                        <ul>
                            <li><b class="text-danger">ইমেইল ঠিকানাটি অবশ্যই প্রার্থীর নিজের অথবা অভিভাবকের হতে
                                    হবে । </b></li>
                            {{--<li>প্রার্থী ভর্তি পরিক্ষায় অংশগ্রহণের জন্য বিবেচিত হলে প্রদত্ত ইমেইল মাধ্যমে এ যোগাযোগ করা
                                হবে।
                            </li>--}}
                            <li><u>একই ইমেইল ঠিকানা একাধিক প্রার্থীর জন্য ব্যবহার করা যাবে না।</u></li>

                        </ul>
                        <br>
                        <p class="alert alert-danger">ইমেইল সতর্কতার সাথে প্রদান করুন।
                            প্রদানের পর ভুল হলে তা সংশোধন করার পদ্ধতি অত্যন্ত জটিল।</p>

                    </blockquote>

                    {{Form::open(['route'=>'identity_verification.postVerifyMobileOrEmail', 'class'=>'form-horizontal well'])}}
                    {{Form::hidden('type', 'email')}}
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group @if ($errors->has('email')) has-error @endif">
                                <label for="email" class="control-label col-sm-3">Enter your Email.</label>
                                <div class="col-sm-6">
                                    <div class="input-group" id="input-pane">
                                        {{ Form::text( 'email', old('email') , ['id'=>'email','class' => 'form-control','placeholder'=>"Confirm Email Address", 'autocomplete'=>'on']) }}
                                        <span class="input-group-btn">
								        <a class="btn btn-primary" data-toggle="modal" href='#modal-id'>Submit</a>
                                            {{--<button class="btn btn-primary" type="submit">Submit</button>--}}
								    </span>
                                    </div>
                                    {!! $errors->first('email','<span id="help-mobile_no" class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modal-id">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-warning">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">ইমেইল ভেরিফিকেশন</h4>
                                </div>
                                <div class="modal-body">
                                    <h4><i class="fa fa-exclamation-circle"></i> আপনার প্রদত্ত ইমেইল ঠিকানায় এখন একটি
                                        ভেরিফিকেশন কোড পাঠানো হবে।</h4>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i> বাতিল করুন</button>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i> কোড পাঠান</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{Form::close()}}

                </div>
            </div>
        </div>
    </div>{{-- panel-default --}}

    {{-- @include('applications.popup',['title'=>'মোবাইল নম্বর নিশ্চিতকরণ']) --}}

@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-0.4.10.js') }}
@stop
