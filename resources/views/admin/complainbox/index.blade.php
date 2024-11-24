@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><i class="fa fa-inbox"></i> Complain Box</legend>


            {{-- search bar --}}
            <div class="row">
                <div class="col-sm-12">
                    @include('admin.complainbox.search_bar')
                </div>
            </div>

            {{-- result --}}
            <div class="row">
                <div class="col-sm-12" id="result" >
{{--                    @include('admin.complainbox.search_result')--}}
                </div>
            </div>

        </div>
    </div>

@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}
    <script type="text/javascript">

        jQuery(document).ready(function($) {
            $('.datepicker').datepicker({
                format: "yyyy-mm-dd",
                startView: 0,
                autoclose: true,
                todayHighlight: true
            });
        });

        //submit form onload
        $(document).ready(function() {
            $('#frm').submit();
        });

    </script>
@stop

