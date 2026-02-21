 <!-- ============================================= Section Navbar -->
<nav class="top">
    <!-- ======================================== Mobile Sidebar Menu Button -->
    <button class="sidebar-menu-button">
        <span class="material-symbols-rounded">menu</span>
    </button>
    <!-- ======================================== LOGO TEXT -->
    <p class="title">

        <span>RPITST</span> Library<span>.</span>
    </p>

    <form  action="#">
        <div class="form-group">
            <input type="text" placeholder="Search ...">
            <span class="material-symbols-rounded icon">search</span>
        </div>
    </form>

    <a href="#" class="nav-link">
        <span class="material-symbols-rounded icon">notifications</span>
        <span class="badge">5</span>
    </a>

    <a href="#" class="nav-link">
        <span class="material-symbols-rounded icon">sms</span>
        <span class="badge">8</span>
    </a>

    <div class="nav-link">
        <span class="material-symbols-rounded icon mode-toggle">light_mode</span>
    </div>


    <span class="divider"></span>


    @php
        $roles = [
            'admin' => 'Admin',
            'librarian' => 'Librarian',
        ];
    @endphp

    <span class="name-user">
        {{ auth()->user()->name_formatted  }}<br>
        <small>{{ $roles[auth()->user()->role] ?? auth()->user()->role }}</small>
    </span>



    <div class="profile">
        <img src="{{ asset('assets/image/img_dashboard/default_avatar.png') }}" alt="default_avatar.png">

        <ul class="profile-link">
            <li>
            <a href="#">
                <span class="material-symbols-rounded icon">account_circle</span>
                Profile
            </a>
            </li>
            <li>
                <a href="#">
                    <span class="material-symbols-rounded icon">settings</span>
                    Setting
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" >
                        <span class="material-symbols-rounded icon icon-logout">logout</span>
                        <span >Logout</span>
                    </button>
                </form>
            </li>

        </ul>
    </div>
</nav>
