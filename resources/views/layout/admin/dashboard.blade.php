<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard E-Library</title>

    <!-- Logo Website -->
    <link rel="icon" type="image/png" href="{{ asset('assets/image/img_welcome/RPITST.png') }}">

    <!-- Link Icon Google -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0"/>


    @yield('other_link_head')

    <!-- Link AOS Animation Scroll -->
   <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
   

    <!-- Customization Style -->
    <link rel="stylesheet" href="{{ asset('assets/css/style_dashboard/style_dashboard.css') }}">
    @yield('link_custom')


</head>
<body>


    <!-- ============================================= Section Sidebar -->

    <aside class="sidebar">
        <!-- ======================================== Sidebar Header -->
        <header class="sidebar-header">
            <a class="header-logo">
                <img src="{{ asset('assets/image/img_welcome/RPITST.png') }}" alt="imgLogo" />
            </a>
            <button class="sidebar-toggler">
            <span class="material-symbols-rounded">chevron_left</span>
            </button>
        </header>

        @include('layout.admin.section.sidebar')


    </aside>



    <!-- ============================================= Section Dashboard -->
    <section class="dashboard">

        @include('layout.admin.section.navbar')

        @yield('content')






    </section>




<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 1200,
    easing: 'ease-out-cubic',
    once: true
  });
</script>



@yield('other_script')


<script src="{{ asset('assets/js/script_dashboard/script_dashboard.js') }}"></script>

@yield('script_custom')

</body>
</html>
