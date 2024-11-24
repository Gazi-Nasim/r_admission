@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><i class="fa fa-users"></i> Users </legend>
            {{-- search bar --}}
            <div class="row">
                <div class="col-sm-10">
                     @include('admin.user.search_bar')
                </div>
                <div class="col-sm-2">
                    <a href ="{{ route('admin.user.create') }}"  class="btn btn-primary pull-right">
                        <i class="fa fa-plus"></i> Add User</a>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12" id="result">
                    @include('admin.user.search_result')
                </div>
            </div>
        </div>
    </div>

@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
@stop

