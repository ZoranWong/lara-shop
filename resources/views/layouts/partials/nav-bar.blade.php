<!-- Navbar Right Menu -->
<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
        {!! \App\Renders\Facades\SectionContent::getNavBar()->render() !!}
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{ \App\Renders\Facades\SectionContent::user()->head_image_url }}" class="user-image" alt="User Image">
                <span class="hidden-xs">{{ \App\Renders\Facades\SectionContent::user()->nickname }}</span>
            </a>
            <ul class="dropdown-menu">
                <li class="dropdown-item user-header">
                    <img src="{{ \App\Renders\Facades\SectionContent::user()->head_image_url }}" class="img-circle" alt="User Image">
                    <p>
                        {{ \App\Renders\Facades\SectionContent::user()->nickname }}
                        <small>Member since admin {{ \App\Renders\Facades\SectionContent::user()->created_at }}</small>
                    </p>
                </li>
                <li class="dropdown-item user-footer">
                    <div class="pull-left">
                        <a href="{{ url('/setting') }}" class="btn btn-default btn-flat">{{ trans('admin.setting') }}</a>
                    </div>
                    <div class="pull-right">
                        <a href="{{ url('auth/logout') }}" class="btn btn-default btn-flat">{{ trans('admin.logout') }}</a>
                    </div>
                </li>
            </ul>
        </li>
    </ul>