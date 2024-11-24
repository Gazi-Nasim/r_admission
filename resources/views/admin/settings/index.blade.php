@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default full-height">
        <div class="panel-body">
            <legend><i class="fa fa-cogs"></i> Settings </legend>


            <div class="row">
                <div class="col-sm-12">
                    @if (session('settings-saved'))
                        <div class="alert alert-success">
                            <strong>All Settings updated</strong>
                        </div>
                    @endif
                    <form action = {{ route('admin.settings.save') }} method="POST" class="form-horizontal" role="form">
                        @csrf
                        @foreach ($settings as $key=>$value)
                            <div class="form-group">
                                <label for="input" class="control-label col-lg-4">{{$key}}</label>
                                <div class="col-lg-4">
                                    @if(!in_array($key, $text_boxes))
                                        <label class="radio-inline">
                                            {{ Form::radio($key, '1', old($key,$value)=='1') }} Yes
                                        </label>
                                        <label class="radio-inline">
                                            {{ Form::radio($key, '0', old($key,$value)=='0') }} No
                                        </label><br>
                                    @else
                                        <input type="text" class="form-control" name="{{$key}}"
                                               value="{{old($key,$value)}}" maxlength="10" size="10" >
                                    @endif
                                    {{$errors->first('$key','<span class="help-block">:message</span>')}}
                                </div>
                            </div>

                        @endforeach
                        <hr>
                        <div class="form-group">
                            <label for="input" class="control-label col-sm-3"></label>
                            <div class="col-sm-8">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
@stop

