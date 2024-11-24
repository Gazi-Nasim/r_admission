@section('top-navbar')
<nav class="navbar navbar-inverse navbar-fixed-top no-print no-print-border" id="top-nav"   >
      <div class="container col-sm-10 col-sm-offset-1">
        <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="{{route('user.dashboard')}}"><img src="{{ url('/assets/img/logo.png') }}"  width="30" class="img-responsive" style="display: inline-block;"> Rajshahi University</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Instruction</a></li>
      <li><a href="#">Contact Us</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
       <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> {{Auth::user()->fullname}} <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="dropdown-header">Update</li>
            <li><a href="{{ route('user.getChangePassword') }}"><span class="glyphicon glyphicon-edit"></span> Change Password</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ route('user.logout') }}"><i class="fa fa-sign-in"></i> Logout</a></li>
          </ul>
        </li>
    </ul>
  </div><!-- /.navbar-collapse -->
      </div>
    </nav>
@show
