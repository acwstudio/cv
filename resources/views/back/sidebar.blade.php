<!-- Sidebar -->
<ul class="sidebar navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ __('menu.sidebar.dashboard') }}</span>
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-folder"></i>
            <span>{{ __('menu.sidebar.pages') }}</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <h6 class="dropdown-header">{{ __('menu.sidebar.users') }}:</h6>
            <a class="dropdown-item" href="{{ route('users.index') }}">{{ __('menu.sidebar.userIndex') }}</a>
            <a class="dropdown-item" href="{{ route('users.create') }}">{{ __('menu.sidebar.userCreate') }}</a>
            {{--<a class="dropdown-item" href="#">Roles</a>--}}
            {{--<a class="dropdown-item" href="#">Permissions</a>--}}
            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">{{ __('menu.sidebar.posts') }}:</h6>
            <a class="dropdown-item" href="{{ route('posts.index') }}">{{ __('menu.sidebar.postIndex') }}</a>
            <a class="dropdown-item" href="{{ route('posts.create') }}">{{ __('menu.sidebar.postCreate') }}</a>
            {{--<a class="dropdown-item" href="#">Categories</a>--}}
            {{--<a class="dropdown-item" href="#">Tags</a>--}}
        </div>
    </li>
    {{--<li class="nav-item">--}}
        {{--<a class="nav-link" href="charts.html">--}}
            {{--<i class="fas fa-fw fa-chart-area"></i>--}}
            {{--<span>Charts</span></a>--}}
    {{--</li>--}}
    {{--<li class="nav-item">--}}
        {{--<a class="nav-link" href="tables.html">--}}
            {{--<i class="fas fa-fw fa-table"></i>--}}
            {{--<span>Tables</span></a>--}}
    {{--</li>--}}
</ul>