@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
<div class="panel panel-default">
    <div class="panel-body">
        <legend class="text-danger"><i class="fa fa-exclamation-circle"></i> আপনার প্রদত্ত সকল তথ্য সঠিক আছে কিনা তা
            দেখে নিন।
        </legend>

        {{-- <pre>
                {{print_r(Session::all())}}
        </pre> --}}

        @if (Session::has('message'))
        <blockquote class="alert-danger">
            <strong><i class="fa fa-warning"></i> {{Session::get('message')}}</strong>
        </blockquote>
        @if (Session::has('error') )
        <{{-- pre>
					{{print_r($e)}}
            </pre> --}}
            @endif
            @else
            {{-- <blockquote class="alert-warning">
                    <strong><i class="fa fa-warning"></i> Please Confirm if the following information is OK</strong>
                </blockquote> --}}
            @endif
            <div class="row">
                <div class="col-sm-4">
                    {{ Html::image(Storage::url('public/uploads/'.$student->photo), 'Photo', array('class'=>'img-responsive img-thumbnail center-block', 'width'=>200)) }}

                    @if (!$student->photo)
                    <p class="text-center"><a class="btn btn-danger btn-sm"
                            href="{{ route('preliminary.getUploadStudentPhoto') }}"><i
                                class="fa fa-edit"></i> Change Photo</a></p>
                    @endif
                </div>

                <div class="col-sm-8">
                    <table class="table table-bordered  table-condensed">
                        <tr class="bg-success">
                            <th width="30%" colspan="2">Applicant's Name</th>
                            <td colspan="5">{{$student->NAME}}</td>
                        </tr>
                        <tr class="bg-success">
                            <th colspan="2">Father's Name</th>
                            <td colspan="5">{{$student->FNAME}}</td>
                        </tr>
                        <tr class="bg-success">
                            <th colspan="2">Mother's Name</th>
                            <td colspan="5">{{$student->MNAME}}</td>
                        </tr>
                        <tr class="bg-warning">
                            <th colspan="2">Enrolled Unit(s)</th>
                            <td colspan="5">
                                @foreach ($inputs['units'] as $unit)
                                <p class="label label-primary">{{$unit}}</p>
                                @endforeach
                            </td>
                        </tr>
                        <tr class="bg-warning">
                            <th colspan="2">Zone Choices</th>
                            <td colspan="5">
                                @foreach ($zoneChoices as $choice)
                                <p class="label label-primary">{{$choice->zone->name}}</p>
                                @endforeach
                            </td>
                        </tr>
                        <tr class="bg-warning">
                            <th colspan="2">Payable Amount</th>
                            <td colspan="5">
                                @if($paidBill)
                                0 Tk. (Already Paid)
                                @else
                                <u>Tk. {{$total_fees}}</u>
                                @endif
                            </td>
                        </tr>
                        <tr class="bg-info">
                            <th colspan="2">Quota</th>
                            <td colspan="5">
                                @if (empty($student->quota_string))
                                Not Applicable <br>
                                @else
                                {{$student->quota_string}} <br>
                                @endif
                            </td>
                        </tr>

                        <tr class="bg-info">
                            <th colspan="2">Contact</th>
                            <td colspan="5">
                                Mobile: {{$student->mobile_no}}<br>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7"></td>
                        </tr>
                        {{-- heading --}}
                        <tr class="bg-warning">
                            <th>Exam</th>
                            <th>Roll</th>
                            <th>Board</th>
                            <th>Year</th>
                            <th>Group</th>
                            <th>CGPA</th>
                            <th>Result</th>
                        </tr>
                        {{-- hsc data --}}
                        <tr>
                            <td>HSC</td>
                            <td>{{$student->HSC_ROLL_NO}}</td>
                            <td>{{$student->HSC_BOARD_NAME}}</td>
                            <td>{{$student->HSC_PASS_YEAR}}</td>
                            <td>{{$student->HSC_GROUP}}</td>
                            <td>{{$student->HSC_GPA}}</td>
                            <td @if($student->HSC_RESULT=='FAIL') class="text-danger" @endif>{{$student->HSC_RESULT}}</td>
                        </tr>
                        {{-- ssc data --}}
                        <tr>
                            <td>SSC</td>
                            <td>{{$student->SSC_ROLL_NO}}</td>
                            <td>{{$student->SSC_BOARD_NAME}}</td>
                            <td>{{$student->SSC_PASS_YEAR}}</td>
                            <td>{{$student->SSC_GROUP}}</td>
                            <td>{{$student->SSC_GPA}}</td>
                            <td @if($student->SSC_RESULT=='FAIL') class="text-danger" @endif>{{$student->SSC_RESULT}}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- extra caution for failed student --}}
            @if (strtoupper($student->HSC_RESULT) =='PASS')
            <div class="row">
                <div class="col-sm-12">
                    {{Form::open( array('route'=>'preliminary.postSaveApplication') )}}
                    <p class="text-right">
                        {{-- <a class="btn btn-danger" href="{{ route('reg.check_elegiblility') }}" role="button">
                        <i class="fa fa-clock-o"></i> Apply Later
                        </a> --}}
                        <a class="btn btn-danger" href="{{ route('student.getDashboard') }}"
                            role="button">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                        <a class="btn btn-primary" data-toggle="modal" data-backdrop="static" data-keyboard="false" href='#modal-id'><i class="fa fa-save"></i> Submit Preliminary Application </a>

                    <div class="modal fade" id="modal-id">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-warning">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title"><i class="fa fa-info-circle"></i> প্রশ্নপত্রের ভাষা</h4>
                                </div>
                                <div class="modal-body">
                                    <h4>ভর্তি পরীক্ষায় আপনি কোন ভাষায় লিখিত প্রশ্নপত্রে পরীক্ষা দিতে ইচ্ছুক?</h4>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="question_type" id="input" value="BN" checked="checked">
                                            বাংলা
                                        </label>
                                    </div>

                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="question_type" id="input" value="EN">
                                            ইংরেজি
                                        </label>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Submit Preliminary
                                        Application
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                    </p>
                    {{ Form::close()}}

                </div>
            </div>
            @else
            <div class="row">
                <div class="col-sm-12">
                    <p class="text-right">
                        <a class="btn btn-danger" href="{{ route('site.home') }}" role="button">
                            <i class="fa fa-arrow-left"></i> You are not. eligible to apply. Go Back
                        </a>
                    </p>
                </div>
            </div>
            @endif

    </div>
</div>
@stop