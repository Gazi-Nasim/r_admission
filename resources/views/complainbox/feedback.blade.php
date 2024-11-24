@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))
@section('body-content')
<div class="panel panel-default full">
	<div class="panel-body">

		@if (!$success)
			<blockquote class="alert-danger">
				<strong> <i class="fa fa-times"></i> {{$msg}}</strong>
			</blockquote>
		@else
			<blockquote class="alert-success">
				<strong> <i class="fa fa-check"></i> {{$msg}}</strong>
			</blockquote>

			<div class="panel panel-success">
				<div class="panel-body">
					<p class="lead">
						We Received your information. We will contact over your mobile number ({{$inputs['mobile_no']}})
					</p>
				</div>
			</div>
			<p class="text-center"><a class="btn btn-primary" href="{{ route('site.home') }}"><i class="fa fa-home"></i> Back to Home Page</a></p>
		@endif


	</div>
</div>
@stop
