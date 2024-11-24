@extends('layouts.master', array('page_title'=>'RU | Admission', 'page_header'=>'Test'))

@section('body-content')
    <div class="panel panel-default full-height">
        <div class="panel-body">
            <legend>প্রথম বর্ষ স্নাতক (সম্মান)/ স্নাতক ভর্তি পরীক্ষা ২০২৩-২৪</legend>

            @if(session()->has('error'))
            <h4 class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> {{session('error')}}</h4>
            @endif

            {{-- elegibility criteria --}}
            {!! !empty($pageHomeMain->content) ? $pageHomeMain->content : '' !!}

            {{-- things needed for application --}}
            <hr>

            <div class="row">
                @if (setting('activate_preliminary_application', 0))
                    <p class="text-center">
                        <a class="btn btn-success col-sm-4 col-sm-offset-4" href="{{route('student.getLogin')}}"
                           role="button"><i class="fa fa-sign-in"></i> Start Preliminary Application</a>
                    </p>
                @elseif(setting('activate_final_application', 0))
                    <p class="text-center">
                        <a class="btn btn-success col-sm-4 col-sm-offset-4" href="{{route('student.getLogin')}}"
                           role="button"><i class="fa fa-sign-in"></i> Start Final Application</a>
                    </p>
                @else
                    <p class="text-center">
                        <a class="btn btn-success col-sm-4 col-sm-offset-4" href="{{route('student.getLogin')}}"
                           role="button"><i class="fa fa-sign-in"></i> Login</a>
                    </p>
                @endif


                @if ( setting('allow_post_application_login', 0) )
                    <p class="text-center">
                        <a class="btn btn-success col-sm-4 col-sm-offset-4"
                           href="{{route('admit_card.get_admit_card_form')}}" role="button"><i
                                class="fa fa-sign-in"></i> Login</a>
                    </p>
                @endif

                @if ( setting('allow_subject_choice_login', 0) )
                    <p class="text-center">
                        <a class="btn btn-primary col-sm-4 col-sm-offset-4"
                           href="{{route('subject_choice.get_login_form')}}" role="button"><i class="fa fa-sign-in"></i>
                            Login</a>
                    </p>
                @endif

                {{-- @if(config('app.debug'))
                     <p class="text-center">
                         <a class="btn btn-danger col-sm-4 col-sm-offset-4" href="{{route('reset-all')}}" role="button"
                            onclick="return confirm('Are you sure you want to reset?')"><i class="fa fa-sign-in"></i>
                             Reset
                             Data</a>
                         <br>
                         <a class="btn btn-danger col-sm-4 col-sm-offset-4" href="{{route('change-settings')}}"
                            role="button"
                            onclick="return confirm('Are you sure you want to reset?')"><i class="fa fa-sign-in"></i>
                             Change
                             Settings</a>
                     </p>

                 @endif--}}
            </div>
            <div>
                <br>

                {{-- <hr>
                <div class="row">
                    <p class="text-center">
                        <a class="btn btn-primary" href="{{route('reg.get_missing_info')}}" role="button"><i class="fa fa-edit"></i> OTH Application</a>
                    </p>
                </div> --}}
            </div>
        </div>
    </div>

    {{-- modal for last day --}}
    @if ( setting('show_homepage_popup', 0) )
        <div class="modal fade" id="modal-id">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title text-danger"><i class="fa fa-exclamation-circle"></i> বিশেষ বিজ্ঞপ্তি
                        </h4>
                    </div>
                    <div class="modal-body">
                        {!!$popupContent->content!!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i>
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop


@section('script-extra')
    @if ( setting('show_homepage_popup', 0) )
        <script type="text/javascript">
            $(document).ready(function () {
                $(window).on('load', function () {
                    $('#modal-id').modal('show');
                });
            });
        </script>
    @endif

@stop

