@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body full-height">
            <legend>
                <i class="fa fa-dashboard"></i> Unit Dashboard [Unit-{{auth()->user()->unit->unit_name}} ]
            </legend>

            <div class="alert alert-info text-right">
                <a class="btn btn-primary btn-sm" href="{{ route('unit-office.downloadStudentData') }}" role="button"><i
                        class="fa fa-file-excel-o"></i> Download All Student Data</a>
            </div>

            {{-- row 1 --}}
            <div class="row">
                {{-- pending students --}}
                <div class="col-sm-6">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-exclamation-circle"></i> Pending For Approvals</h3>
                        </div>

                        <ul class="list-group">
                            @foreach ($unit_pending_students as $unit_student)
                                <li class="list-group-item">
                                    {{$unit_student->admission_subject->name}}<span
                                        class="badge">{{$unit_student->total}}</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="panel-footer text-right">
                            <b>Total : {{$unit_pending_students->sum('total')}}</b>
                        </div>
                    </div>
                </div>

                {{-- Total Admission SUmmery summery --}}
                <div class="col-sm-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-check-circle-o"></i> Approved By Units</h3>
                        </div>
                        <ul class="list-group">
                            @foreach ($unit_approved_students as $unit_student)
                                <li class="list-group-item">
                                    <span class="badge">{{$unit_student->total}}</span>
                                    @if ($unit_student->admission_subject)
                                        [{{$unit_student->admission_subject->dept_code}}
                                        ] {{$unit_student->admission_subject->name}}
                                    @else
                                        {{$unit_student->admission_subject}}
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                        <div class="panel-footer text-right">
                            <b>Total : {{$unit_approved_students->sum('total')}}</b>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

@stop

@section('script-extra')

@stop

@section('css-extra')
    {{-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css"> --}}
@stop
