<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{ Html::style('assets/plugins/bootstrap/css/bootstrap.min.css') }}
    <title>Payment Acknowledgement Slip</title>


    <style>
        @media print,
        screen {


            body {
                font-family: Arial, Helvetica, sans-serif;
                color: #000;
                -webkit-print-color-adjust: exact;
            }

            .f-14 {
                font-size: 14pt;
            }

            .b {
                font-weight: bold;
            }

            th,
            td {
                border: 1px solid #444;
                padding: 2px;
            }

            table#info th {
                padding: 5px;
            }

            #info th,
            #info td {
                border: 0;
                padding: 5px;
            }

        }
    </style>

</head>

<body>

    <div class="container">

        <div class="row" style="margin-bottom: 5px;">
            <div class="col-xs-12 text-center">
                <div>
                    <img src="{{public_path('assets/img/logo.png')}}" height="60" alt="">
                </div>

                <span style="font-family:freeserif; font-size:26pt"><b>রাজশাহী বিশ্ববিদ্যালয়</b></span><br>
                <span style="font-family:freeserif; font-size:18pt"><u>প্রথম বর্ষ সম্মান ভর্তি পরীক্ষা ২০২৩-২৪</u></span><br>
                <span style="font-family:freeserif; font-size:16pt">(চূড়ান্ত আবেদন)</span>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <table class="table">
                    <tr>
                        <th width="55%" class="text-right" style="padding-right: 5px;background-color: #d4d4d4; font-size: 13pt">APPLICATION FEE</th>
                        <th style="padding-left: 5px">TK. {{$bill->amount}}</th>
                    </tr>
                    <tr>
                        <th class="text-right" style="padding-right: 5px;background-color: #d4d4d4;font-size: 13pt">UNITS</th>
                        <th style="padding-left: 5px">{{$bill->units}}</th>
                    </tr>
                </table>

            </div>
        </div>

        <div class="row">
            <div class="col-xs-8" style="padding: 0;margin: 0">
                <table class="table" id="info">
                    <tr>
                        <th class="text-right" style="width: 1.8in">Application ID :</th>
                        <td>{{$student->id}}</td>
                    </tr>

                    <tr>
                        <th class="text-right">Applicant’s Name :</th>
                        <td>{{$student->NAME}}</td>
                    </tr>

                    <tr>
                        <th class="text-right">Father’s Name :</th>
                        <td>{{$student->FNAME}}</td>
                    </tr>

                    <tr>
                        <th class="text-right">Mother’s Name :</th>
                        <td>{{$student->MNAME}}</td>
                    </tr>

                    <tr>
                        <th class="text-right">Mobile Number :</th>
                        <td>{{$student->mobile_no}}</td>
                    </tr>

                    <tr>
                        <th class="text-right">Quota :</th>
                        <td>{{$student->quota_string == null ? 'Not Applicable':$student->quota_string }}</td>
                    </tr>

                    <tr>
                        <th class="text-right">Payment Status :</th>
                        <td>
                            @if($bill->payment_status='0')
                            Bkash. (TrxId:{{$bill->trx_id}})
                            @else
                            <b class="text-danger b">UNPAID</b>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="text-right">Question Language:</th>
                        <td>{{($student->is_english == 1) ? "English" : "Bangla"}}</td>
                    </tr>
                    <tr >
                        <th >Zone Choices</th>
                        <td >
                            @foreach ($zoneChoices as $choice)
                            <p class="label label-primary">{{$choice->zone->name}}</p>
                            @endforeach
                        </td>
                    </tr>
                </table>
            </div>

            <div class="col-xs-4 pull-right text-right" style=" padding: 0;margin: 0">
                <img src="{{Storage::path('public/uploads/'.$student->photo)}}" style="width: 1.2in;" alt="No Photo Found">
            </div>
        </div>


        <div class="well" style="background-color:#eee;font-family: freeserif; font-size: 12pt;text-align: justify; margin-top: 1in">
            প্রাথমিক আবেদনকারীদের HSC/সমমান পরীক্ষার ফলাফলের ভিত্তিতে প্রতিটি ইউনিটের জন্য অনধিক ৭২০০০ আবেদনকারী নির্বাচন
            করা হবে। নির্বাচিত প্রার্থীদের চূড়ান্ত আবেদন প্রক্রিয়া ০৯/০৪/২০২৩ তারিখ দুপুর ১২টা থেকে শুরু হবে। চূড়ান্ত
            আবেদনের বিস্তারিত সময়সূচী http://admission.ru.ac.bd এর মাধ্যমে প্রকাশ করা হবে।
        </div>


    </div>


</body>

</html>