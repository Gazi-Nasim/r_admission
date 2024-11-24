@if ($application)
	<table class="table table-striped table-bordered table-condensed">
		<thead>
			<tr>
				<th>Roll</th>
				<th>Photo</th>
				<th>Info Update</th>
				<th>Bill ID</th>
				<th>Date</th>
				<th>DL</th>
				<th>Admit</th>
				<th>Bill</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{$application->unit}}-{{$application->admission_roll}}</td>
                <input type="hidden" name="_token" value="{{csrf_token()}}"id="_token" >
                <input type="hidden" name="application" value="{{$application->id}}"id="application">
                <input type="hidden" name="field" value="photo" id="photo">
                <input type="hidden" name="field" value="info" id="info">
				<td>
                    {{$application->photo_change_count}}
                    @role('Admin')
                    {{--<a class="btn btn-primary btn-xs"
                       ic-post-to='{{route('students.decrease_count')}}'
                       ic-include='#_token,#application,#photo'
                       ic-replace-target="true"
                    ><i class="fa fa-minus"></i></a>--}}
                    @endrole
                </td>
				<td>
                    {{$application->info_update_count}}
                    @role('Admin')
                   {{-- <a class="btn btn-primary btn-xs"
                       ic-post-to='{{route('students.decrease_count')}}'
                       ic-include='#_token,#application,#info'
                       ic-replace-target="true"
                    ><i class="fa fa-minus"></i></a>--}}
                    @endrole
                </td>
				<td>{{$application->bill_id}}</td>
				<td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $application->created_at)->format('d-m-y [h:i A]')}}</td>
				<td>{{$application->download_count}}</td>
				<td><a  href="{{route('admin.student.getDownloadAdmitCard',$application)}}"><i class="fa fa-download"></i></a></td>
				<td><a  href="{{route('admin.bill.getDownloadBill',$application->bill_id)}}"><i class="fa fa-download"></i></a></td>
			</tr>
			<tr>
				<td colspan="8">
                    <b>Room : {{$application->room}}<br>
                       Seat : {{$application->seat}}<br>
                        {{$application->building}}</b>
					{{-- Merit &nbsp;&nbsp;: {{$application->subject_options->position}}<br>
					Score : {{$application->subject_options->exam_score}}<br>
					Allowed &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$application->subject_options->sub_allow}}<br>
					Completed : {{$application->subject_options->sub_completed}} --}}
				</td>
			</tr>
			{{-- <tr>
				<td colspan="8">
					<a class="btn btn-primary btn-xs" target="_blank" href="{{ route('student.get_subject_choice',$application->subject_options->id) }}" role="button"><i class="fa fa-edit"></i> Update Choice</a>
					<a class="btn btn-success btn-xs" target="_blank" href="{{ route('student.show_subject_choice',$application->subject_options->id) }}" role="button"><i class="fa fa-search"></i> Show Choices</a>
				</td>
			</tr> --}}
		</tbody>
	</table>
@else
	<div class="alert alert-danger">
		<strong> No Info </strong>
	</div>
@endif
