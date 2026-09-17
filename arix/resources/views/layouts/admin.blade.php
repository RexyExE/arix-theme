<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ config('app.name', 'Pterodactyl') }} - @yield('title')</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="_token" content="{{ csrf_token() }}">

        <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
        <link rel="icon" type="image/png" href="/favicons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="/favicons/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="/favicons/manifest.json">
        <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#bc6e3c">
        <link rel="shortcut icon" href="/favicons/favicon.ico">
        <meta name="msapplication-config" content="/favicons/browserconfig.xml">
        <meta name="theme-color" content="#0e4688">

        @include('layouts.scripts')

        @section('scripts')
            {!! Theme::css('vendor/select2/select2.min.css?t={cache-version}') !!}
            {!! Theme::css('vendor/bootstrap/bootstrap.min.css?t={cache-version}') !!}
            {!! Theme::css('vendor/adminlte/admin.min.css?t={cache-version}') !!}
            {!! Theme::css('vendor/adminlte/colors/skin-blue.min.css?t={cache-version}') !!}
            {!! Theme::css('vendor/sweetalert/sweetalert.min.css?t={cache-version}') !!}
            {!! Theme::css('vendor/animate/animate.min.css?t={cache-version}') !!}
            {!! Theme::css('css/pterodactyl.css?t={cache-version}') !!}
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap">
            <link rel="stylesheet" href="/themes/pterodactyl/css/arix-silk-veil.css">
            <script src="/themes/pterodactyl/js/arix-silk-veil.js" defer></script>

            <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
        @show

        <style>
            :root {
                --primary: {{ $siteConfiguration['arix']['primary'] }};
                --primary-border: color-mix(in srgb, var(--primary) 75%, white 25%);

                --text: {{ $siteConfiguration['arix']['gray200'] }};
                --text-secondary: {{ $siteConfiguration['arix']['gray300'] }};

                --box: {{ $siteConfiguration['arix']['gray700'] }};
                --box-header: {{ $siteConfiguration['arix']['gray700'] }};
                
                --active-border: {{ $siteConfiguration['arix']['gray500'] }};
                --active: {{ $siteConfiguration['arix']['gray600'] }};

                --input: {{ $siteConfiguration['arix']['gray600'] }};
                --input-border: {{ $siteConfiguration['arix']['gray500'] }};

                --sidebar: {{ $siteConfiguration['arix']['gray700'] }};

                --background: {{ $siteConfiguration['arix']['gray800'] }};
            }

            .logo-badge {
                font-size: 0.62rem;
                font-weight: 700;
                color: #a855f7;
                background: rgba(168, 85, 247, 0.15);
                border: 1px solid rgba(168, 85, 247, 0.3);
                padding: 0.15rem 0.5rem;
                border-radius: 9999px;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                margin-left: 0.4rem;
            }

            .arix-nav-badge {
                font-size: 0.58rem;
                font-weight: 700;
                color: #c084fc;
                background: rgba(139, 92, 246, 0.18);
                border: 1px solid rgba(139, 92, 246, 0.35);
                padding: 0.12rem 0.45rem;
                border-radius: 9999px;
                letter-spacing: 0.06em;
                text-transform: uppercase;
                margin-left: auto;
            }
        </style>
    </head>
    <body class="hold-transition skin-blue fixed sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <a href="{{ route('index') }}" class="logo">
                    <span class="logo-mini"><i data-lucide="shield" style="width: 22px; height: 22px; color: #a855f7;"></i></span>
                    <span class="logo-lg">
                        <i data-lucide="shield" style="width: 20px; height: 20px; color: #a855f7;"></i>
                        <span class="logo-text">{{ config('app.name', 'Pterodactyl') }}</span>
                        <span class="logo-badge">ADMIN</span>
                    </span>
                </a>
                <nav class="navbar navbar-static-top">
                    <div class="navbar-left">
                        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" aria-label="Toggle navigation">
                            <i data-lucide="menu" class="toggle-icon" style="width: 20px; height: 20px;"></i>
                        </a>
                        <div class="header-breadcrumbs hidden-xs">
                            <i data-lucide="terminal" style="width: 14px; height: 14px; color: #8b5cf6;"></i>
                            <span>Admin Console</span>
                        </div>
                    </div>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="user-menu">
                                <a href="{{ route('account') }}">
                                    <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(Auth::user()->email)) }}?s=160" class="user-image" alt="User Image">
                                    <span class="hidden-xs user-name">{{ Auth::user()->name_first }} {{ Auth::user()->name_last }}</span>
                                    <span class="user-role-badge hidden-xs">ROOT</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('index') }}" data-toggle="tooltip" data-placement="bottom" title="Exit to Client Panel" class="nav-action-btn"><i data-lucide="layout-dashboard" style="width: 18px; height: 18px;"></i></a>
                            </li>
                            <li>
                                <a href="{{ route('auth.logout') }}" id="logoutButton" data-toggle="tooltip" data-placement="bottom" title="Logout" class="nav-action-btn logout"><i data-lucide="log-out" style="width: 18px; height: 18px;"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <aside class="main-sidebar">
                <section class="sidebar">
                    <ul class="sidebar-menu">
                        <li class="header">BASIC ADMINISTRATION</li>
                        <li class="{{ Route::currentRouteName() !== 'admin.index' ?: 'active' }}">
                            <a href="{{ route('admin.index') }}">
                                <i data-lucide="home"></i> <span>Overview</span>
                            </a>
                        </li>
                        <li class="{{ ! \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.settings') ?: 'active' }}">
                            <a href="{{ route('admin.settings')}}">
                                <i data-lucide="settings"></i> <span>Settings</span>
                            </a>
                        </li>
                        <li class="{{ ! \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.arix') ?: 'active' }}">
                            <a href="{{ route('admin.arix')}}">
                                <i data-lucide="wand-2"></i><span>Arix Theme</span>
                                <span class="arix-nav-badge">THEME</span>
                            </a>
                        </li>
                        <li class="{{ ! \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.api') ?: 'active' }}">
                            <a href="{{ route('admin.api.index')}}">
                                <i data-lucide="webhook"></i> <span>Application API</span>
                            </a>
                        </li>
                        <li class="header">MANAGEMENT</li>
                        <li class="{{ ! \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.databases') ?: 'active' }}">
                            <a href="{{ route('admin.databases') }}">
                                <i data-lucide="database"></i> <span>Databases</span>
                            </a>
                        </li>
                        <li class="{{ ! \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.locations') ?: 'active' }}">
                            <a href="{{ route('admin.locations') }}">
                                <i data-lucide="globe-2"></i> <span>Locations</span>
                            </a>
                        </li>
                        <li class="{{ ! \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.nodes') ?: 'active' }}">
                            <a href="{{ route('admin.nodes') }}">
                                <i data-lucide="server"></i> <span>Nodes</span>
                            </a>
                        </li>
                        <li class="{{ ! \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.servers') ?: 'active' }}">
                            <a href="{{ route('admin.servers') }}">
                                <i data-lucide="terminal-square"></i> <span>Servers</span>
                            </a>
                        </li>
                        <li class="{{ ! \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.users') ?: 'active' }}">
                            <a href="{{ route('admin.users') }}">
                                <i data-lucide="users"></i> <span>Users</span>
                            </a>
                        </li>
                        <li class="header">SERVICE MANAGEMENT</li>
                        <li class="{{ ! \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.mounts') ?: 'active' }}">
                            <a href="{{ route('admin.mounts') }}">
                                <i data-lucide="folder"></i> <span>Mounts</span>
                            </a>
                        </li>
                        <li class="{{ ! \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.nests') ?: 'active' }}">
                            <a href="{{ route('admin.nests') }}">
                                <i data-lucide="layout-grid"></i> <span>Nests</span>
                            </a>
                        </li>
                    </ul>
                </section>
            </aside>
            <div class="sidebar-backdrop" data-toggle="push-menu"></div>
            <div class="content-wrapper">
                <section class="content-header">
                    @yield('content-header')
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    There was an error validating the data provided.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @foreach (Alert::getMessages() as $type => $messages)
                                @foreach ($messages as $message)
                                    <div class="alert alert-{{ $type }} alert-dismissable" role="alert">
                                        {{ $message }}
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                    @yield('content')
                </section>
            </div>
            <footer class="main-footer">
                <div class="pull-right small text-gray" style="margin-right:10px;margin-top:-7px;">
                    <strong><i class="fa fa-fw {{ $appIsGit ? 'fa-git-square' : 'fa-code-fork' }}"></i></strong> {{ $appVersion }}<br />
                    <strong><i class="fa fa-fw fa-clock-o"></i></strong> {{ round(microtime(true) - LARAVEL_START, 3) }}s
                </div>
                Copyright &copy; 2015 - {{ date('Y') }} <a href="https://pterodactyl.io/">Pterodactyl Software</a>.
            </footer>
        </div>
        @section('footer-scripts')
            <script src="/js/keyboard.polyfill.js" type="application/javascript"></script>
            <script>keyboardeventKeyPolyfill.polyfill();</script>

            {!! Theme::js('vendor/jquery/jquery.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/sweetalert/sweetalert.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/bootstrap/bootstrap.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/slimscroll/jquery.slimscroll.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/adminlte/app.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/bootstrap-notify/bootstrap-notify.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/select2/select2.full.min.js?t={cache-version}') !!}
            {!! Theme::js('js/admin/functions.js?t={cache-version}') !!}
            <script src="/js/autocomplete.js" type="application/javascript"></script>

            <script src="https://unpkg.com/lucide@latest"></script>
            <script>
                lucide.createIcons();
            </script>

            @if(Auth::user()->root_admin)
                <script>
                    $('#logoutButton').on('click', function (event) {
                        event.preventDefault();

                        var that = this;
                        swal({
                            title: 'Do you want to log out?',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d9534f',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Log out'
                        }, function () {
                             $.ajax({
                                type: 'POST',
                                url: '{{ route('auth.logout') }}',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },complete: function () {
                                    window.location.href = '{{route('auth.login')}}';
                                }
                        });
                    });
                });
                </script>
            @endif

            <script>
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                })
            </script>
        @show
    </body>
</html>
