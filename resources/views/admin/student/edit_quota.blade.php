@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
<div class="panel panel-default">
	<div class="panel-body">
		<legend><i class="fa fa-users"></i> Student Details</legend>
		<p>
			<a href="{{ route('admin.student.show', $student->id) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
		</p>

		@if ($student)
			<div class="row">
				<div class="col-sm-10">{{-- student info --}}

					@if (session()->has('quota-error-message'))
					<div class="alert alert-danger">
					    <strong><i class="fa fa-exclamation-circle"></i> {{session::get('quota-error-message')}}</strong>
					</div>
					@endif

{{--				 	<pre>--}}
{{--					{{print_r($student_quotas)}}--}}
{{--					{{print_r(Session::all())}}--}}
{{--					</pre>--}}
{{--					 --}}
					<input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
					<table class="table table-hover ">
					    <tbody>
					    @foreach ($quotas as $key=>$value)
					        <tr>
					            <td>
					                <label>
					                    @if (in_array($key, array_keys($student_quotas)))
					                    <i class="fa fa-check-square"></i>
					                    {{$value}} ({{$key}})<br>
					                    	@if ($key =='FFQ')
					                    	&nbsp;&nbsp;&nbsp;&nbsp;[{{$student->bills()->where('payment_status','1')->first()->FFQ_type}}]
					                    	@endif

					                    @else
					                    <i class="fa fa-square-o"></i>
					                    {{$value}} ({{$key}})
					                    @endif
				                    </label>
					            </td>
					            <td class="text-rig/ht" id="upload-form-{{$key}}" width="50%">
				                    @include('admin.student.quota_upload_form', ['quota' => $key])
					            </td>
					            <td id="result-{{$key}}">
					                @if($student->{$key.'_photo'} != NULL)
					                   <a href="{{ Storage::url('uploads/'.$student->{$key.'_photo'}) }}" target="_blank">
					                    @if(substr($student->{$key.'_photo'}, -3)=='pdf' )
					                    <i class="fa fa-3x fa-file-text"></i>
					                    @else
					                    {{ Html::image(Storage::url('uploads/'.$student->{$key.'_photo'}), 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>80)) }}
					                    @endif
					                   </a>
					                @elseif(Session::has('inputs.quota_photo.'.$key))
					                   <a href="{{ Storage::url('uploads/bill-photos/').session('inputs.quota_photo.'.$key) }}" target="_blank">
					                    @if (substr(Session::get('inputs.quota_photo.'.$key),-3)=='pdf')
					                    <i class="fa fa-3x fa-file-text"></i>
					                    @else
					                    {{ Html::image(Storage::url('uploads/bill-photos/'.Session::get('inputs.quota_photo.'.$key)), 'Photo', array('class'=>'img-responsive img-thumbnail', 'width'=>80)) }}
					                    @endif
					                   </a>
					                @endif
					            </td>
					        </tr>
					    @endforeach
                        <tr>
                            <td colspan="3" class="text-right">
                                <a
                                    class="btn btn-danger"
                                    ic-post-to='{{route("admin.student.clearQuotas", $student->id)}}'
                                    ic-confirm='Are you sure?'
                                    ic-replace-target="true"
                                ><i class="fa fa-times"></i> Remove All Quota</a>
                            </td>
                        </tr>
					    </tbody>
					</table>

				</div>
			</div>{{-- student data --}}
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

@section('css-extra')
{{-- {{Html::style('assets/plugins/jQuery-File-Upload/css/jquery.fileupload.css')}} --}}
<style type="text/css">
    /*.fileinput-button {
        position: relative;
        overflow: hidden;
    }

    .fileinput-item {
      position: absolute;
      font-size: 50px;
      opacity: 0;
      right: 0;
      top: 0;

    }*/
</style>
@stop
