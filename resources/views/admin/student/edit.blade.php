@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><i class="fa fa-users"></i> Student Details</legend>
            <p>
                <a href="{{ route('admin.student.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
            </p>


            @if ($student)
                <div class="row">
                    <div class="col-sm-10">{{-- student info --}}

                        @if(session()->has('message'))
                            <div class="alert alert-danger">
                                <i class="fa fa-check"></i> {{ session('message') }}
                            </div>
                        @endif

                        {{Form::model($student, ['route'=>'admin.student.update','class'=>'form-horizontal','role'=>'form'])}}

                        {{-- <form action="" method="POST" class="form-horizontal" role="form"> --}}

                        @foreach ($columns as $column)

                            @if ($column == 'id')
                                {{Form::hidden('id', $student->value)}}
                            @else
                                <div class="form-group @if ($errors->has($column)) has-error @endif">
                                    {{ Form::label($column, $column, array('class' => 'control-label col-sm-3')) }}
                                    <div class="col-sm-8">
                                        {{ Form::text($column, old($column) ,['class' => 'form-control input-sm']) }}
                                        <span class="help-block">{{ $errors->first($column) }}</span>
                                    </div>
                                </div>
                            @endif

                        @endforeach

                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-3">
                                <a class="btn btn-danger" href="{{ route('admin.student.show',$student->id) }}" role="button"><i class="fa fa-times"></i> Cancel</a>
                                <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
                            </div>
                        </div>
                        </form>




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

