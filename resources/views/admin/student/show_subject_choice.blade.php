@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">


            {{-- Message --}}
            <div class="alert alert-info">
                <strong>
                    Name: {{$subjectOption->application->name}}
                    Roll: ({{$subjectOption->application->unit}}-{{$subjectOption->application->admission_roll}})
                    @if ($subjectOption->unit =='C' && $subjectOption->student_category_id != null)
                        , [Category: {{$subjectOption->studentCategory->category_name}}]
                    @endif
                </strong>
            </div>
            {{-- Subject Choice --}}
            <legend><i class="fa fa-credit-card"></i> Subject Choice Confirmation for Unit {{$subjectOption->unit}}
            </legend>
            {{-- choice  list --}}

            <p class="text-right">
                <a class="btn btn-sm btn-primary" href="{{ route('admin.student.downloadSubjectChoiceForm',$subjectOption) }}">
                    <i class="fa fa-download"></i> Download Choice Form
                </a>
                {{--<a class="btn btn-sm btn-primary"
                   href="{{ route('hons_admission.download_reg_form',$subjectOption->id) }}">
                    <i class="fa fa-download"></i> Download Admission Form
                </a>--}}
                @if (auth()->user()->hasRole('Admin'))
                    {{--            <a class="btn btn-sm btn-danger" href="{{ route('student.get_subject_change',$subjectOption->id) }}"><i class="fa fa-edit"></i> Update Department</a>--}}
                @endif
            </p>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table table-condensed table-bordered">
                        <thead>
                        <tr>
                            <th>Department</th>
                            <th class="text-center">Choice Serial</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Admission</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($studentChoices as $choice)
                            <tr @if($choice->opt_out != '0') class="bg-danger" @endif >
                                <td>{{$choice->department->name}} ({{$choice->department->dept_code}})</td>
                                <td class="text-center">
                                    @if($choice->opt_out == '0')
                                        {{$choice->priority+1}}
                                    @else
                                        Opt-Out
                                    @endif
                                </td>
                                @if(!empty($choice->selection_status))
                                    <?php
                                    $status = strtoupper(substr($choice->selection_status, 0, 1));
                                    $pos = substr($choice->selection_status, 1);
                                    ?>
                                    <td @if($status === 'S') class="bg-success" @else class="bg-warning" @endif >
                                        @if( $status ==='S')
                                            <b>
                                                SELECTED
                                            </b>
                                        @elseif($status ==='W')
                                            WAITING ({{$pos}})
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($subjectOption->admission_completed && $choice->dept_code == $subjectOption->admission_subject->dept_code)

                                            @if($subjectOption->office_status==1)
                                                ADMITTED
                                            @elseif($subjectOption->office_status==0)
                                                PENDING
                                            @else
                                                -
                                            @endif

                                            @if($subjectOption->migration_stop != null && $subjectOption->migration_stop == $choice->dept_code)
                                                <b class="text-danger"><br>(Migration Stopped)</b>
                                            @endif

                                        @else
                                            -
                                        @endif
                                    </td>
                                @else
                                    <td></td>
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <p class="text-right">
                        {{-- <a class="btn btn-danger" href="{{ route('subject_choice.get_choice_form') }}"><i class="fa fa-arrow-left"></i> Back</a> --}}
                    </p>
                </div>
            </div>


        </div>
    </div>{{-- panel-default --}}
@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}

@stop
