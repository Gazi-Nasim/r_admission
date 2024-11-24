	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{url('favicon.ico')}}">

	<title>{{ $page_title }}</title>

    <!-- Bootstrap core CSS -->
	@if (Config::get('app.debug'))
        {{ Html::style('assets/plugins/bootstrap/css/bootstrap.min.css') }}
        {{-- {{ Html::style('assets/plugins/bootstrap/css/bootstrap-theme.css') }} --}}
    	{{ Html::style('assets/plugins/font-awesome/css/font-awesome.min.css') }}
    @else
        {{ Html::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css') }}
        {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css') }}
    @endif

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
    {{ Html::style('assets/css/browser.detect.css') }}

