@php
    $isDashboard  = request()->is('admin/dashboard');
    $isAttendance = request()->is('admin/attendance*');

    $isManageBook = request()->is('admin/manage_book*');
    $isBorrowBook = request()->is('admin/borrow_book*');
    $isReturnBook = request()->is('admin/return_book*');
    $isLibrary    = $isManageBook || $isBorrowBook || $isReturnBook;

    $isStudent    = request()->is('admin/student*');
    $isLecturer   = request()->is('admin/lecturer*');
    $isUser       = request()->is('admin/user*');
    $isMember     = $isStudent || $isLecturer || $isUser;

    $isDegree     = request()->is('admin/degree*');
    $isAnalytic   = request()->is('admin/analytic*');
    $isSetting    = request()->is('admin/setting');
    $isSupport    = request()->is('admin/support');
@endphp

<!-- ======================================== Sidebar List -->
<nav class="sidebar-nav" id="sidebarMenu">
    <!-- ==================================== Primary Top Nav -->
    <ul class="nav-list primary-nav">

        <li class="nav-item drop-container">
            <a href="{{ url('admin/dashboard') }}" class="nav-link sidebar-link drop-list {{ $isDashboard ? 'active' : '' }}">
                <span class="icon-dashboard material-symbols-rounded">dashboard</span>
                <span class="nav-label">Dashboard</span>
            </a>
            <!-- ==================================== Show Title -->
            <ul class="drop-menu">
                <li class="nav-item">
                    <a class="nav-link drop-title"> [ Dashboard ] </a>
                </li>
            </ul>
        </li>

        <li class="nav-item drop-container">
            <a href="{{ url('admin/attendance') }}" class="nav-link sidebar-link drop-list {{ $isAttendance ? 'active' : '' }}">
                <span class="icon-dashboard material-symbols-rounded">sensor_occupied</span>
                <span class="nav-label">Attendance</span>
            </a>
            <!-- ==================================== Show Title -->
            <ul class="drop-menu">
                <li class="nav-item">
                    <a class="nav-link drop-title"> [ Attendance ] </a>
                </li>
            </ul>
        </li>

        <!-- ==================================== Dropdown Menu Library -->
        <li class="nav-item drop-container {{ $isLibrary ? 'open' : '' }}">
            <a class="nav-link drop-list {{ $isLibrary ? 'active' : '' }}">
                <span class="icon-library material-symbols-rounded">newsstand</span>
                <span class="nav-label">Library</span>
                <span class="drop-icon material-symbols-rounded">keyboard_arrow_down</span>
            </a>
            <!-- ==================================== Dropdown -->
            <ul class="drop-menu">
                <li class="nav-item">
                    <a class="nav-link drop-title"> [ Library ] </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/manage_book') }}" class="nav-link drop-link sidebar-link {{ $isManageBook ? 'active' : '' }}">
                        <span class="icon material-symbols-rounded">book_2</span>
                        Manage Books
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/borrow_book') }}" class="nav-link drop-link sidebar-link {{ $isBorrowBook ? 'active' : '' }}">
                        <span class="icon material-symbols-rounded">book_3</span>
                        Borrow Books
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/return_book') }}" class="nav-link drop-link sidebar-link {{ $isReturnBook ? 'active' : '' }}">
                        <span class="icon material-symbols-rounded">rotate_auto</span>
                        Return Books
                    </a>
                </li>
            </ul>
        </li>

        <!-- ==================================== Dropdown Menu Members -->
        <li class="nav-item drop-container {{ $isMember ? 'open' : '' }}">
            <a class="nav-link drop-list {{ $isMember ? 'active' : '' }}">
                <span class="material-symbols-rounded">groups</span>
                <span class="nav-label">Member</span>
                <span class="drop-icon material-symbols-rounded">keyboard_arrow_down</span>
            </a>
            <!-- ==================================== Dropdown -->
            <ul class="drop-menu">
                <li class="nav-item">
                    <a class="nav-link drop-title"> [ Members ] </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/student') }}" class="nav-link drop-link sidebar-link {{ $isStudent ? 'active' : '' }}">
                        <span class="icon material-symbols-rounded">person_book</span>
                        Student
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/lecturer') }}" class="nav-link drop-link sidebar-link {{ $isLecturer ? 'active' : '' }}">
                        <span class="icon material-symbols-rounded">person_4</span>
                        Lecturer
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/user') }}" class="nav-link drop-link sidebar-link {{ $isUser ? 'active' : '' }}">
                        <span class="icon material-symbols-rounded">account_circle</span>
                        Users
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item drop-container">
            <a href="{{ url('admin/degree') }}" class="nav-link sidebar-link drop-list {{ $isDegree ? 'active' : '' }}">
                <span class="icon-dashboard material-symbols-rounded">school</span>
                <span class="nav-label">Degree</span>
            </a>
            <!-- ==================================== Show Title -->
            <ul class="drop-menu">
                <li class="nav-item">
                    <a class="nav-link drop-title"> [ Auth ] </a>
                </li>
            </ul>
        </li>

        <li class="nav-item drop-container">
            <a href="{{ url('admin/analytic') }}" class="nav-link sidebar-link drop-list {{ $isAnalytic ? 'active' : '' }}">
                <span class="material-symbols-rounded">bar_chart</span>
                <span class="nav-label">Analytic</span>
            </a>
            <!-- ==================================== Dropdown -->
            <ul class="drop-menu">
                <li class="nav-item">
                    <a class="nav-link drop-title"> [ Analytic ] </a>
                </li>
            </ul>
        </li>

        <li class="nav-item drop-container">
            <a href="{{ url('admin/setting') }}" class="nav-link sidebar-link drop-list {{ $isSetting ? 'active' : '' }}">
                <span class="material-symbols-rounded">settings</span>
                <span class="nav-label">Setting</span>
            </a>
            <!-- ==================================== Dropdown -->
            <ul class="drop-menu">
                <li class="nav-item">
                    <a class="nav-link drop-title"> [ Setting ] </a>
                </li>
            </ul>
        </li>
    </ul>


    <!-- ==================================== Secondary Bottom Nav -->
    <ul class="nav-list secondary-nav">

        <li class="nav-item drop-container {{ $isSupport ? 'open' : '' }}">
            <a href="{{ url('admin/support') }}" class="nav-link sidebar-link drop-list {{ $isSupport ? 'active' : '' }}">
                <span class="material-symbols-rounded">help</span>
                <span class="nav-label">Support</span>
            </a>
            <!-- ==================================== Show Title -->
            <ul class="drop-menu">
                <li class="nav-item">
                    <a class="nav-link drop-title"> [ Support ] </a>
                </li>
            </ul>
        </li>

        <li class="nav-item drop-container">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link drop-list logout-btn">
                    <span class="material-symbols-rounded icon icon-logout">logout</span>
                    <span class="nav-label">Logout</span>
                </button>
            </form>

            <!-- ==================================== Show Title -->
            <ul class="drop-menu">
                <li class="nav-item">
                    <a class="nav-link drop-title"> [ Logout ] </a>
                </li>
            </ul>
        </li>

    </ul>
</nav>

<script>
    // Restore dropdown height for any server-side pre-opened dropdowns
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.drop-container.open .drop-menu').forEach(function (menu) {
            menu.style.height = menu.scrollHeight + 'px';
        });
    });
</script>
