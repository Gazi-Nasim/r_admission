<!DOCTYPE html>
<html lang="en">
  <head>
    @include('layouts.includes.head_admin')
  </head>

  <body>

    <!-- top nav bar -->
    @include('layouts.includes.navbar_admin')
    {{-- @yield('top-navbar') --}}

    <div class="container col-sm-12" id="main">
      <div class="row">
        {{-- right menu --}}
        @include('layouts.includes.sidebar_admin')

        <div class="col-sm-10" id="body-content">
        @yield('body-content')
        </div>
      </div>{{-- end row --}}
    </div><!-- /.container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    {{ HTML::script('assets/plugins/jquery/jquery.min.js') }}
    {{ HTML::script('assets/plugins/bootstrap/js/bootstrap.min.js') }}

   {{ HTML::script('assets/plugins/datepicker2/js/bootstrap-datepicker.js') }}

{{--   {{HTML::script('assets/plugins/alertify/lib/alertify.min.js')}}--}}

   @yield('script-extra')
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    {{-- <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script> --}}
    <script type="text/javascript">
      $(document).ready(function($) {
        function setHeight() {
            windowHeight = $(window).innerHeight();
            $('.full-height').css('min-height', windowHeight);
          };
          setHeight();

          $(window).resize(function() {
            setHeight();
          });
    });
    </script>
  </body>
</html>
