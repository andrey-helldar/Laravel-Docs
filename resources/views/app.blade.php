<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="alternate" hreflang="ru" href="http://laravel-doc.ru" />
        <link rel="alternate" hreflang="ru" href="http://laradoc.ru" />
        <link rel="alternate" hreflang="en" href="https://laravel.com/docs" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="google-site-verification" content="-owvDEW1swRom3qQ-xiW9s4kugNAeicaJAi9z9PPBcs" />

        <meta name="author" content="Andrey Helldar <helldar@ai-rus.com>" />

        <title>Laravel документация на русском</title>

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="{{ elixir('css/ui.css') }}"  media="screen,projection"/>
        <link rel="apple-touch-icon" href="/images/favicon.png">
        <link rel="shortcut icon" href="/images/favicon.png" />
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

        <!-- Start: navbar -->
        <ul id="dropdownMore" class="dropdown-content">
            <li><a href="https://laravel.com/docs/master/" target="_blank">Master</a></li>
            <li><a href="https://laravel.com/docs/4.2/" target="_blank">4.2</a></li>
        </ul>

        <nav>
            <div class="container">
                <div class="nav-wrapper">
                    <a href="/" class="brand-logo">Laravel</a>
                    <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>

                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        {!! $navbarTop or '<li><a href="'.route('docs', ['version'=>config('settings.version')]).'">'.config('settings.version').'</a></li>' !!}
                        <li><a href="https://laravel.com/docs/5.1" target="_blank">5.1</a></li>
                        <li><a href="https://laravel.com/docs/5.0" target="_blank">5.0</a></li>
                        <li><a class="dropdown-button" href="#!" data-activates="dropdownMore">&nbsp;<i class="material-icons right">list</i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End: navbar -->

        <div class="container">
            @if( view()->exists('navbars.'.str_replace('.','_',$version)) )
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
            @else
            @yield('content')
            @endif
        </div>

        <footer class="page-footer">
            <div class="container">
                <div class="row">
                    <div class="col l6 s12">
                        <h5 class="">Документация фреймворка Laravel</h5>
                        <p class="grey-text">Полный и актуальный перевод оригинальной документации для фреймворка Laravel 5 версии и выше.</p>
                    </div>
                    <div class="col l4 offset-l2 s12">
                        <h5 class="">Ссылки</h5>
                        <ul>
                            <li><a class="grey-text" target="_blank" href="http://ai-rus.com">AI RUS - Professional IT support</a></li>
                            <li><a class="grey-text" target="_blank" href="https://laravel.com">Laravel Official</a></li>
                            <li><a class="grey-text" target="_blank" href="https://gitter.im/LaravelRUS/chat">Чат русскоязычного сообщества</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container white-text">
                    © {{ $year }} AI RUS - Professional IT support
                    <a class="white-text right" href="#"><i class="material-icons tiny">expand_less</i> Наверх</a>
                </div>
            </div>
        </footer>

        <!--Import jQuery before materialize.js-->
        <script src="{{ elixir('js/lib.js') }}"></script>
        <script src="{{ elixir('js/ui.js') }}"></script>
    </body>
</html>
