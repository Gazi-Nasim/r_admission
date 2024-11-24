@extends('layouts.master_admin', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><i class="fa fa-envelope-o"></i> SMS Sender</legend>

            {{-- result --}}
            <div class="row">
                <div class="col-sm-6" id="form">
                    @include('admin.sms.sms_form')
                </div>
            </div>
        </div>
    </div>

@stop

@section('script-extra')
    {{ Html::script('assets/plugins/intercooler/intercooler-1.2.1.min.js') }}

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#count').text('Character Remaining :160');
            $('textarea').keyup(function() {
                var cs = $(this).val().length;
                $('#count').text('Character Remaining :'+ (160-cs));
            });

        });
    </script>
@stop

