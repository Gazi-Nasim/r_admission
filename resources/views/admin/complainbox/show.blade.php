@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><i class="fa fa-dashboard"></i>Forwarded Complain</legend>

            @if (Session::has('message'))
                @if (Session::get('message')['error'])
                    <div class="alert alert-danger">
                        <strong> {{Session::get('message')['msg']}} </strong>
                    </div>
                @else
                    <div class="alert alert-success">
                        <strong> {{Session::get('message')['msg']}} </strong>
                    </div>
                @endif
            @endif

            {{-- row 1 --}}
            {{-- <pre>{{print_r($hscData)}}</pre>
            <pre>{{print_r($infoReview)}}</pre> --}}
            @if ( $infoReview )
                {{-- Board Data info --}}
                <div class="row">
                    <div class="col-sm-6">
                        <legend>HSC Board Data</legend>
                        @if ($hscData)
                            <table class="table table-bordered table-condensed bg-success">
                                <tr>
                                    <th width="30%">Applicant's Name</th>
                                    <td>{{$hscData->NAME}}</td>
                                </tr>
                                <tr>
                                    <th>Father's Name</th>
                                    <td>{{$hscData->FNAME}}</td>
                                </tr>
                                <tr>
                                    <th>Mother's Name</th>
                                    <td>{{$hscData->MNAME}}</td>
                                </tr>
                                <tr>
                                    <th>Date of Birth</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>{{$hscData->SEX}}</td>
                                </tr>
                                <tr>
                                    <th>GPA</th>
                                    <td>{{$hscData->HSC_GPA}}</td>
                                </tr>
                                <tr>
                                    <th>Result</th>
                                    <td>{{$hscData->HSC_RESULT}}</td>
                                </tr>
                            </table>
                        @else
                            <div class="alert alert-danger">
                                <strong>Not Found</strong>
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <legend>SSC Board Data</legend>
                        @if ($hscData)
                            <table class="table table-bordered table-condensed bg-warning">
                                <tr>
                                    <th width="30%">Applicant's Name</th>
                                    <td>{{$hscData->SSC_NAME}}</td>
                                </tr>

                                <tr>
                                    <th>GPA</th>
                                    <td>{{$hscData?->SSC_GPA}}</td>
                                </tr>
                                <tr>
                                    <th>Result</th>
                                    <td>{{$hscData?->SSC_RESULT}}</td>
                                </tr>
                            </table>
                        @else
                            <div class="alert alert-danger">
                                <strong>Not Found</strong>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- applicants given data --}}
                <div class="row">
                    <div class="col-sm-12">
                        <legend>Applicant Data</legend>
                        <table class="table table-bordered table-condensed">
                            <tr class="bg-warning">
                                <th width="20%">Applicant's Name</th>
                                <th>Father's Name</th>
                                <th>Mother's Name</th>
                                <th>Date of Birth</th>
                                <th>Gender</th>
                                <th>Mobile No</th>
                                <th>Status</th>
                            </tr>
                            <tr>
                                <td>{{$infoReview->NAME}}</td>
                                <td>{{$infoReview->FNAME}}</td>
                                <td>{{$infoReview->MNAME}}</td>
                                <td>{{$infoReview->dob}}</td>
                                <td>{{$infoReview->SEX}}</td>
                                <td>{{$infoReview->mobile_no}}</td>
                                <td>{{$infoReview->status}}</td>
                            </tr>

                            <tr>
                                <th class="bg-warning" colspan="1">Bill</th>
                                <td colspan="2">
                                    <p><strong>Enrollment</strong></p>
                                    @if($enrollmentBill)
                                        {{$enrollmentBill?->id}}


                                        @switch($enrollmentBill?->payment_status)
                                            @case( '0')
                                                <a class="label label-info"
                                                   href="{{route('admin.bill.showDetails', $enrollmentBill)}}"
                                                   target="_blank"><i class="fa fa-search"></i> Pending</a> |
                                                @break
                                            @case( '1')
                                                <a class="label label-primary"
                                                   href="{{route('admin.bill.showDetails', $enrollmentBill)}}"
                                                   target="_blank"><i class="fa fa-search"></i> Paid</a> |
                                                @break
                                            @case('-1')
                                                <a class="label label-danger"
                                                   href="{{route('admin.bill.showDetails', $enrollmentBill)}}"
                                                   target="_blank"><i class="fa fa-search"></i> Cancelled</a> |
                                                @break
                                            @default
                                                Not Found
                                                @break
                                        @endswitch
                                        <a href="{{route('admin.bill.getDownloadBill', $enrollmentBill)}}"
                                           target="_blank"><i class="fa fa-download"></i> Download</a>
                                    @else
                                        Not Created Yet
                                    @endif

                                    <hr>
                                    <p><strong>Application</strong></p>
                                    @forelse($applicationBills ?? [] as $bill)
                                        {{$bill->id}}
                                        @switch($bill?->payment_status)
                                            @case( '0')

                                                <a class="label label-info"
                                                   href="{{route('admin.bill.showDetails', $bill)}}"
                                                   target="_blank"><i class="fa fa-search"></i> Pending</a> |
                                                @break
                                            @case( '1')

                                                <a class="label label-primary"
                                                   href="{{route('admin.bill.showDetails', $bill)}}"
                                                   target="_blank"><i class="fa fa-search"></i> Paid</a> |
                                                @break
                                            @case('-1')
                                                <a class="label label-danger"
                                                   href="{{route('admin.bill.showDetails', $bill)}}"
                                                   target="_blank"><i class="fa fa-search"></i> Cancelled</a> |
                                                @break
                                            @default
                                                Not Found
                                                @break
                                        @endswitch
                                        <a href="{{route('admin.bill.getDownloadBill', $bill)}}"
                                           target="_blank"><i class="fa fa-download"></i> Download</a>
                                    @empty
                                        Not Created Yet
                                    @endforelse
                                </td>
                                <th class="bg-warning" colspan="1">
                                    Hsc Data
                                </th>
                                <td colspan="3">
                                    @if($hscData)
                                        <a class="label label-primary" target="_blank"
                                           href="{{route('admin.student.show', $hscData->id)}}">
                                            <i class="fa fa-user"></i> View Profile
                                            @else
                                                Not Found
                                    @endif

                                </td>
                            </tr>
                            <tr>
                                <td colspan="7"></td>
                            </tr>
                            <tr class="bg-warning">
                                <th colspan="7">Message</th>
                            </tr>

                            <tr>
                                <td colspan="7">{{$infoReview->message}}</td>
                            </tr>
                            <tr>
                                <th class="bg-warning" colspan="1">Status</th>
                                <td colspan="6">{{$infoReview->status}}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- result comparision --}}
                <div class="row">
                    <div class="col-sm-6">
                        <legend>HSC</legend>
                        <table class="table table-bordered table-condensed">
                            {{-- heading --}}
                            <tr class="bg-default">
                                <th>Exam</th>
                                <th>Roll</th>
                                <th>Reg.</th>
                                <th>Board</th>
                                <th>Year</th>
                                <th>Group</th>
                                <th>CGPA</th>
                                <th>Result</th>
                            </tr>
                            {{-- hsc data --}}
                            @if ($hscData)
                                <tr class="bg-success">
                                    <td>BOARD</td>
                                    <td>{{$hscData->HSC_ROLL_NO}}</td>
                                    <td>{{$hscData->HSC_REGNO}}</td>
                                    <td>{{$hscData->HSC_BOARD_NAME}}</td>
                                    <td>{{$hscData->HSC_PASS_YEAR}}</td>
                                    <td>{{$hscData->HSC_GROUP}}</td>
                                    <td>
                                        @if (!empty($hscData->HSC_GPA))
                                            {{number_format($hscData->HSC_GPA,2)}}
                                        @endif
                                    </td>
                                    <td>{{$hscData->HSC_RESULT}}</td>
                                </tr>
                            @else
                                <tr class="bg-danger">
                                    <td colspan="8">NOT FOUND</td>
                                </tr>
                            @endif
                            <tr class="bg-warning">
                                <td>APPLICANT</td>
                                <td>{{$infoReview->HSC_ROLL_NO}}</td>
                                <td>{{$infoReview->HSC_REGNO}}</td>
                                <td>{{$infoReview->HSC_BOARD_NAME}}</td>
                                <td>{{$infoReview->HSC_PASS_YEAR}}</td>
                                <td>{{$infoReview->HSC_GROUP}}</td>
                                <td>
                                    @if(!empty($infoReview->HSC_GPA))
                                        {{number_format($infoReview->HSC_GPA,2)}}
                                    @endif
                                </td>
                                <td>{{$infoReview->HSC_RESULT}}</td>
                            </tr>
                            {{-- ssc data --}}
                        </table>
                    </div>
                    <div class="col-sm-6">
                        <legend>SSC</legend>
                        <table class="table table-bordered table-condensed">
                            {{-- heading --}}
                            <tr>
                                <th>Exam</th>
                                <th>Roll</th>
                                <th>Reg.</th>
                                <th>Board</th>
                                <th>Year</th>
                                <th>Group</th>
                                <th>CGPA</th>
                                <th>Result</th>
                                <th></th>
                            </tr>
                            {{-- SSC data --}}
                            @if ($hscData)
                                <tr class="bg-success">
                                    <td>BOARD</td>
                                    <td>{{$hscData->SSC_ROLL_NO}}</td>
                                    <td>{{$hscData->HSC_REGNO}}</td>
                                    <td>{{$hscData->SSC_BOARD_NAME}}</td>
                                    <td>{{$hscData->SSC_PASS_YEAR}}</td>
                                    <td>{{$hscData->SSC_GROUP}}</td>
                                    <td>{{ $hscData->SSC_GPA ? number_format($hscData->SSC_GPA,2):''}}</td>
                                    <td>{{$hscData->SSC_RESULT}}</td>
                                    <td></td>
                                </tr>
                            @else
                                <tr class="bg-danger">
                                    <td colspan="8">NOT FOUND</td>
                                </tr>
                            @endif
                            <tr class="bg-warning">
                                <td>APPLICANT</td>
                                <td>{{$infoReview->SSC_ROLL_NO}}</td>
                                <td>{{$infoReview->SSC_REGNO}}</td>
                                <td>{{$infoReview->SSC_BOARD_NAME}}</td>
                                <td>{{$infoReview->SSC_PASS_YEAR}}</td>
                                <td>{{$infoReview->SSC_GROUP}}</td>
                                <td>{{number_format($infoReview->SSC_GPA,2)}}</td>
                                <td>{{$infoReview->SSC_RESULT}}</td>
                                <td>
                                    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                                    <input type="hidden" name="infoReviewId" id="infoReviewId" value="{{$infoReview->id}}">
                                    <a onclick="return confirm('Are you sure?')"
                                       class="btn btn-default btn-xs"
                                       ic-post-to="{{route('admin.complainbox.updateSscDataFromStudent')}}"
                                       ic-include='#_token,#infoReviewId'>
                                        <i class="fa fa-refresh"></i></a>
                                    <a class="btn btn-success btn-xs" href="{{route('admin.complainbox.viewSscData',$infoReview)}}" target="_blank"><i class="fa fa-search"></i></a>
                                </td>
                            </tr>
                            {{-- ssc data --}}
                        </table>
                    </div>
                </div>


                {{-- buttons --}}
                <div class="row">
                    <div class="col-sm-6">
                        <div class="alert alert-info">
                            <p><b>Comment</b></p>
                            {{$infoReview->comment}}
                        </div>
                        <p>
                            <a href="{{ route('admin.complainbox.index') }}" class="btn btn-primary"><i
                                    class="fa fa-arrow-left"></i> Back</a>
                        </p>
                    </div>
                    <div class="col-sm-6">
                        {{-- operator can only change status if empty, admin change always --}}
                        @if ( empty($infoReview->status) || Auth::user()->hasRole('Admin'))
                            {{Form::open( array('route'=>'admin.complainbox.updateStatus', 'id'=>'form1' ) )}}
                            <p class="text-right">
                                <textarea name="comment" id="input" class="form-control" rows="3"
                                          placeholder="Comment"></textarea>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="send_sms" value="1" checked>
                                    Send Comment As SMS
                                </label>
                            </div>

                            <button type="submit" name="status" value="R" class="al btn btn-danger"><i
                                    class="fa fa-times"></i> Rejaet
                            </button>
                            <button type="submit" name="status" value="A" class="al btn btn-success"><i
                                    class="fa fa-check"></i> Accept
                            </button>
                            {{Form::hidden('id', $infoReview->id)}}
                            </p>
                            {{ Form::close()}}
                        @endif
                    </div>
                </div>
            @else
                {{-- false expr --}}
            @endif

        </div>
    </div>

@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
@stop
