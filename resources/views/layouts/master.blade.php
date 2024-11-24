<!DOCTYPE html>
<html lang="en">
<head>
    @if (config('app.debug')==false)
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-5ZWPXPH');</script>
        <!-- End Google Tag Manager -->

    @endif

    @include('layouts.includes.head')
</head>

<body>
@if (config('app.debug')==true)
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5ZWPXPH"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
@endif
<!-- top nav bar -->
@include('layouts.includes.navbar')
{{-- @yield('top-navbar') --}}

<div class="container col-sm-10 col-sm-offset-1" id="main">
    <div class="row">
        {{-- left menu --}}
        @include('layouts.includes.sidebar')
        <div class="col-sm-9" id="body-content">
            @yield('body-content')
        </div>
    </div>{{-- end row --}}
</div><!-- /.container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
@if (config('app.debug'))
    {{ Html::script('assets/plugins/jquery/jquery.min.js') }}
    {{ Html::script('assets/plugins/bootstrap/js/bootstrap.min.js') }}
@else
    {{Html::script('https://code.jquery.com/jquery-1.11.3.min.js')}}
    {{ Html::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js') }}
@endif

{{--{{ Html::script('assets/plugins/jquery-countdown/jquery.countdown.min.js') }}--}}

<script>
    var $buoop = {
        vs: {i: 9, f: 5, o: 12, s: 7, c: 10},
        reminder: 0,
        text: "Your browser (%s) is out of date, and may not be compatible with our website. We recommend you to <a%s>update your browser</a>"
    };

    function $buo_f() {
        var e = document.createElement("script");
        e.src = "//browser-update.org/update.min.js";
        document.body.appendChild(e);
    }

    try {
        document.addEventListener("DOMContentLoaded", $buo_f, false)
    } catch (e) {
        window.attachEvent("onload", $buo_f)
    }
</script>

<script type="text/javascript">
    // $(document).ready(function() {
    //   $('#clock').countdown('2015/10/19 12:00:00', function(event) {
    //     var totalHours = event.offset.totalDays * 24 + event.offset.hours;
    //     $(this).html(event.strftime(totalHours + ' hr %M min %S sec'));
    //   });

    // });
</script>

@yield('script-extra')
<script type="text/javascript">
    $(document).ready(function ($) {
        function setHeight() {
            windowHeight = $(window).innerHeight();
            $('.full-height').css('min-height', windowHeight);
        }

        setHeight();

        $(window).resize(function () {
            setHeight();
        });
    });
</script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
{{-- <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script> --}}
</body>
</html>
