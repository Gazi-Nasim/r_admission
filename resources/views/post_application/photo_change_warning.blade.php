@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default full-height">

        <div class="panel-body">
            <legend><i class="fa fa-info-circle"></i> Student Information</legend>


            @if ($student->photo_status == NULL || $student->selfie_status == NULL)
                <div class="alert alert-danger" style="font-size: 1.2em">
                    <strong>
                        আপনার ফটো/সেলফি পরীক্ষা করে দেখা হচ্ছে। দয়া করে কিছুক্ষণ পরে প্রবেশপত্র ডাউনলোড করুন।
                    </strong>
                </div>
            @else
                <div class="alert alert-danger" style="font-size: 1.2em">
                    <p>আপনার প্রদত্ত ফটো/সেলফি রাজশাহী বিশ্ববিদ্যালয়ের ভর্তি আবেদন গাইডলাইন অনুযায়ী বাতিল
                        হয়েছে। নির্ধারিত ফি প্রদান সাপেক্ষে আপনার ফটো/সেলফি ভর্তি পরীক্ষা হলে সংগ্রহ করে পরীক্ষায়
                        অংশগ্রহণের সুযোগ দেওয়া হবে। <b>নিচের লিঙ্কে ক্লিক করে ফটো/সেলফি কালেকশন ফি ০৪/০৩/২০২৪ দুপর
                            ১২:০০টার মধ্যে প্রদান করে প্রবেশপত্র ডাউনলোড করতে হবে</b>
                    </p>

                    <br>
                    <form class="form" method="post" action="{{ route('rocket.pay') }}">
                        @csrf
                        <div class="text-center">
                            <input type="hidden" name="bill_id" id="bill_id" value="{{$photoRejectBill->id}}">
                            <button type="submit" class="btn btn-purple "><i class="fa fa-money"></i>
                                Pay Onsite Photo/Selfie Collection Fee
                            </button>
                        </div>
                    </form>

                </div>

            @endif


            @include('preliminary_application.student_info_partial')
            <div class="row">
                <div class="col-sm-12">
                    <p class="text-right">
                        <a class="btn btn-primary" href="{{ route('post_application.getDashboard') }}" role="button">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>{{-- panel-default --}}

@stop


@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
@stop

