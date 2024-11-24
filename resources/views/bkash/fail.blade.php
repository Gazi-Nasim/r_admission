@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default no-print-border">
        <div class="panel-body">
            {{-- <pre>
                {{print_r(Session::all())}}
            </pre> --}}


            <div class="row">
                <div class="col-lg-6 col-lg-offset-3 text-center text-danger">

                    <div class="panel panel-default">
                        <div class="panel-body bg-danger">
                            <h1><i class="fa fa-times-circle-o fa-3x"></i></h1>
                            <p class="lead">{{$error}}</p>
                        </div>
                        <div class="panel-footer">

                            <form method="post" action="{{ route('bkash.pay') }}">
                                @csrf
                                <input type="hidden" name="bill_id" id="bill_id" value="{{$bill->id}}">
                                <button type="submit" class="btn btn-default"><i class="fa fa-refresh"></i> Try Again
                                </button>
                            </form>

                        </div>
                    </div>


                </div>
            </div>


            <div class="row">

                <div class="col-lg-6 col-lg-offset-3">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th class="bg-primary" colspan="2">Payment Information</th>
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
                            <th>Bill Number</th>
                            <td><b>{{$bill->id}}</b></td>
                        </tr>
                        <tr>
                            <th>Bill Amount</th>
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
                        <tr>
                            <td colspan="2" class="text-center">
                                <a class="btn btn-primary btn-sm"
                                   href="{{ route('preliminary.getDownloadBill',$bill) }}" role="button">
                                    <i class="fa fa-download"></i> Download Payment Slip
                                </a>

                                <a class="btn btn-success btn-sm"
                                   href="{{ route('student.getDashboard') }}" role="button">
                                    <i class="fa fa-home"></i> Back to Home
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script-extra')

    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}

    <script type="text/javascript">
        function warn() {
            var string = "আপনি এই পেজ থেকে প্রস্থান করছেন।  যাওয়ার পূর্বে  প্রস্তুতকৃত পে-স্লিপটি ডাউনলোড করেছেন কি না তা নিশ্চিত হোন। ডাউনলোড না করে থাকলে Download Payslip -এ ক্লিক করে পে-স্লিপ ডাউনলোড করুন। ";
            return confirm(string);
        }
    </script>
@stop

