@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">

            {{-- Subject Choice --}}
            <legend><i class="fa fa-credit-card"></i> Subject Choice Confirmation for Unit {{$subjectOption->unit}}</legend>
            {{-- choice  list --}}


            <div class="row">
                <div class="col-sm-12">
                    <p class="text-right">
                        <a class="btn btn-primary btn-xs" href="{{ route('student.getDashboard') }}"><i class="fa fa-arrow-left"></i> Back</a>
                    </p>
                </div>
            </div>

            {{-- Alert --}}
            <div class="alert alert-danger">
                <strong>
                    অটো মাইগ্রেশন বন্ধ করতে বিভাগের পাশের <label class="label label-primary"><i class="fa fa-exclamation-circle"></i> Stop Auto Migration Here</label>
                    বাটনে ক্লিক দিন।  অটো মাইগ্রেশন বন্ধ করলে পরবর্তীতে উক্ত বিভাগ ছাড়া অন্য কোন বিভাগে ভর্তির সুযোগ
                    থাকবে না। <b>একবার বন্ধ করলে পরবর্তীতে অটো মাইগ্রেশন আর চালু করা যাবে না।</b>
                </strong>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table table-condensed table-bordered">
                        <thead>
                        <tr>
                            <th>Department</th>
                            <th>Choice Serial</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($choices as $choice)
                            <tr @if($choice->dept_code ==  $subjectOption->migration_stop) class="bg-info" @endif>
                                <td>{{$choice->department->name}}</td>
                                <td>{{$choice->priority+1}}</td>
                                <td>
                                    @if( ($choice->dept_code == $subjectOption->admission_subject->dept_code ) && $subjectOption->migration_stop=='' )
                                        <a
                                            class="btn btn-primary btn-xs"
                                            data-toggle="modal"
                                            href='#modal-id'
                                            ic-target=".modal-body"
                                            ic-get-from="{{ route('hons_admission.getMigrationStop', [$subjectOption->id]) }}">
                                            <i class="fa fa-exclamation-circle"></i> Stop Auto Migration Here
                                        </a>
                                    @else
                                        @if($choice->dept_code ==  $subjectOption->migration_stop)
                                            Migration Stopped Here
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <p class="text-right">
                        <a class="btn btn-primary btn-xs" href="{{ route('student.getDashboard') }}"><i class="fa fa-arrow-left"></i> Back</a>
                    </p>
                </div>
            </div>

        </div>
    </div>{{-- panel-default --}}


    <div class="modal fade" id="modal-id">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirm</h4>
                </div>
                <div class="modal-body">
                    <h2>DO you want to appprove this student?</h2>
                </div>
            </div>
        </div>
    </div>


@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}

@stop
