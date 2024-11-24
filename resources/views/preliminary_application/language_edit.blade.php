@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">


            {{-- quotas --}}
            <legend><i class="fa fa-font"></i> প্রশ্নপত্রের ভাষা</legend>
            {{-- quota list --}}
            <div class="row">
                <div class="col-sm-12">

                    {{Form::open( array('route'=>'preliminary.postSaveLanguage') )}}
                    <h4>ভর্তি পরীক্ষায় আপনি কোন ভাষায় লিখিত প্রশ্নপত্রে পরীক্ষা দিতে ইচ্ছুক?</h4>
                    <div class="radio">
                        <label>
                            <input type="radio" name="question_type" id="input" value="BN" @if($student->is_english=='0') checked @endif >
                            বাংলা
                        </label>
                    </div>

                    <div class="radio">
                        <label>
                            <input type="radio" name="question_type" id="input" value="EN" @if($student->is_english=='1') checked @endif >
                            ইংরেজি
                        </label>
                    </div>

                    <hr>
                    <a href="{{route('preliminary.getLanguageIndex')}}" class="btn btn-danger" >Back</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
                    {{ Form::close()}}

                </div>
            </div>
            {{-- Submit  --}}

        </div>
    </div>{{-- panel-default --}}
@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
@stop
