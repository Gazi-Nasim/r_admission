@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')

    <div class="panel panel-default full-height">
        <div class="panel-body">
            <legend>
                <i class="fa fa-picture-o"></i> Student Details
            </legend>

            <div class="row">
                <div class="col-md-12">
                    <form class="form-inline" ic-post-to="{{route('controlRoom.postAdmissionRoll')}}" ic-target="#result" >
                        <input type="hidden" name="_token" id="_token"  value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="sr-only" for="admissionRoll">Admission Roll</label>
                            <input type="number" name="admission_roll" class="form-control" id="admissionRoll" placeholder="Admission Roll">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12" id="result">

                </div>
            </div>

        </div>
    </div>

@endsection

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
@stop
