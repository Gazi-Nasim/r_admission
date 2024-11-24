@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">

            <legend>New User</legend>
            <form method="POST" action="{{ route('admin.user.store')}}" class="form-horizontal password-form">
                {{Form::token()}}

                <div class="form-group @if ($errors->has('fullname')) has-error @endif">
                    {{ Form::label('fullname', 'Display Name', array('class' => 'control-label col-sm-2')) }}
                    <div class="col-sm-4">
                        {{ Form::text('fullname', old('fullname'), array('class' => 'form-control','placeholder'=>"Display Name")) }}
                        {!! $errors->first('fullname','<span class="help-block">:message</span>')  !!}
                    </div>
                </div>
                <div class="form-group @if ($errors->has('username')) has-error @endif">
                    {{ Form::label('username', 'User Name', array('class' => 'control-label col-sm-2')) }}
                    <div class="col-sm-4">
                        {{ Form::text('username', old('username'), array('class' => 'form-control','placeholder'=>"User Name")) }}
                        {!! $errors->first('username','<span class="help-block">:message</span>')  !!}
                    </div>
                </div>

                <div class="form-group @if ($errors->has('role')) has-error @endif">
                    {{ Form::label('role', 'User Role', array('class' => 'control-label col-sm-2')) }}
                    <div class="col-sm-4">
                        {{ Form::select('role', [""=>'Please Select']+$roles ,old('role') ,['placeholder'=>'Role', 'class' => 'form-control' ])  }}
                        {!! $errors->first('role','<span class="help-block">:message</span>')  !!}
                    </div>
                </div>

                <div class="form-group @if ($errors->has('office')) has-error @endif">
                    {{ Form::label('office', 'Office', ['class' => 'control-label col-sm-2']) }}
                    <div class="col-sm-4">
                        {{ Form::text('office', old('office'),  array('class' => 'form-control','placeholder'=>"Default ICT" )) }}
                        {!! $errors->first('office','<span class="help-block">:message</span>')  !!}
                    </div>
                </div>

                <div class="form-group @if ($errors->has('password')) has-error @endif">
                    {{ Form::label('password', 'Password', array('class' => 'control-label col-sm-2')) }}
                    <div class="col-sm-4">
                        {{ Form::text('password', old('password'),  array('class' => 'form-control','placeholder'=>"Password" )) }}
                        {!! $errors->first('password','<span class="help-block">:message</span>')  !!}
                    </div>
                </div>

                <div class="form-group @if ($errors->has('password_confirmation')) has-error @endif">
                    {{ Form::label('password_confirmation', 'Retype Password', array('class' => 'control-label col-sm-2')) }}
                    <div class="col-sm-4">
                        {{ Form::text('password_confirmation', old('password_confirmation'), array('class' => 'form-control', 'placeholder'=>"Retype Password")) }}
                        {!! $errors->first('password_confirmation','<span class="help-block">:message</span>')  !!}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Create</button>
                        <a href="{{ route('admin.user.index') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Cancel</a>
                    </div>
                </div>
            {{Form::close()}}


        </div>
    </div>
@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
@stop

