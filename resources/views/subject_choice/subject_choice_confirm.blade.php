@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">

            {{-- Message --}}
            <div class="alert alert-warning">
                <strong><i class="fa fa-exclamation-circle"></i>
                    আপনার পছন্দক্রম সঠিক আছে কিনা টা সতর্কতার সাথে যাচাই করুন। পছন্দক্রম পরিবর্তন করতে
                    <span class="label label-danger">Back</span> বাটনে ক্লিক দিয়ে পুনরায় পছন্দক্রম নির্বাচন করুন।
                    সঠিক থাকলে <span class="label label-primary">Next</span> এ ক্লিক দিয়ে সাবজেক্ট চয়েস সম্পন্ন করুন।
                </strong>
            </div>
            <br>
            {{-- Subject Choice --}}
            <legend><i class="fa fa-list-ol"></i> Department Choice Confirmation for Unit {{$subjectOption->unit}}
            </legend>
            {{-- choice  list --}}

            @if (Session::has('bksp_certificate') && Session::has('inputs.tmp_bksp_photo'))
                <div class="alert alert-warning" role="alert">
                    <strong>আপনি BKSP এর সার্টিফিকেট আপলোড করেন নি।</strong>
                </div>
            @endif

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table table-condensed table-bordered">
                        <thead>
                        <tr>
                            <th>Department</th>
                            <th>Choice Serial</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($student_choices as $priority=>$dept_code)
                            <tr>
                                <td>{{$subjects[$dept_code]}}</td>
                                <td>{{$priority+1}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <form method="post" action="{{route('subject_choice.postSubjectChoiceSave')}}">
                        <p class="text-right">

                            {{csrf_field()}}
                            <a class="btn btn-danger" href="{{ route('subject_choice.getSubjectChoiceForm') }}"><i
                                    class="fa fa-arrow-left"></i> Back</a>
                            <button type="submit" class="btn btn-primary">Next <i class="fa fa-arrow-right"></i>
                            </button>

                        </p>
                    </form>
                </div>
            </div>


        </div>
    </div>{{-- panel-default --}}
@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}

@stop
