@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default full-height">

        <div class="panel-body">
            <legend><i class="fa fa-credit-card"></i> Subject Choice Complete</legend>

            {{--<pre>
                 {{print_r(session()->all())}}
             </pre>--}}

            @if(session()->has('message'))
                <blockquote class="alert-success">
                    <strong><i class="fa fa-check-circle"></i> {{session('message')}}</strong>
                </blockquote>
            @endif

            <div class="row">

                <div class="col-sm-12">
                    <p class="alert alert-info lead">
                        <b>{{session('subjectOption')->unit}} ইউনিট </b>এর জন্য আপনার Subject Choice ফর্ম সফল ভাবে সাবমিট হয়েছে।
                        ফরমটি ডাউনলোড করতে নিচের Download এ ক্লিক করুন।
                        <br>
                    </p>
                </div>
            </div>

            <div class="row no-print">
                <div class="col-sm-12">
                    <p class="text-center">
                        <a class="btn btn-primary" href="{{ route('subject_choice.downloadChoiceForm', session('subjectOption')->id ) }}" role="button">
                            <i class="fa fa-download"></i> Download
                        </a>
                        <a class="btn btn-success" href="{{ route('student.getDashboard') }}" role="button">
                            <i class="fa fa-home"></i> Back to Student Panel
                        </a>
                    </p>
                </div>
            </div>

        </div>
    </div>{{-- panel-default --}}

    {{-- @include('applications.popup',['title'=>'মোবাইল নম্বর নিশ্চিতকরণ']) --}}

@stop


@section('script-extra')

@stop

