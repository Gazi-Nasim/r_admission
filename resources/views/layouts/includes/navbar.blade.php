@section('top-navbar')
    <nav class="navbar navbar-default navbar-fixed-top no-print no-print-border" id="top-nav">
        <div class="container col-md-10 col-md-offset-1">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{route('site.home')}}"><img src="{{ url('/assets/img/logo.png') }}"
                                                                           width="30" class="img-responsive"
                                                                           style="display: inline-block;"> Rajshahi
                    University</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    {{--               <li><a href="{{ route('site.admission_info') }}">Admission Instruction</a></li>--}}
                    <li><a href="{{ route('site.application_guideline') }}"> Application Guideline<sup><span
                                    class="label label-danger blink_me">Updated</span></sup></a></li>
                    <li><a href="{{ route('site.payment_info') }}">Payment Instruction</a></li>
                    <li><a href="{{ route('site.photo_guideline') }}">Photo/Selfie Instruction</a></li>
                    {{-- <li><a href="{{ route('reg.get_info_review') }}">Complain Box</a></li> --}}
                    <li><a href="{{ route('site.contact') }}">Contact</a></li>
                </ul>
                @if(auth()->user() && auth()->user()->hasRole('Admin'))
                    <ul class="nav navbar-nav navbar-right">
                        <li><a class="btn-warning" href="{{route('admin.student.logoutAsStudent')}}"><i class="fa fa-sign-in"></i> {{auth()->user()->username}}</a></li>
                    </ul>
                @endif
            </div><!-- /.navbar-collapse -->
        </div>
    </nav>
@show
