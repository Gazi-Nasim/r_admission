<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.includes.head_admin')
    {{ Html::style('assets/css/signin.css') }}
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-md-push-4">

            @if(Session::has('message'))
                <div class="alert alert-danger">
                    <strong>{{Session::get('message') }}</strong>
                </div>
            @endif


            {{ Form::open(array('route' => 'user.postLogin', 'class'=>'form-signin')) }}
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-lock"></i> <a href="{{route('site.home')}}">RU Admission 2023-24</a>  </h3>
                </div>
                <div class="panel-body">
                    <label for="username" class="sr-only">User Name</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="User ID" required autofocus>
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                    <button class="btn btn-lg btn-primary btn-block" type="submit"> Login <i class="fa fa-sign-in"></i></button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div><!-- /.container -->
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
{{ Html::script('assets/plugins/jquery/jquery.min.js') }}
{{ Html::script('assets/plugins/bootstrap/js/bootstrap.min.js') }}
</body>
</html>

