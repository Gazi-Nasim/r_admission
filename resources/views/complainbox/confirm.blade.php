@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
<div class="panel panel-default">

	<div class="panel-body">
		<legend><i class="fa fa-pencil"></i> Provided Information</legend>

		{{-- student data --}}
		@if ($inputs)
		<div class="row">
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table table-bordered  table-condensed">
						<tr class="bg-success">
							<th width="30%" colspan="2">Applicant's  Name</th>
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
								@if ($inputs['sex'] == 'F')
									Female
								@else
									Male
								@endif
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
                        <tr class="bg-success">
							<th colspan="2">Problem Description</th>
							<td colspan="5">{{$inputs['message']}}</td>
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
							 <th>Reg No</th>
							<th>CGPA</th>
						</tr>
						{{-- hsc data --}}
						<tr>
							<td>HSC</td>
							<td>{{$inputs['hsc_roll']}}</td>
							<td>{{strtoupper($inputs['hsc_board'])}}</td>
							<td>{{$inputs['hsc_pass_year']}}</td>
							 <td>{{$inputs['hsc_reg_no']}}</td>
							<td>{{number_format($inputs['hsc_gpa'],2)}}</td>
						</tr>
						{{-- ssc data --}}
						<tr>
							<td>SSC</td>
							<td>{{$inputs['ssc_roll']}}</td>
							<td>{{strtoupper($inputs['ssc_board'])}}</td>
							<td>{{$inputs['ssc_pass_year']}}</td>
							 <td>{{$inputs['ssc_reg_no']}}</td>
							<td>{{number_format($inputs['ssc_gpa'],2)}}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>{{-- student data --}}
		<div class="row">
			<div class="col-sm-12">
				{{Form::open( ['route'=>'complainbox.save'] )}}
					<p class="text-right">
						<a class="btn btn-danger" href="{{ route('complainbox.index') }}" role="button">
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
						<h4>No Data !!</h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut </p>
						<hr>
						<p class="text-center">
							<a class="btn btn-danger" href="{{ route('reg.get_info_reviews') }}" role="button"><i class="fa fa-arrow-left"></i> Try Again</a>
						</p>
					</div>
				</div>
			</div>
		</div>
		@endif
	</div>
</div>{{-- panel-default --}}
@stop

