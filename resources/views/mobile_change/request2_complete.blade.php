@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default" id="print_div">
        <div class="panel-body">
            <legend><i class="fa fa-photo"></i> মোবাইল নম্বর পরিবর্তন</legend>

            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-success">

                    <div class="panel panel-default">
                        <div class="panel-body bg-success">
                            <h1 class="text-center"><i class="fa fa-check-circle-o fa-3x"></i></h1>
                            <p class="text-center">
                                আপনার মোবাইল নম্বর পরিবর্তনের আবেদন সম্পন্ন হয়েছে। সকল তথ্য যাচাইয়ের পর আপনার ফোন নম্বর
                                পরিবর্তনের বিষয়ে শীঘ্রই ব্যবস্থা নেওয়া হবে।
                                <br><br><strong>এই আবেদনটি নিস্পত্তি না হওয়া পর্যন্ত পুনরায় আবেদন না করার জন্য বলা
                                    হল।</strong>
                            </p>
                            <br>
                            <table class="table table-bordered table-condensed table-striped bg-warning">

                                <tr>
                                    <th width="35%">Applicant ID</th>
                                    <td>{{$student->id}}</td>
                                </tr>
                                <tr>
                                    <th width="35%">Applicant ID</th>
                                    <td>{{$student->NAME}}</td>
                                </tr>
                                <tr>
                                    <th width="35%">Previous Mobile No.</th>
                                    <td>{{Str::mask($mobile_change->old_mobile_no,'*',3,-2)}}</td>
                                </tr>
                                <tr>
                                    <th width="35%">New Mobile No.</th>
                                    <td>{{$mobile_change->new_mobile_no}}</td>
                                </tr>
                            </table>


                        </div>

                        <div class="panel-footer text-center">
                            <a class="btn btn-success" href="{{ route('student.getDashboard') }}"
                               role="button">
                                 <i class="fa fa-home"></i> Home
                            </a>
                        </div>
                    </div>

                    {{--<div class="panel panel-default">
                        <div class="panel-body">
                            <div class="text-center">
                                <h3><u>প্রয়োজনীয় নির্দেশনা</u></h3>
                            </div>
                            <table class="table table-condensed">
                                <tbody>
                                <tr>
                                    <td>
                                        ১। Mobile Number Change সংক্রান্ত আবেদনের সকল তথ্য স্টুডেন্ট প্যানেলে পাওয়া
                                        যাবে। https://gstadmission.ac.bd –এর হোমপেজের Mobile Number Change লিংকটি
                                        ব্যবহার করে এইচএসসি/সমমান পরীক্ষার তথ্যসমূহ প্রদানের মাধ্যমে স্টুডেন্ট প্যানেলে
                                        প্রবেশ করতে হবে।
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        ২। একের অধিক বার মোবাইল নম্বর পরিবর্তনের আবেদন করলে জুম মিটিং-এ সাক্ষাৎকারের
                                        মাধ্যমে যাচাই করার পর এই বিষয়ে ব্যবস্থা নেওয়া হবে। সেক্ষেত্রে স্টুডেন্ট প্যানেল
                                        এবং প্রদত্ত নতুন মোবাইল নম্বরে SMS-এর মাধ্যমে মিটিং-এর সময়সূচীসহ একটি জুম মিটিং
                                        লিংক প্রদান করা হবে। লিংকে ক্লিক করে মিটিং-এ প্রবেশ করতে হবে। মিটিং-এ
                                        আবেদনকারীকে নিজে অবশ্যই উপস্থিত থাকতে হবে এবং মিটিং-এর সময় অডিও ও ভিডিও চালু
                                        রাখতে হবে।
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>--}}

                </div>


            </div>
        </div>
    </div>
@stop
@section('script-extra')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            $("#print_action").click(function () {
                $(".panel-footer").hide();
                window.print();
                $(".panel-footer").show();
            });
        });
    </script>
@stop
