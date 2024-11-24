	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{url('favicon.ico')}}">

	<title>{{ $page_title }}</title>

    <!-- Bootstrap core CSS -->
    {{ Html::style('assets/plugins/bootstrap/css/bootstrap.min.css') }}
    {{ Html::style('assets/plugins/font-awesome/css/font-awesome.min.css') }}

    {{ Html::style('assets/plugins/datepicker2/css/datepicker.css') }}
{{--    {{Html::style('assets/plugins/alertify/themes/alertify.core.css')}}--}}
{{--    {{Html::style('assets/plugins/alertify/themes/alertify.default.css')}}--}}

    <!-- Custom styles for this template -->
    @yield('css-extra')

	{{ Html::style('assets/css/style.css') }}
    {{ Html::style('assets/css/navbar.css') }}
	{{-- need to modify --}}
    {{-- <script src="../../assets/js/ie-emulation-modes-warning.js"></script> --}}

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
