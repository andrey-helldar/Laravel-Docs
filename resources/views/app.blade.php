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
        <nav>
            <div class="container">
                <div class="nav-wrapper">
                    <a href="#" class="brand-logo">Laravel</a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li class="active"><a href="{{ route('docs', ['version'=>'5.2']) }}">5.2</a></li>
                        <li><a href="https://laravel.com/docs/5.1">5.1</a></li>
                        <li><a href="https://laravel.com/docs/5.0">5.0</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Start: content -->
        @yield('content')
        <!-- End: content -->

        <!--Import jQuery before materialize.js-->
        <script src="{{ elixir('js/lib.js') }}"></script>
        <script src="{{ elixir('js/ui.js') }}"></script>
    </body>
</html>
