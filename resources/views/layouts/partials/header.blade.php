<!-- Main Header -->
<header class="main-header">
    @if(config('adminlte.layout') == 'top-nav')
        <nav class="navbar navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="navbar-brand">
                        {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                    </a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                        @each('layouts.partials.menu-item-top-nav', $adminlte->menu(), 'item')
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            @include("layouts.partials.nav-bar")
        </nav>
    @else
        <!-- Logo -->
        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">{{ trans('app.toggle_navigation') }}</span>
            </a>
            @include("layouts.partials.nav-bar")
        </nav>
    @endif
</header>