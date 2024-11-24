@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body full-height">
            <legend>
                <i class="fa fa-dashboard"></i> Approve Students [Unit -{{auth()->user()->unit->unit_name}} ]
            </legend>


            <form class="form-inline" ic-indicator='#indicator' ic-target="#result" ic-post-to="{{ route('unit-office.postApproveStudent') }}" id="frm">
                {{csrf_field()}}
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">{{auth()->user()->unit->unit_name}}</span>
                        <input type="text" name="admission_roll" size="12" maxlength="6" class="form-control input-sm" value="" placeholder="Admission Roll" >
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::select('department', [""=>'All Department']+$departments , null, array('class' => 'form-control input-sm') ) }}
                </div>

                <div class="form-group">
                    <button type="submit" name="search"  class="btn btn-sm btn-primary">
                        <i class="fa fa-search"></i> Search <i id="indicator" class="fa fa-spinner fa-spin" style="display:none"></i>
                    </button>

                </div>
            </form>

            <div id="result">

            </div>


        </div>
    </div>

@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
@stop
