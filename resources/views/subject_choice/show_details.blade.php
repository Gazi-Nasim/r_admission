@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
    <div class="panel panel-default">

        <div class="panel-body">

            {{-- Subject Choice --}}
            <legend><i class="fa fa-credit-card"></i> Subject Choice Confirmation for Unit {{$subjectOption->unit}}
            </legend>
            {{-- choice  list --}}

            <div class="row">
                <div class="col-sm-12">
                    <p class="text-right">
                        <a class="btn btn-danger btn-xs" href="{{ route('student.getDashboard') }}"><i
                                class="fa fa-arrow-left"></i> Back</a>

                        <a class="btn btn-info btn-xs" href="{{route('post_application.getDownloadAdmitCard',[$student,$subjectOption->unit ])}}">
                            <i class="fa fa-download"></i> Admit card
                        </a>

                        <a class="btn btn-primary btn-xs"
                           href="{{ route('subject_choice.downloadChoiceForm',$subjectOption->id) }}"> <i
                                class="fa fa-download"></i> Download Choice Form</a>
                        {{-- <button type="submit" class="btn btn-primary" >Next <i class="fa fa-arrow-right"></i></button> --}}
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table table-condensed table-bordered">
                        <thead>
                        <tr>
                            <th>Department</th>
                            <th class="text-center">Choice Serial</th>
                            <th class="text-center">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($studentChoices as $choice)

                            @if(!empty($choice->selection_status))
                                @php
                                    $status = strtoupper(substr($choice->selection_status,0,1));
                                    $pos    = substr($choice->selection_status,1);
                                @endphp
                            @else
                                @php
                                    $status = '';
                                    $pos = '';
                                @endphp
                            @endif
                            <tr @if($choice->opt_out != '0') class="bg-danger"
                                @endif @if($status== 'S') class="bg-success" @endif>
                                <td>{{$choice->department->name}}</td>
                                <td class="text-center">
                                    @if($choice->opt_out == '0')
                                        {{$choice->priority+1}}
                                    @else
                                        Opt-Out
                                    @endif
                                </td>
                                <td>
                                    @if ( $subjectOption->admission_completed == 1 && $choice->dept_code == $subjectOption->admission_subject->dept_code)
                                        @if($subjectOption->office_status == 1)
                                            ADMITTED
                                        @elseif($subjectOption->office_status == 0)
                                            PENDING
                                        @else
                                            -
                                        @endif
                                    @else

                                        @if( $status ==='S')
                                            <b>SELECTED</b>
                                        @elseif($status ==='W')
                                            WAITING ({{$pos}})
                                        @else
                                            -
                                        @endif

                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>{{-- panel-default --}}

@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
@stop
