@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-danger">

        <div class="panel-body">
            <legend><i class="fa fa-user"></i> এইচএসসি/এসএসসি (অথবা সমমান) সংক্রান্ত তথ্য</legend>


            <table class="table table-condensed table-bordered">
                <tbody>
                <tr>
                    <th colspan="4" class="text-center">Provided Data</th>
                </tr>
                <tr>
                    <th>HSC/Equiv. Roll</th>
                    <td>{{$student->HSC_ROLL_NO }}</td>
                    <th>SSC/Equiv. Roll</th>
                    <td>{{$student->SSC_ROLL_NO }}</td>
                </tr>
                <tr>
                    <th>HSC/Equiv. Board</th>
                    <td>{{$student->HSC_BOARD_NAME }}</td>
                    <th>SSC/Equiv. Board</th>
                    <td>{{$student->SSC_BOARD_NAME }}</td>
                </tr>
                <tr>
                    <th>HSC/Equiv. Year</th>
                    <td>{{$student->HSC_PASS_YEAR }}</td>
                    <th>SSC/Equiv. Year</th>
                    <td>{{$student->SSC_PASS_YEAR }}</td>
                </tr>
                </tbody>
            </table>

            <div class="alert alert-danger">
                প্রদত্ত তথ্য অনুযায়ী আপনার কোন আবেদন পাওয়া যায়নি। প্রয়োজনে Helpline এ যোগাযোগ করুন।
            </div>

            <p class="text-right">
                <a href="{{route('student.getLogin')}}" class="btn btn-danger"><i class="fa fa-arrow-left"></i>
                    Back</a>

            </p>
        </div>


    </div>
@endsection
