@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')


    <div class="panel panel-default no-print-border">
        <div class="panel-body">

            <div class="row">
                <div class="col-lg-6 col-lg-offset-3 text-center text-success">

                    <div class="panel panel-default">
                        <div class="panel-body bg-success">
                            <h1><i class="fa fa-check-circle-o fa-3x"></i></h1>
                            <p>আপনার পেমেন্ট সম্পন্ন হয়েছে</p>
                        </div>

                        {{--<div class="panel-footer">
                            @if ($bill->payment_purpose=='E')
                            <a class="btn btn-primary btn-sm"
                               href="{{ route('preliminary.getDownloadBill',$bill) }}" role="button">
                                <i class="fa fa-download"></i> Download Acknowledgement Slip
                            </a>
                            @elseif($bill->payment_purpose='A')
                                <a class="btn btn-primary btn-sm"
                                   href="{{ route('preliminary.getDownloadBill',$bill) }}" role="button">
                                    <i class="fa fa-download"></i> Download Acknowledgement Slip
                                </a>
                            @elseif($bill->payment_purpose='P')
                                <a class="btn btn-primary btn-sm"
                                   href="{{ route('preliminary.getDownloadBill',$bill) }}" role="button">
                                    <i class="fa fa-download"></i> Download Acknowledgement Slip
                                </a>
                            @endif
                        </div>--}}
                    </div>
                </div>
            </div>


            <div class="row">

                <div class="col-lg-6 col-lg-offset-3">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th class="bg-info" colspan="2">Payment Information</th>
                        </tr>
                        <tr>
                            <th width="35%">Applicant ID</th>
                            <td>{{$bill->student->id}}</td>
                        </tr>
                        <tr>
                            <th width="25%">Applicant's Name</th>
                            <td>{{$bill->student->NAME}}</td>
                        </tr>

                        <tr>
                            <th>Bill No.</th>
                            <td><b>{{$bill->id}}</b></td>
                        </tr>
                        <tr>
                            <th>Trx ID</th>
                            <td>{{$bill->rocket_trx_id ?? '-'}}</td>
                        </tr>
                        <tr>
                            <th>Application Fee</th>
                            <td><b>Tk. {{$bill->amount}}</b></td>
                        </tr>

                        <tr>
                            <th>Payment Status</th>
                            <td>
                                @if($bill->payment_status == "1")
                                    <span class="label label-success">Paid</span>
                                @else
                                    <span class="label label-danger">Unpaid</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <p class="text-center">
                        <a class="btn btn-success btn-sm"
                           href="{{ route('student.getDashboard') }}" role="button">
                            <i class="fa fa-home"></i> Back to Student Panel
                        </a>
                        <a class="btn btn-danger btn-sm"  href="{{ route('site.home') }}"
                           role="button">Exit <i class="fa fa-sign-out"></i></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script-extra')

    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}

    <script type="text/javascript">
        function warn() {
            var string = "আপনি এই পেজ থেকে প্রস্থান করছেন। প্রস্থানের পূর্বে  প্রস্তুতকৃত পে-স্লিপটি ডাউনলোড করেছেন কি না তা নিশ্চিত হোন। ডাউনলোড না করে থাকলে Download Payslip -এ ক্লিক করে পে-স্লিপ ডাউনলোড করুন। স্লিপটি পরবর্তীতে ব্যবহারের জন্য সংরক্ষণ করতে হবে।";
            return confirm(string);
        }
    </script>
@stop

