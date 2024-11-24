<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Demo</h1>

@foreach($students as $student)
<table width="30%" border="1">
    <tr>
        <th>Applicant ID</th>
        <td colspan="2">{{$student->id}}</td>
    </tr>
    <tr>
        <th>Applicant's Name</th>
        <td colspan="2">{{$student->NAME}}</td>
    </tr>
    <tr>
        <th colspan="2">HSC</th>
    </tr>
    <tr>
        <td>ROLL</td>
        <td>{{$student->HSC_ROLL_NO}}</td>
    </tr>
    <tr>
        <td>BOARD</td>
        <td>{{$student->HSC_BOARD_NAME}}</td>
    </tr>
    <tr>
        <td>Year</td>
        <td>{{$student->HSC_PASS_YEAR}}</td>
    </tr>
    <tr>
        <th colspan="2">SSC</th>
    </tr>
    <tr>
        <td>ROLL</td>
        <td>{{$student->SSC_ROLL_NO}}</td>
    </tr>
    <tr>
        <td>BOARD</td>
        <td>{{$student->SSC_BOARD_NAME}}</td>
    </tr>
    <tr>
        <td>Year</td>
        <td>{{$student->SSC_PASS_YEAR}}</td>
    </tr>
    <tr>
        <th>MOBILE</th>
        <td>{{$student->mobile_no}}</td>
    </tr>
    <tr>
        <th >OTP</th>
        <td>{{$student->mobile_verification_code}}</td>
    </tr>
    <tr>
        <th>Reset Preliminary </th>
        <td>
            <a href="{{route('reset',[ $student->id,0])}}" onclick="return confirm('are you sure?')" target="_blank">Partial Reset</a> |
            <a href="{{route('reset',[ $student->id,1])}}" onclick="return confirm('are you sure?')" target="_blank">Full Reset</a>
        </td>
    </tr>
    <tr>
        <th>Reset Final Application</th>
        <td>
            <a href="{{route('reset-final',[ $student->id,0])}}" onclick="return confirm('are you sure?')" target="_blank">Partial Reset</a> |
            <a href="{{route('reset-final',[ $student->id,1])}}" onclick="return confirm('are you sure?')" target="_blank">Full Reset</a>
        </td>
    </tr>
</table>
    <br>
    <br>
@endforeach

<pre>
    {{ print_r(session()->all() )}}
</pre>

</body>
</html>
