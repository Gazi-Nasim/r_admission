@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">

            {{-- Subject Choice --}}
            <legend ><i class="fa fa-credit-card"></i> Registration Form for Unit-{{$subjectOption->unit}}</legend>
            {{-- choice  list --}}

            <div class="row">
                <div class="col-sm-12">
                    <p class="text-right">
                        <a class="btn btn-danger btn-xs" href="{{ route('admin.admitCard.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                        <a class="btn btn-primary btn-xs" href="{{ route('admin.student.downloadHonsAdmissionForm',$subjectOption->id) }}"> <i class="fa fa-download"></i> Download Registration Form</a>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table table-condensed table-bordered">
                        <tbody>
                        <tr>
                            <th width="15%">Exam Roll</th>
                            <td>{{$subjectOption->unit}}{{$subjectOption->admission_roll}}</td>
                            <th width="15%">Exam Score</th>
                            <td>{{$subjectOption->exam_score}}</td>
                            <th width="15%">Merit Position</th>
                            <td>{{$subjectOption->position}}</td>
                        </tr>
                        <tr>
                            <th>Student ID</th>
                            <td>Not Assigned</td>
                            <th>Registration No.</th>
                            <td>Not Assigned</td>
                            <th>Category</th>
                            <td>{{$subjectOption->unit}}-{{$subjectOption->exam_group_no}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <h4 class="text-primary"><i class="fa fa-money"></i> Payment Information</h4>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table table-condensed table-bordered">
                        <thead>
                        <tr>
                            <th>Bill No</th>
                            <th>Bill Amount</th>
                            <th>Payment Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$subjectOption->bill->id}}</td>
                            <td>Tk. {{number_format($subjectOption->bill->amount,2)}}</td>
                            <td>
                                @if($subjectOption->bill->payment_status == 0)
                                    Unpaid
                                @elseif($subjectOption->bill->payment_status == 1)
                                    Paid
                                @else
                                    Canceled
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <h4 class="text-primary"><i class="fa fa-list"></i> Basic Info</h4>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table table-condensed table-bordered">
                        <tbody>
                        <tr>
                            <th width="25%">Name of Student</th>
                            <td>{{$subjectOption->application->name}}</td>
                        </tr>
                        <tr>
                            <th>Session</th>
                            <td>2023-24</td>
                        </tr>
                        <tr>
                            <th>Name of Faculty</th>
                            <td>{{$subjectOption->admission_subject->faculty->faculty_name}}</td>
                        </tr>
                        <tr>
                            <th>Department/Institute</th>
                            <td>{{$subjectOption->admission_subject->name}}</td>
                        </tr>
                        <tr>
                            <th>Name of Hall</th>
                            <td>Not Assigned</td>
                        </tr>
                        <th>Quota</th>
                        <td>{{$student->quota_string}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <h4 class="text-primary"><i class="fa fa-user"></i> Personal Information</h4>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table table-condensed table-bordered">
                        <tbody>
                        <tr>
                            <th>Mother's Name</th>
                            <td colspan="3" width="75%">{{$subjectOption->application->mname}}</td>
                        </tr>
                        <tr>
                            <th>Father's Name</th>
                            <td colspan="3">{{$subjectOption->application->fname}}</td>
                        </tr>
                        <tr>
                            <th>Guardian's Name<br>(In absence of parents)</th>
                            <td width="35%">{{$student_details?->guardian_name}}</td>
                            <th>Relationship</th>
                            <td>{{$student_details?->guardian_relation}}</td>
                        </tr>
                        <tr>
                            <th width="25%">Date of Birth</th>
                            <td>{{$student_details?->dob}}</td>
                            <th width="20%">Place of Birth</th>
                            <td>{{$student_details?->birth_place}}</td>
                        </tr>

                        <tr>
                            <th>Blood Group</th>
                            <td>{{$student_details?->blood_group}}</td>
                            <th>Gender</th>
                            <td>{{$student_details?->gender}}</td>
                        </tr>

                        <tr>
                            <th>Mobile Phone No.</th>
                            <td>{{$student->mobile_no}}</td>
                            <th>Email Address</th>
                            <td>{{$student_details?->email}}</td>
                        </tr>

                        <tr>
                            <th>National ID No.</th>
                            <td>{{$student_details?->nid_no}}</td>
                            <th>Valid Passport No.</th>
                            <td>{{$student_details?->passport_no}}</td>
                        </tr>

                        <tr>
                            <th>Birth Reg. No.</th>
                            <td>{{$student_details?->birth_reg_no}}</td>
                            <th>Religion(Optional)</th>
                            <td>{{$student_details?->religion}}</td>
                        </tr>
                        <tr>
                            <th>Nationality</th>
                            <td>{{$student_details?->nationality}}</td>
                            <th>Height</th>
                            <td>{{$student_details?->height}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <h4 class="text-primary"><i class="fa fa-home"></i> Permanent Address</h4>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table table-condensed table-bordered">
                        <tbody>
                        <tr>
                            <th width="25%">Hous/Raod/Village</th>
                            <td colspan="3">{{nl2br($student_details?->permanent_address)}}</td>
                        </tr>
                        <tr>
                            <th>Thana/Upazila</th>
                            <td width="30%">{{$student_details?->permanent_ps_upazila}}</td>
                            <th >Post Office</th>
                            <td>{{$student_details?->permanent_post_office}}</td>
                        </tr>
                        <tr>
                            <th>District</th>
                            <td>{{$student_details?->permanent_district}}</td>
                            <th>{{--Post Code--}}</th>
                            <td>--</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>


            <h4 class="text-primary"><i class="fa fa-home"></i> Current Address</h4>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table table-condensed table-bordered">
                        <tbody>
                        <tr>
                            <th width="25%">Hous/Raod/Village</th>
                            <td colspan="3">{{nl2br($student_details?->current_address)}}</td>
                        </tr>
                        <tr>
                            <th>Thana/Upazila</th>
                            <td width="30%">{{$student_details?->current_ps_upazila}}</td>
                            <th >Post Office</th>
                            <td>{{$student_details?->current_post_office}}</td>
                        </tr>
                        <tr>
                            <th>District</th>
                            <td>{{$student_details?->current_district}}</td>
                            <th>{{--Post Code--}}</th>
                            <td>--</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>


            <h4 class="text-primary"><i class="fa fa-exclamation-circle"></i> Emergency Contact</h4>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table table-condensed table-bordered">
                        <tbody>
                        <tr>
                            <th width="25%">Name</th>
                            <td colspan="3" width="75%">{{$student_details?->emergency_name}}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td colspan="3">{{nl2br($student_details?->emergency_address)}}</td>
                        </tr>
                        <tr>
                            <th>Relationship</th>
                            <td>{{$student_details?->emergency_relation}}</td>
                            <th width="25%">Mobile Phone No.</th>
                            <td>{{$student_details?->emergency_contact}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <h4 class="text-primary"><i class="fa fa-book"></i> Previous Academic Information</h4>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table table-condensed table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Exam</th>
                            <th>Roll No</th>
                            <th>Reg. No</th>
                            <th>Group</th>
                            <th>Passing Yr.</th>
                            <th>CGPA</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>SSC/Eqv</th>
                            <td>{{$student->SSC_ROLL_NO}}</td>
                            <td>{{$student->SSC_REGNO}}</td>
                            <td>{{$student->SSC_GROUP}}</td>
                            <td>{{$student->SSC_PASS_YEAR}}</td>
                            <td>{{$student->SSC_GPA}}</td>
                        </tr>

                        <tr>
                            <th>HSC/Eqv</th>
                            <td>{{$student->HSC_ROLL_NO}}</td>
                            <td>{{$student->HSC_REGNO}}</td>
                            <td>{{$student->HSC_GROUP}}</td>
                            <td>{{$student->HSC_PASS_YEAR}}</td>
                            <td>{{$student->HSC_GPA}}</td>
                        </tr>
                        <tr>
                            <th>SSC BOARD</th>
                            <td colspan="2">{{$student->SSC_BOARD_NAME}}</td>
                            <th>HSC BOARD</th>
                            <td colspan="2">{{$student->HSC_BOARD_NAME}}</td>
                        </tr>

                        <tr>
                            <th>SSC Subject</th>
                            <td colspan="5">{{$student->SSC_LTRGRD}}</td>
                        </tr>

                        <tr>
                            <th>HSC Subject</th>
                            <td colspan="5">{{$student->HSC_LTRGRD}}</td>
                        </tr>

                        <tr>
                            <th>SSC Institute</th>
                            <td colspan="5">{{$student_details?->ssc_institute}}</td>
                        </tr>

                        <tr>
                            <th>HSC Institute</th>
                            <td colspan="5">{{$student_details?->hsc_institute}}</td>
                        </tr>


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
