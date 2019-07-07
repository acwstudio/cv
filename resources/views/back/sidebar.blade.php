<!-- Sidebar -->
<ul class="sidebar navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <h6 class="dropdown-header">Users:</h6>
            <a class="dropdown-item" href="{{ route('users.index') }}">User's List</a>
            <a class="dropdown-item" href="#">Roles</a>
            <a class="dropdown-item" href="#">Permissions</a>
            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Posts:</h6>
            <a class="dropdown-item" href="{{ route('posts.index') }}">Post's List</a>
            <a class="dropdown-item" href="#">Categories</a>
            <a class="dropdown-item" href="#">Tags</a>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li>
</ul>