@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
<div class="panel panel-default">
    <div class="panel-body">
        {{-- <pre>
            {{print_r($subjectOption)}}
        </pre> --}}
        {{-- Message --}}
        @if (Session::has('other-message'))
        <div class="alert alert-danger">
            <strong><i class="fa fa-exclamation-circle"></i> {{Session::get('other-message')}}</strong>
        </div>
        @endif
        {{-- Subject Choice --}}
        <legend><i class="fa fa-credit-card"></i> Subject Choice for Unit {{$subjectOption->unit}}</legend>
        {{-- choice  list --}}

        <div class="alert alert-danger">
            <b>Subject Choice -এর এই পেজটি মোবাইল ফোনের উপযোগী নয়। সঠিক ভাবে সাবজেক্ট চয়েস পূরণের জন্য প্রার্থীদের কম্পিউটার/ল্যাপটপ ব্যবহার
            করতে পরামর্শ দেওয়া হচ্ছে।</b>
        </div>

        <div class="alert alert-info">
            <strong>
                    1. নিচের বাম দিকের বাক্স থেকে পছন্দের ক্রম অনুযায়ী সাবজেক্ট / সাবজেক্টসমূহ সিলেক্ট করে <span class="label label-default"> <i class="glyphicon glyphicon-chevron-right"></i></span>  তে ক্লিক দিয়ে ডান দিকের বক্সে আনুন।
                    <br>
                    2. অধিকতর পছন্দের সাবজেক্ট ডান দিকের বক্সের উপরের দিকে থাকবে।
                    <br>
                    3. ডান দিকের বক্সের নিচের <span class="label label-default"> <i class="glyphicon glyphicon-arrow-up"></i></span>  বা <span class="label label-default"> <i class="glyphicon glyphicon-arrow-down"></i></span> তে ক্লিক দিয়ে পছন্দের সাবজেক্টের ক্রম পরিবর্তন করতে পারবেন।
            </strong>
        </div>
        <form action='{{ route('subject_choice.postSubjectChoiceForm')}}' method="POST" id="choice_form" >
            {{csrf_field()}}
            <input type="hidden" name="subject_option_id" value="{{$subjectOption->id}}">
            <div class="row">
                <div class="col-sm-5">
                    <p><strong>সাবজেক্ট সমূহ</strong></p>
                    {{Form::select('from[]', $subjects, false, [  'id'=>'multiselect',
                                                                'class'=>'form-control',
                                                                'size'=>count($subjects)+2,
                                                                'multiple'=>'true'])}}

                </div>

                <div class="col-sm-2">
                    <br><br>
                    {{-- <button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button> --}}
                    <button type="button" id="multiselect_rightSelected" class="btn btn-block btn-primary"><i class="glyphicon glyphicon-chevron-right"></i></button>
                    <button type="button" id="multiselect_leftSelected" class="btn btn-block btn-danger"><i class="glyphicon glyphicon-chevron-left"></i></button>
                    {{-- <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button> --}}
                </div>

                <div class="col-sm-5">
                    <p><strong>পছন্দক্রম</strong></p>
                    {{Form::select('to[]', [], false, [  'id'=>'multiselect_to',
                                                                'class'=>'form-control',
                                                                'size'=>count($subjects)+2,
                                                                'multiple'=>'true'])}}


                    <div class="row">
                        <div class="col-sm-6">
                            <button type="button" id="multiselect_move_up" class="btn btn-block"><i class="glyphicon glyphicon-arrow-up"></i></button>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" id="multiselect_move_down" class="btn btn-block col-sm-6"><i class="glyphicon glyphicon-arrow-down"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Submit  --}}
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    <p class="text-right">
                        <a class="btn btn-danger" href="{{ route('student.getDashboard') }}"><i class="fa fa-arrow-left"></i> Back</a>
                        <button type="submit" class="btn btn-primary" >Next <i class="fa fa-arrow-right"></i></button>
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>{{-- panel-default --}}
@stop

@section('script-extra')
{{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
{{ Html::script('assets/plugins/jquery-multiselect/multiselect.min.js') }}

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#multiselect').multiselect({
            sort: false,
            submitAllLeft:false,
            submitAllRight:true
        });
    });


    $(document).on('submit','#choice_form',function(){

        if( $('#multiselect_to').has('option').length <= 0 ){
            alert('বাম দিকের বক্স থেকে সাবজেক্ট সিলেক্ট করে ডান দিকের বক্সে আনুন')
            return false;
        }

        @if ($subjectOption->unit == 'C')
            if( $('#multiselect').has('option').length > 0 ){
                var response= prompt('আপনি কেবলমাত্র ডানদিকের সিলেক্ট করা সাবজেক্টগুলোতে ভর্তির জন্য বিবেচিত হবেন।'+
                                    '\n সম্মত থাকলে নিচের বাক্সে YES টাইপ করে OK ক্লিক করুন।'+
                                    '\n অন্যথায় Cancel এ ক্লিক করে পছন্দক্রম পরিবর্তন করুন।');

                if( response != null && response.toUpperCase() =='YES' ){
                    return true;

                }

                return false;
            }
        @else
            if( $('#multiselect').has('option').length > 0 ){
                alert('বাম দিকের বক্স থেকে অবশিষ্ট সাবজেক্ট সিলেক্ট করে ডান দিকের বক্সে আনুন')
                return false;
            }

        @endif

        return true;

    });

</script>

@stop
