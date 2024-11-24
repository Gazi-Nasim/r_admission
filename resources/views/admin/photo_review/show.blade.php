@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
<div class="panel panel-default">
	<div class="panel-body">
		<legend><i class="fa fa-photo"></i> Photo Review</legend>
		<p>
			<a href="{{ route('admin.photo_review.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
		</p>

		{{-- <pre>
			{{print_r($photo_review)}}
		</pre> --}}
		@if ($success)
			<div class="row">
				<div class="col-sm-3">
					<legend>HSC Reg Card Photo</legend>
					<a href="{{Storage::url('public/uploads/photo-changes/'.$photo_review->photo_reg)}}" target="_blank">
					{{ Html::image(Storage::url('public/uploads/photo-changes/'.$photo_review->photo_reg), 'Photo', array('class'=>'img-responsive img-thumbnail center-block', 'width'=>150)) }}
					</a>


				</div>
				<div class="col-sm-3">
					<legend>Current Photo</legend>
					{{ Html::image(Storage::url('public/uploads/'.$photo_review->applicant->photo), 'Photo', array('class'=>'img-responsive img-thumbnail center-block', 'width'=>200)) }}
				</div>
                <div class="col-sm-3">
                    <legend>Current Selfie</legend>
                    {{ Html::image(Storage::url('public/uploads/'.$photo_review->applicant->selfie), 'Photo', array('class'=>'img-responsive img-thumbnail center-block', 'width'=>200)) }}
                    <p class="text-center">
                        <a class="btn btn-success btn-xs"
                           ic-replace-target=true
                           ic-include='#_token'
                           ic-post-to="{{ route('admin.photo_check.setStatus',[$photo_review->applicant->id,'AS']) }}">
                            <i class="fa fa-check-circle"></i> Accept
                        </a>

                        <a class="btn btn-danger btn-xs"
                           ic-replace-target=true
                           ic-include='#_token'
                           ic-confirm='Are you sure?'
                           ic-post-to="{{ route('admin.photo_check.setStatus',[$photo_review->applicant->id,'RS']) }}">
                            <i class="fa fa-times-circle"></i> Reject
                        </a>
                    </p>
                </div>
				<div class="col-sm-3">
					@if ( empty($photo_review->status) )
						<legend>New Photo</legend>
						{{ Html::image(Storage::url('public/uploads/photo-changes/'.$photo_review->new_photo), 'Photo', array('class'=>'img-responsive img-thumbnail center-block', 'width'=>200)) }}
						<p class="text-center" id="feedback">
							<input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                            <a class="btn btn-danger"
								ic-post-to="{{ route('admin.photo_review.updateStatus', $photo_review->id) }}"
								ic-include="#reject,#_token"
								ic-confirm="Are you sure?"
								ic-target="#feedback"><i class="fa fa-times"></i> Reject
							</a>
							@if ($photo_review->bill_status == 1)
							<a class="btn btn-success"
								ic-post-to="{{ route('admin.photo_review.updateStatus', $photo_review->id) }}"
								ic-include="#accept,#_token"
								ic-confirm="Are you sure?"
								ic-target="#feedback"><i class="fa fa-check"></i> Accept
							</a>
							@endif

							<input type="hidden" name="action" id="accept" value="A">
							<input type="hidden" name="action" id="reject" value="R">
							<input type="hidden" name="action" id="forward" value="F">
						</p>
					@elseif($photo_review->status =='A')
						<legend>Previous Photo</legend>
						{{ Html::image(Storage::url('public/uploads/old-photos/'.$photo_review->previous_photo), 'Photo', array('class'=>'img-responsive img-thumbnail center-block', 'width'=>200)) }}
					@endif
				</div>
			</div>
			<br>
			<table class="table table-bordered  table-condensed">
                <tr class="bg-warning text-danger">
                    <th width="30%" colspan="2">Photo Change Request Count</th>
                    <td colspan="6"><b>{{$previousReviewCount ?? 0}}</b></td>
                </tr>
                <tr class="bg-success">
					<th width="30%" colspan="2">Applicant ID</th>
					<td colspan="6">{{$photo_review->applicant->id}}</td>
				</tr>
				<tr class="bg-success">
					<th width="30%" colspan="2">Applicant's  Name</th>
					<td colspan="6">
						{{$photo_review->applicant->NAME}}
						<a href="{{ route('admin.student.show',$photo_review->applicant->id) }}" target="_blank"><i class="fa fa-eye"></i></a>
					</td>
				</tr>
				<tr class="bg-success">
					<th colspan="2">Father's Name</th>
					<td colspan="6">{{$photo_review->applicant->FNAME}}</td>
				</tr>
				<tr class="bg-success">
					<th colspan="2">Mother's Name</th>
					<td colspan="6">{{$photo_review->applicant->MNAME}}</td>
				</tr>
				<tr class="bg-success">
					<th colspan="2">Gender</th>
					<td colspan="6">{{$photo_review->applicant->SEX}}</td>
				</tr>
				<tr class="bg-success">
					<th colspan="2">Mobile</th>
					<td colspan="6">{{$photo_review->applicant->mobile_no}}</td>
				</tr>

				<tr class="bg-success">
					<th colspan="2">Status</th>
					<td colspan="6">{{$photo_review->status}}</td>
				</tr>

				<tr>
					<td colspan="8"></td>
				</tr>
				{{-- heading --}}
				<tr class="bg-warning">
					<th>Exam</th>
					<th>Roll</th>
					<th>Board</th>
					<th>Year</th>
					<th>Reg. No</th>
					<th>Group</th>
					<th>CGPA</th>
					<th>Result</th>
				</tr>
				{{-- hsc data --}}
				<tr>
					<td>HSC/Equiv.</td>
					<td>{{$photo_review->applicant->HSC_ROLL_NO}}</td>
					<td>{{$photo_review->applicant->HSC_BOARD_NAME}}</td>
					<td>{{$photo_review->applicant->HSC_PASS_YEAR}}</td>
					<td>{{$photo_review->applicant->HSC_REGNO}}</td>
					<td>{{$photo_review->applicant->HSC_GROUP}}</td>
					<td>{{number_format($photo_review->applicant->HSC_GPA,2)}}</td>
					<td @if($photo_review->applicant->HSC_RESULT=='FAIL') class="text-danger" @endif>{{$photo_review->applicant->HSC_RESULT}}</td>
				</tr>
				{{-- ssc data --}}
				<tr>
					<td>SSC/Equiv.</td>
					<td>{{$photo_review->applicant->SSC_ROLL_NO}}</td>
					<td>{{$photo_review->applicant->SSC_BOARD_NAME}}</td>
					<td>{{$photo_review->applicant->SSC_PASS_YEAR}}</td>
					<td>{{$photo_review->applicant->SSC_REGNO}}</td>
					<td>{{$photo_review->applicant->SSC_GROUP}}</td>
					<td>{{number_format($photo_review->applicant->SSC_GPA,2)}}</td>
					<td @if($photo_review->applicant->SSC_RESULT=='FAIL') class="text-danger" @endif>{{$photo_review->applicant->SSC_RESULT}}</td>
				</tr>
			</table>
		@else
			<div class="alert alert-info">
				<strong><i class="fa fa-info-circle"></i> No data found</strong>
			</div>
		@endif
	</div>
</div>
@stop

@section('script-extra')
	{{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
@stop

