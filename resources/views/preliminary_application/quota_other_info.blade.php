@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">

       {{-- <pre>
            {{print_r(session()->all(), true)}}
        </pre>--}}

            {{-- Message --}}
            @if (Session::has('other-message'))
                <div class="alert alert-danger">
                    <strong><i class="fa fa-exclamation-circle"></i> {{session('other-message')}}</strong>
                </div>
            @endif
            <br>
            {{-- quotas --}}
            <legend><i class="fa fa-credit-card"></i> কোটা সংক্রান্ত তথ্য</legend>
            {{-- quota list --}}
            <div class="row">
                <div class="col-sm-12">
                    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                    @if(session('authorize_this_session',0))
                        @include('preliminary_application.quota_list_editable', ['student' => $student, 'quotas'=>$quotas])
                    @else
                        @include('preliminary_application.quota_list_readonly', ['student' => $student, 'quotas'=>$quotas])
                    @endif

{{--                    @if ($student->hasQuota() && $student?->enrollments?->count() >0 )--}}
{{--                        --}}{{-- student is already enrolled --}}
{{--                        @if(session('authorize_this_session',0))--}}
{{--                            @include('preliminary_application.quota_list_editable', ['student' => $student, 'quotas'=>$quotas])--}}
{{--                        @else--}}
{{--                            @include('preliminary_application.quota_list_readonly', ['student' => $student, 'quotas'=>$quotas])--}}
{{--                        @endif--}}
{{--                    @else--}}
{{--                        @include('preliminary_application.quota_list_editable', ['student' => $student, 'quotas'=>$quotas])--}}
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
                                Skip This Step <i class="fa fa-long-arrow-right"></i> </a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>{{-- panel-default --}}
@stop

@section('css-extra')
    <style type="text/css">
        .fileinput-button {
            position: relative;
            overflow: hidden;
        }

        .fileinput-item {
            position: absolute;
            font-size: 50px;
            opacity: 0;
            right: 0;
            top: 0;

        }
    </style>
@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}

    <script type="text/javascript">
        $(document).ready(function () {
            $('#FFQ').click(function () {
                $('#quota-ffq').toggle();
                $('#ffq_type1').prop('checked', false);
                $('#ffq_type2').prop('checked', false);
                $('#ffq_number').prop('value', '');

            });

            $('#WQ').click(function () {
                $('#quota-wq').toggle();
                $('#wq_salary_id').prop('value', '');
                // trigger enter key pressed

            });


            $('#form').submit(function (event) {
                if ($('#FFQ').prop('checked')) {

                    console.log()

                    if (!$('#ffq_type1').prop('checked') && !$('#ffq_type2').prop('checked')) {
                        alert('Please select FFQ quota type')
                        return false
                    }
                }
            });
        });

    </script>

@stop
