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
                    নিচে প্রদত্ত কোন  বিভাগ/বিভাগসমূহে ভর্তি হতে ইচ্ছুক না হলে বিভাগের
                    পাশের <label class="label label-danger"><i class="fa fa-times"></i> Opt-Out</label> বাটনে ক্লিক দিয়ে  তা পছন্দের তালিকা থেকে বাদ দিতে পারবেন। এতে  প্রার্থীতা
                    বাতিল হবে না। তবে পূর্বে প্রদত্ত পছন্দের ক্রম পরিবর্তন করা যাবে না এবং কোন
                    বিভাগ <u>পছন্দের ক্রম থেকে একবার বাদ দিলে পরে তা আর পছন্দের তালিকায় অন্তর্ভূক্ত
                        করা যাবে না।</u>
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
                            <tr @if($subjectOption->admission_subject?->dept_code == $choice->dept_code) class="bg-success" @endif>
                                <td>{{$choice->department->name}}</td>
                                <td>{{$choice->priority+1}}</td>
                                <td>
                                    @if($choice->opt_out =='0')
                                        @if ( $subjectOption->admissionDepartment?->dept_code != $choice->dept_code )
                                            <a
                                                class="btn btn-danger btn-xs"
                                                data-toggle="modal"
                                                href='#modal-id'
                                                ic-target=".modal-body"
                                                ic-get-from="{{ route('hons_admission.getChangeSubjectChoice', [$choice->id, 'R']) }}">
                                                <i class="fa fa-times"></i> Opt-Out
                                            </a>
                                        @else
                                            -
                                        @endif

                                    @else
                                        Opted-Out
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
