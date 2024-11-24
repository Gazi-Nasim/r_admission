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
                    <td>{{$user_input['hsc_roll']}}</td>
                    <th>SSC/Equiv. Roll</th>
                    <td>{{$user_input['ssc_roll']}}</td>
                </tr>
                <tr>
                    <th>HSC/Equiv. Board</th>
                    <td>{{$hsc_board[ strtolower($user_input['hsc_board'])]}}</td>
                    <th>SSC/Equiv. Board</th>
                    <td>{{$ssc_board[ strtolower( $user_input['ssc_board'])]}}</td>
                </tr>
                <tr>
                    <th>HSC/Equiv. Year</th>
                    <td>{{$user_input['hsc_year']}}</td>
                    <th>SSC/Equiv. Year</th>
                    <td>{{$user_input['ssc_year']}}</td>
                </tr>
                </tbody>
            </table>

            @if($flags['no_data'])
                @include('student.errors.no_data')
            @endif

            @if($flags['fail'])
                @include('student.errors.fail')
            @endif

            @if($flags['name_mismatch'])
                @include('student.errors.name_mismatch')
            @endif

            @if($flags['data_mismatch'])
                @include('student.errors.data_mismatch')
            @endif

            @if($flags['not_eligible'])
                @include('student.errors.not_eligible')
            @endif
            @if($flags['oth_no_data'])
                @include('student.errors.oth_no_data')
            @endif



            <p class="text-right">
                <a href="{{route('student.getLogin')}}" class="btn btn-danger"><i class="fa fa-arrow-left"></i>
                    Back</a>
                @if($flags['oth_no_data'])
                    <a class="btn btn-info" href="{{route('oth.getStudentInfo')}}" role="button"><i class="fa fa-pencil-square-o"></i> OTH Info Update</a>
                @endif
                <a class="btn btn-primary" href="{{route('complainbox.index')}}" role="button"><i class="fa fa-pencil-square-o"></i> Complain Box</a>
            </p>
        </div>


    </div>
@endsection
