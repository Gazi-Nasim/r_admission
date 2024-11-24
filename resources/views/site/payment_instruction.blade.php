@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default full-height">
        <div class="panel-body">
            <legend><i class="fa fa-info-circle"></i> Payment Instruction</legend>

            {{--<div class="alert alert-info">
                <strong><h4>১ম বর্ষ স্নাতক সম্মান/স্নাতক শ্রেনীতে ভর্তি প্রক্রিয়া ২০২৩-২৪</h4></strong>
            </div>--}}


            {{-- fees --}}
            {!!$content->content!!}


        </div>
    </div>
@stop

