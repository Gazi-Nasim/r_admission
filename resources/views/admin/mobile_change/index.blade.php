@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default full-height">
        <div class="panel-body">
            <legend><i class="fa fa-mobile-phone"></i> Mobile No. Changes</legend>

            {{--search bar--}}
            <div class="row">
                <div class="col-sm-12">
                    @include('admin.mobile_change.search_bar')
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12" id="result">
                </div>
            </div>

        </div>
    </div>

@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
    <script type="text/javascript">

    </script>
@stop

