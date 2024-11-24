@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default no-print-border">
        <div class="panel-body">
            {{-- 	<pre>
                    {{print_r(Session::all())}}
                </pre> --}}
            <blockquote class="no-print alert-success">
                <strong><i class="fa fa-check-circle"></i> রাজশাহী বিশ্ববিদ্যালয়ে আবেদনের জন্য একটি বিল প্রস্তুত করা
                    হয়েছে। বিল সংক্রান্ত তথ্য নিচে প্রদত্ত</strong>
            </blockquote>

            <div class="row no-show print">
                <div class="col-sm-12">
                    <img id="img" src="{{ url('assets/img/header.png') }}" width="100%"
                         class="img-responsive center-block" alt="Image">
                </div>
            </div>

            <div class="row">
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    {{ Html::image(Storage::url('public/uploads/'.$student->photo), 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>150)) }}
                </div>

                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th class="bg-primary" colspan="2">Bill Information</th>
                        </tr>
                        <tr>
                            <th width="35%">Application ID</th>
                            <td>{{$student->id}}</td>
                        </tr>
                        <tr>
                            <th width="25%">Applicant's Name</th>
                            <td>{{$student->NAME}}</td>
                        </tr>
                        <th>Quota</th>
                        <td>
                            {{$student->quota_string}}
                        </td>
                        <tr>
                            <th>Question Language</th>
                            <td>{{$student->is_english ? 'English' : 'Bangla'}}</td>
                        </tr>
                        {{--<tr>
                            <th>Payment Purpose</th>
                            <td><b>Enrollment</b></td>
                        </tr>--}}

                        <tr>
                            <th>Unit</th>
                            <td><b>{{$bill->units}}</b></td>
                        </tr>
                        <tr>
                            <th> Application Fee</th>
                            <td><b>Tk. {{$bill->amount}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">
                                <div class="alert alert-warning">
                                    আপনার আবেদন নিশ্চিত করার জন্য নিচের Pay Online বাটনে ক্লিক করে বিল পরিশোধ করুন।
                                </div>

                                <form class="form-inline" method="post" action="{{ route('rocket.pay') }}">
                                    @csrf
                                    <input type="hidden" name="bill_id" id="bill_id" value="{{$bill->id}}">
                                    <button type="submit" class="btn btn-sm btn-purple"><i class="fa fa-money"></i>
                                        Pay Online
                                    </button>

                                    <a class="btn btn-sm btn-success"
                                       href="{{ route('preliminary.getDownloadBill',$bill) }}" role="button">
                                        <i class="fa fa-download"></i> Download Acknowledgement Slip
                                    </a>
                                </form>

                                {{--<form style="display: inline-block" class="form-inline" method="post" action="{{ route('rocket.pay') }}">
                                    @csrf
                                    <input type="hidden" name="bill_id" id="bill_id" value="{{$bill->id}}">
                                    <button type="submit" class="btn btn-sm btn-purple"><i class="fa fa-money"></i>
                                        Pay with Rocket
                                    </button>

                                    <a class="btn btn-sm btn-success"
                                       href="{{ route('preliminary.getDownloadBill',$bill) }}" role="button">
                                        <i class="fa fa-download"></i> Download Acknowledgement Slip
                                    </a>
                                </form>--}}

                                <br>


                                <div class="alert alert-info">
                                    <strong>আপনি পরবর্তীতে যে কোন সময় হোম পেজের "Start Preliminary Application" লিংকে
                                        গিয়ে লগইন করে এই বিলটি ডাউনলোড করতে পারবেন।</strong>
                                </div>

                            </td>
                        </tr>
                    </table>




                </div>
            </div>

            <br>
            <div class="row">
                <div class="col-sm-12 no-print">
                    <p class="text-right">
                        <a class="btn btn-primary" onclick="return warn()"
                           href="{{ route('student.getDashboard') }}" role="button">
                            <i class="fa fa-home"></i> Back to Student Panel
                        </a>
                    </p>
                    <br>
                </div>

            </div>

        </div>
    </div>
@stop

@section('script-extra')
    <script type="text/javascript">
        function warn() {
            var string = "আপনি এই পেজ থেকে প্রস্থান করছেন।  যাওয়ার পূর্বে  প্রস্তুতকৃত পে-স্লিপটি ডাউনলোড করেছেন কি না তা নিশ্চিত হোন। ডাউনলোড না করে থাকলে Download Bill -এ ক্লিক করে পে-স্লিপ ডাউনলোড করুন। ";
            return confirm(string);
        }
    </script>
@stop

