<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @yield('css')
        <title>Dashboard | @yield('title')</title>
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item px-1">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block px-1">
                        <a href="{{ route('homepage') }}" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block px-1">
                        <a href="#" class="nav-link">Contact</a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="btn btn-primary">Log Out</a>
                    </li>
                </ul>
            </nav>

            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <p class="brand-link text-center">
                    <span class="brand-text font-weight-light"><a href="{{ route('dashboard') }}">AdminLTE 3</a></span>
                </p>

                <div class="sidebar">
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item menu-open">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fa-solid fa-newspaper"></i>
                                    <p>
                                        Articles
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('articles.show') }}" class="nav-link">
                                            <i class="nav-icon fa-solid fa-angle-right"></i>
                                            <p>Show All Article</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('articles.create') }}" class="nav-link">
                                            <i class="nav-icon fa-solid fa-angle-right"></i>
                                            <p>Create Article</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item menu-open">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fa-solid fa-paperclip"></i>
                                    <p>
                                        Categories
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('categories.show') }}" class="nav-link">
                                            <i class="nav-icon fa-solid fa-angle-right"></i>
                                            <p>Show All Category</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('categories.create') }}" class="nav-link">
                                            <i class="nav-icon fa-solid fa-angle-right"></i>
                                            <p>Create Category</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>

            <div class="content-wrapper">
                @yield('main')
            </div>
        </div>
    </body>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('javascript')
</html>
