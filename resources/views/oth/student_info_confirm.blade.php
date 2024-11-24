@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
    <div class="panel panel-default">

        <div class="panel-body">
            <legend><i class="fa fa-pencil"></i> Provided Information</legend>
            {{-- student data --}}
            @if ($inputs)
                {{-- <pre>
                    {{print_r(Session::all())}}
                </pre> --}}

                <div class="row">
                    <div class="col-sm-4">
                        <legend>SSC Document</legend>
                        {{ Html::image(Storage::url('public/uploads/oth-temp/'.$inputs["photo_ssc"]), 'Photo', array('class'=>'img-responsive img-thumbnail center-block', 'width'=>200)) }}
                    </div>
                    <div class="col-sm-4">
                        <legend>HSC Document</legend>
                        {{ Html::image(Storage::url('public/uploads/oth-temp/'.$inputs["photo_hsc"]), 'Photo', array('class'=>'img-responsive img-thumbnail center-block', 'width'=>200)) }}
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered  table-condensed">
                                <tr class="bg-success">
                                    <th width="30%" colspan="2">Applicant's Name</th>
                                    <td colspan="5">{{$inputs['name']}}</td>
                                </tr>
                                <tr class="bg-success">
                                    <th colspan="2">Father's Name</th>
                                    <td colspan="5">{{$inputs['fname']}}</td>
                                </tr>
                                <tr class="bg-success">
                                    <th colspan="2">Mother's Name</th>
                                    <td colspan="5">{{$inputs['mname']}}</td>
                                </tr>
                                <tr class="bg-success">
                                    <th colspan="2">Gender</th>
                                    <td colspan="5">
                                        {{ $inputs['sex']}}
                                    </td>
                                </tr>
                                <tr class="bg-success">
                                    <th colspan="2">Date of Birth</th>
                                    <td colspan="5">{{$inputs['dob']}}</td>
                                </tr>
                                <tr class="bg-success">
                                    <th colspan="2">Mobile No.</th>
                                    <td colspan="5">{{$inputs['mobile_no']}}</td>
                                </tr>
                                <tr>
                                    <td colspan="7"></td>
                                </tr>
                                {{-- heading --}}
                                <tr class="bg-warning">
                                    <th>Exam</th>
                                    <th>Roll</th>
                                    <th>Board</th>
                                    <th>Year</th>
                                    {{-- <th>Group</th> --}}
                                    <th>CGPA</th>
                                </tr>
                                {{-- hsc data --}}
                                <tr>
                                    <td>HSC</td>
                                    <td>{{$inputs['hsc_roll']}}</td>
                                    <td>{{$inputs['hsc_board']}}</td>
                                    <td>{{$inputs['hsc_pass_year']}}</td>
                                    {{-- <td>{{$inputs['hsc_group']}}</td> --}}
                                    <td>{{number_format($inputs['hsc_gpa'],2)}}</td>
                                </tr>
                                {{-- ssc data --}}
                                <tr>
                                    <td>SSC</td>
                                    <td>{{$inputs['ssc_roll']}}</td>
                                    <td>{{$inputs['ssc_board']}}</td>
                                    <td>{{$inputs['ssc_pass_year']}}</td>
                                    {{-- <td>{{$inputs['ssc_group']}}</td> --}}
                                    <td>{{number_format($inputs['ssc_gpa'],2)}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>{{-- student data --}}
                <div class="row">
                    <div class="col-sm-12">
                        {{Form::open( ['route'=> 'oth.postSaveStudentInfo' ])}}
                        <p class="text-right">
                            <a class="btn btn-danger" href="{{ route('oth.getStudentInfo') }}" role="button">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Submit</button>
                        </p>
                        {{ Form::close()}}

                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title">Problem</h3>
                            </div>
                            <div class="panel-body">
                                <p>No data found </p>
                                <hr>
                                <p class="text-center">
                                    <a class="btn btn-danger" href="{{ route('reg.missing_info') }}" role="button"><i
                                            class="fa fa-arrow-left"></i> Try Again</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>{{-- panel-default --}}
@stop

