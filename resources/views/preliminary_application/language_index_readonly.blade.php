@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">


            {{-- quotas --}}
            <legend><i class="fa fa-credit-card"></i> প্রশ্নপত্রের ভাষা</legend>
            {{-- quota list --}}
            <div class="row">
                <div class="col-sm-12">

                    <div class="alert alert-danger">
                        <p style="line-height:1.3em">প্রশ্নপত্রের ভাষা পরিবর্তন করতে নিচের "Unlock Language Update" তে ক্লিক করুন।

                        </p>
                    </div>
                    <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" id="route" name="route" value="{{route('preliminary.getLanguageIndex')}}">
                    @include('preliminary_application.verification_popup')
                    <p>
                        <a class="btn btn-danger" data-toggle="modal" href='#modal-id'><i class="fa fa-lock"></i> Unlock Language Update</a>
                    </p>

                    <table class="table table-hover table-striped table-bordered table-condensed" disabled>
                        <thead>
                        <tr>
                            <th>প্রশ্নপত্রের ভাষা</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tr>
                            <td>{{$student->is_english? 'ইংরেজি': 'বাংলা'}}</td>
                            <td>
                                <a class="btn btn-danger btn-sm" href="#" disabled><i class="fa fa-edit"></i> Change</a>
                            </td>
                        </tr>
                    </table>



{{--                    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">--}}
{{--                    @if(session('authorize_this_session',0))--}}
{{--                        @include('preliminary_application.quota_list_editable', ['student' => $student, 'quotas'=>$quotas])--}}
{{--                    @else--}}
{{--                        @include('preliminary_application.quota_list_readonly', ['student' => $student, 'quotas'=>$quotas])--}}
{{--                    @endif--}}

                </div>
            </div>
            {{-- Submit  --}}
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    {{-- <input type="hidden" name="mobile_no" value="{{$student->mobile_no}}"> --}}
                    <p class="text-right">
                        <a class="btn btn-danger" href="{{ route('student.getDashboard') }}"><i
                                class="fa fa-home"></i> Back</a>
                        @if( !session()->missing('inputs.units') )
                            <a class="btn btn-primary" href="{{ route('preliminary.getConfirmation') }}">
                                Next <i class="fa fa-long-arrow-right"></i> </a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>{{-- panel-default --}}
@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
@stop
