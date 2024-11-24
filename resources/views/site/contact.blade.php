@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
<div class="panel panel-default full-height">
	<div class="panel-body">
		<legend><i class="fa fa-info-circle"></i> Contact</legend>

        {!!$content->content!!}
	</div>
</div>
@stop

