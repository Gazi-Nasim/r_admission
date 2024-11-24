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

                        <a class="btn btn-primary btn-xs"
                           href="{{ route('hall_choice.downloadHallChoiceForm',$subjectOption->id) }}"> <i
                                class="fa fa-download"></i> Download</a>
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
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($studentChoices as $choice)

                            <tr>
                                <td>{{$choice->hall->name}}</td>
                                <td class="text-center">
                                        {{$choice->priority+1}}
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
