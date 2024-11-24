@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">

            @if (Session::has('oth_success') && Session::get('oth_success')==1)
                <blockquote class="alert-success">
                    <strong> <i class="fa fa-check-circle"></i> আপনার সকল তথ্য সঠিক ভাবে গৃহীত হয়েছে</strong>
                </blockquote>

                <div class="panel panel-success">
                    <div class="panel-body">
                        <h4>
                            আপনার প্রদত্ত তথ্য যাচাই করার পর ৪৮ ঘন্টার মধ্যে আমাদের সিস্টেমে আপডেট
                            করা হবে ও আপনার প্রদত্ত মোবাইল নম্বরে যোগাযোগ করা হবে। তথ্য আপডেট হওয়ার পরে
                            স্বাভাবিক নিয়মে আবেদন করুন।
                        </h4>
                        <br>
                        <div class="alert alert-danger">
                            <p>
                                <i class="fa fa-asterisk"></i> সিস্টেমে তথ্য আপডেট হওয়ার আগে নতুন করে আর আবেদন না করার
                                জন্য জানানো হচ্ছে।<br>
                                <i class="fa fa-asterisk"></i> নির্ধারিত সময়ের মধ্যে তথ্য আপডেট না হলে হেল্পলাইনে
                                যোগাযোগ করুন।
                            </p>
                        </div>
                    </div>
                </div>
                <p class="text-center"><a class="btn btn-success" href="{{ route('site.home') }}"><i
                            class="fa fa-home"></i> Back to Home Page</a></p>
            @else
                <blockquote class="alert-success">
                    <strong> <i class="fa fa-check"></i> Internal server error. Please try after some times</strong>
                </blockquote>
            @endif


        </div>
    </div>
@stop
