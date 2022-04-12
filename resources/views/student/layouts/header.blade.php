<?php
if (Auth::check()) {
    $role = Auth::user()->role;
} else {
    $role = 'admin';
}
?>
<nav class="navbar  navbar-expand-lg navbar-light header">
    <a class="navbar-brand headerr" href="{{ url("/$role/student/") }}">School Management System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav ">

            @if (Auth::check())
                <li class="nav-item active">
                    <a class="nav-link menus" href="{{ url("/$role/student/") }}">Home </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link menus" href="{{ url("/$role/student/view") }}">Student </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link menus" href="#">Teacher </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link menus" href="#">Courses </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link menus" href="#">Attendance </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link menus" href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">Logout </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @else
                <li class="nav-item active">
                    <a class="nav-link menus" href="{{ url('/login') }}">Login </a>
                </li>
            @endif
        </ul>
    </div>
</nav>
