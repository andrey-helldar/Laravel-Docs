<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <!--Import Google Icon Font-->
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import lib.css-->
        <link rel="stylesheet" href="{{ elixir('css/ui.css') }}"  media="screen,projection"/>

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <!-- Start: preloader -->
        <div class="splash">
            <div class="preloader-wrapper small active">
                <div class="spinner-layer spinner-red-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End: preloader -->

        <nav>
            <div class="container">
                <div class="nav-wrapper">
                    <a href="/" class="brand-logo">Laravel</a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li class="active"><a href="{{ route('docs', ['version'=>'5.2']) }}">5.2</a></li>
                        <li><a href="https://laravel.com/docs/5.1" target="_blank">5.1</a></li>
                        <li><a href="https://laravel.com/docs/5.0" target="_blank">5.0</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row">

                <!-- Start: navbar -->
                <div class="col s12 m3 l2">
                    @include('navbars.'.str_replace('.','_',$version))
                </div>
                <!-- End: navbar -->

                <!-- Start: content -->
                <div class="col s12 m9 l10 content">
                    @yield('content')
                </div>
                <!-- End: content -->

            </div>
        </div>

        <!--Import jQuery before materialize.js-->
        <script src="{{ elixir('js/lib.js') }}"></script>
        <script src="{{ elixir('js/ui.js') }}"></script>
    </body>
</html>
