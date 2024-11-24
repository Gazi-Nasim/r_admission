@section('sidebar')
    <style type="text/css">
        /* make sidebar nav vertical */
        @media (min-width: 768px) {
            .sidebar-nav .navbar .navbar-collapse {
                padding: 0;
                max-height: none;
            }

            .sidebar-nav .navbar ul {
                float: none;
            }

            .sidebar-nav .navbar ul:not {
                display: block;
            }

            .sidebar-nav .navbar li {
                float: none;
                display: block;
            }

            .sidebar-nav .navbar li a {
                padding-top: 12px;
                padding-bottom: 12px;
            }
        }

        .label-as-badge {
            border-radius: 1em;
        }
    </style>

    <div class="col-sm-3 no-print" id="sidebar">
        {{--Student menu--}}
        @php
            $student  =session()->get('student', null);
        @endphp
        @if(session()->has('student') && isset($student))
            <div class="sidebar-nav">
                <div class="navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target=".sidebar-navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <span class="visible-xs navbar-brand"><i class="fa fa-list-ul"></i> Menu</span>
                    </div>
                    <div class="navbar-collapse collapse sidebar-navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li @class(['active'=>Route::is('student.getDashboard')]) ><a
                                    href="{{route('student.getDashboard')}}"><i class="fa fa-home"></i> Student
                                    Panel</a>
                            </li>
                            @if( !$student?->isEnrollingForFirstTime() )

                                @if(setting('allow_photo_change', 0) && $student->hasPaidEnrollmentBill())
                                    @if(setting('photo_change_needs_payment', 0))
                                        <li @class(['active'=>Route::is('photo_change.index')])><a
                                                href="{{ route('photo_change.index') }}"><i
                                                    class="fa fa-camera"></i> Photo Change Request</a></li>
                                    @else
                                        <li @class(['active'=>Route::is('preliminary.getUploadStudentPhoto')])><a
                                                href="{{ route('preliminary.getUploadStudentPhoto') }}"><i
                                                    class="fa fa-camera"></i> Update Photo</a></li>
                                    @endif
                                @endif

                                @if(setting('allow_selfie_change', 0))
                                    <li @class(['active'=>Route::is('getSelfieIndex')])><a
                                            href="{{ route('getSelfieIndex') }}"><i
                                                class="fa fa-user"></i> Update Selfie</a></li>

                                @endif

                                @if(setting('allow_quota_update', 0) && $student->hasPaidEnrollmentBill())
                                    <li @class(['active'=>Route::is('preliminary.getQuotaIndex')])><a
                                            href="{{ route('preliminary.getQuotaIndex') }}"><i
                                                class="fa fa-book"></i>
                                             Update Quota</a></li>
                                @endif

                                @if(setting('allow_question_language_update', 0) && $student->hasPaidEnrollmentBill())
                                    <li @class(['active'=>Route::is('preliminary.getLanguageIndex')])><a
                                            href="{{ route('preliminary.getLanguageIndex') }}"><i
                                                class="fa fa-font"></i>
                                            Update Question Language</a></li>
                                @endif

                                    <li @class(['active'=>Route::is('mobile_change.getMobileChangeForm')])><a
                                            href="{{ route('mobile_change.getMobileChangeForm') }}"><i
                                                class="fa fa-mobile-phone"></i>
                                            Update Mobile No.</a></li>

                            @endif

                            @if($student->isEligible())
                                <li @class(['active'=>Route::is('identity_verification.index')])><a
                                        href="{{ route('identity_verification.index') }}"><i
                                            class="fa fa-certificate"></i>
                                        Mobile No. Verification </a></li>
                            @endif
                            @if(setting('allow_complaint_submission', 0))
                                <li><a href="{{ route('complainbox.index') }}"><i class="fa fa-envelope"></i> Complain Box</a></li>

                            @endif
                            @if($student->zone_submitted)
                                <li><a href="{{route('preliminary.UpdateZones')}}"><i class="fa fa-calendar"></i> Update Zones</a></li>

                            @endif
                            <li><a href="{{ route('student.getLogout') }}"><i class="fa fa-sign-out"></i> Logout </a>
                            </li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        @endif

        {{--Importent Dates--}}

        <div class="panel panel-primary @if(Route::is('*Selfie*')) visible-md @endif">

            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-calendar"></i> Important Dates</h3>
            </div>

            @php
                $content = \App\Models\PageContent::where('name', 'sidebar_important_dates')->first();
            @endphp
            {!! !empty($content->content) ? Blade::compileString($content->content) : '' !!}
        </div>


        {{--helpline--}}
        <div class="panel panel-success @if(Route::is('*Selfie*')) visible-md @endif"">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-question"></i> Helpline</h3>
            </div>
            <div class="panel-body">
                @php
                    $content = \App\Models\PageContent::where('name', 'sidebar_help_line')->first();
                @endphp

                {!! !empty($content->content) ? Blade::compileString($content->content) : '' !!}
            </div>
        </div>

    </div>
@show
