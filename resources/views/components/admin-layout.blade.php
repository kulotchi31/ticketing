@php

    $currentPage = match(true) {
        request()->routeIs('admin.index') => 'dashboard',
        request()->routeIs('campus.*') => 'campus',
        request()->routeIs('department.*') => 'department',
        request()->routeIs('users.*') => 'users',
        request()->routeIs('provider.*') => 'provider',
        request()->routeIs('request.*') => 'request',
        request()->routeIs('category.*') => 'category',
        request()->routeIs('ticket.*') => 'ticket',
        default => 'dashboard',
    };

@endphp
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>NEUST Ticketing System</title>
  <link rel="stylesheet" href="/mistemplates/assets/css/app.css">
  <link rel="stylesheet" href="/mistemplates/assets/css/bootstrap-icons.min.css">




  <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">





      <link
        rel="icon"
        type="image/png"
        href="{{ asset('/img/favicon.png') }}">



        <!-- Datatables -->
        <link rel="stylesheet" media="screen" href="/datatable/datatables.css">
        <link rel="stylesheet" media="screen" href="/datatable/buttons.dataTables.min.css">

        <link rel="stylesheet" href="/css/sweetalert2.css">



           @stack('styles')

</head>

<body class="theme-default">

  <!-- Mobile overlay -->
  <div class="overlay" id="overlay" aria-hidden="true"></div>

  <!-- ✅ set current page here -->
  <div class="app" data-page="{{ $currentPage }}">

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

      <!-- BRAND -->
      <div class="sidebar__brand">
        <div class="brand__logo">A</div>
        <div class="brand__text">
          <div class="brand__title">Admin</div>
          <div class="brand__sub">v1.0</div>
        </div>
      </div>

     
     {{--  <div class="sidebar__search">
        <input type="text" placeholder="Search...">
      </div> --}}

      @php
    $managementActive = request()->routeIs(
        'users.*',
        'campus.*',
        'department.*'
    );

    $servicesActive = request()->routeIs(
        'provider.*',
        'request.*',
        'category.*',
    );


      $ticketActive = request()->routeIs(
        'ticket.*',
    );



@endphp

      <nav class="sidebar__nav">

    <!-- DASHBOARD -->
    <a
        class="nav__item {{ request()->routeIs('admin.index') ? 'active' : '' }}"
        href="{{ route('admin.index') }}"
        data-page="dashboard"
    >
        <i class="bi bi-speedometer2 nav__icon"></i>
        <span class="nav__label">Dashboard</span>
    </a>


    <!-- MANAGEMENT GROUP -->
    <div
        class="nav__group {{ $managementActive ? 'open' : '' }}"
        data-group="management"
    >

        <!-- MANAGEMENT TOGGLE -->
        <div
            class="nav__item nav__toggle {{ $managementActive ? 'active' : '' }}"
            data-toggle="management"
        >
            <i class="bi bi-kanban nav__icon"></i>

            <span class="nav__label">Management</span>

            <i class="bi bi-chevron-right nav__arrow"></i>
        </div>


        <!-- SUBMENU -->
        <div
            class="nav__submenu {{ $managementActive ? 'open' : '' }}"
            id="management"
        >

          

            <!-- CAMPUSES -->
            <a
                class="nav__subitem {{ request()->routeIs('campus.*') ? 'active' : '' }}"
                href="{{ route('campus.index') }}"
                data-page="campus"
            >
                <i class="bi bi-buildings"></i>
                <span>Campuses</span>
            </a>


            <!-- DEPARTMENT -->
            <a
                class="nav__subitem {{ request()->routeIs('department.*') ? 'active' : '' }}"
                href="{{ route('department.index') }}"
                data-page="department"
            >
                <i class="bi bi-building"></i>
                <span>Department</span>
            </a>


              <!-- USERS -->
            <a
                class="nav__subitem {{ request()->routeIs('users.*') ? 'active' : '' }}"
                href="{{route('users.index')}}"
                data-page="users"
            >
                <i class="bi bi-person"></i>
                <span>Users</span>
            </a>



        </div>





    </div>



    <div
        class="nav__group {{ $servicesActive ? 'open' : '' }}"
        data-group="services"
    >

       
        <div
            class="nav__item nav__toggle {{ $servicesActive ? 'active' : '' }}"
            data-toggle="services"
        >
            <i class="bi bi-grid nav__icon"></i>

            <span class="nav__label">Services</span>

            <i class="bi bi-chevron-right nav__arrow"></i>
        </div>


        <!-- SUBMENU -->
        <div
            class="nav__submenu {{ $servicesActive ? 'open' : '' }}"
            id="services"
        >

    
            <a
                class="nav__subitem {{ request()->routeIs('provider.*') ? 'active' : '' }}"
                href="{{ route('provider.index') }}"
                data-page="provider"
            >
                <i class="bi bi-briefcase"></i>
                <span>Service Provider</span>
            </a>



              <a
                class="nav__subitem {{ request()->routeIs('request.*') ? 'active' : '' }}"
                href="{{ route('request.index') }}"
                data-page="request"
            >
                <i class="bi bi-list-check"></i>
                <span>Request Type</span>
            </a>


              <a
                class="nav__subitem {{ request()->routeIs('category.*') ? 'active' : '' }}"
                href="{{ route('category.index') }}"
                data-page="category"
            >
                <i class="bi bi-tags"></i>
                <span>Category</span>
            </a>


        </div>



        

    </div>



       <div
        class="nav__group {{ $ticketActive ? 'open' : '' }}"
        data-group="services"
    >

       
        <div
            class="nav__item nav__toggle {{ $ticketActive ? 'active' : '' }}"
            data-toggle="services"
        >
            <i class="bi-ticket-detailed nav__icon"></i>

            <span class="nav__label">Tickets</span>

            <i class="bi bi-chevron-right nav__arrow"></i>
        </div>


        <!-- SUBMENU -->
        <div
            class="nav__submenu {{ $ticketActive ? 'open' : '' }}"
            id="services"
        >

    
            <a
                class="nav__subitem {{ request()->routeIs('ticket.*') ? 'active' : '' }}"
                href="{{ route('ticket.index') }}"
                data-page="ticket"
            >
                <i class="bi-ticket-perforated"></i>
                <span>All Tickets</span>
            </a>



              <a
                class="nav__subitem {{ request()->routeIs('request.*') ? 'active' : '' }}"
                href="{{ route('request.index') }}"
                data-page="request"
            >
                <i class="bi bi-list-check"></i>
                <span>Request Type</span>
            </a>


              <a
                class="nav__subitem {{ request()->routeIs('category.*') ? 'active' : '' }}"
                href="{{ route('category.index') }}"
                data-page="category"
            >
                <i class="bi bi-tags"></i>
                <span>Category</span>
            </a>


        </div>



        

    </div>

</nav>

      <!-- FOOTER -->
      <div class="sidebar__footer">
        <div class="user">
          <div class="user__avatar">JP</div>
          <div class="user__meta">
            <div class="user__name">June</div>
            <div class="user__status">
              <span class="dot"></span> Online
            </div>
          </div>
        </div>
      </div>

    </aside>

    <!-- MAIN -->
    <main class="main">

      <!-- TOPBAR -->
      <header class="topbar">
        <div class="topbar__left">
          <button class="btn-icon topbar__burger" id="btnSidebar" aria-label="Toggle Sidebar">☰</button>
          <button class="btn-icon" id="btnCollapse" aria-label="Collapse Sidebar" title="Collapse Sidebar">⫶</button>

          <div class="topbar__links">
            <a href="#" class="topbar__link">Home</a>
            <a href="#" class="topbar__link">Contact</a>
          </div>
        </div>

        <div class="topbar__right">
          <button class="btn-icon" id="themeBtn" type="button" title="Theme">
            <i class="bi bi-palette"></i>
          </button>

          <!-- Notifications -->
          <div class="dd" id="ddNotif">
            <button class="btn-icon dd__btn" type="button" aria-haspopup="true" aria-expanded="false">
              <i class="bi bi-bell"></i>
              <span class="dd__dot">3</span>
            </button>

            <div class="dd__menu" role="menu" aria-label="Notifications">
              <div class="dd__head">Notifications</div>

              <a class="dd__item" href="#">
                <i class="bi bi-info-circle"></i>
                <div>
                  <div class="dd__title">System update</div>
                  <div class="dd__meta">2 mins ago</div>
                </div>
              </a>

              <a class="dd__item" href="#">
                <i class="bi bi-person-plus"></i>
                <div>
                  <div class="dd__title">New user registered</div>
                  <div class="dd__meta">15 mins ago</div>
                </div>
              </a>

              <a class="dd__item" href="#">
                <i class="bi bi-check2-circle"></i>
                <div>
                  <div class="dd__title">Backup complete</div>
                  <div class="dd__meta">1 hour ago</div>
                </div>
              </a>

              <a class="dd__footer" href="#">View all</a>
            </div>
          </div>

          <!-- Profile -->
          <div class="dd" id="ddProfile">
            <button class="btn-icon dd__btn" type="button" aria-haspopup="true" aria-expanded="false">
              <i class="bi bi-person-circle"></i>
            </button>

            <div class="dd__menu" role="menu" aria-label="Profile">
              <div class="dd__head">Account</div>

              <a class="dd__item" href="profile.html">
                <i class="bi bi-person"></i>
                <div class="dd__title">Profile</div>
              </a>

              <a class="dd__item" href="settings.html">
                <i class="bi bi-gear"></i>
                <div class="dd__title">Settings</div>
              </a>

              <a class="dd__item" href="activity-log.html">
                <i class="bi bi-clock-history"></i>
                <div class="dd__title">Activity Logs</div>
              </a>

              <a class="dd__item dd__danger" href="{{route('logout-get')}}">
                <i class="bi bi-box-arrow-right"></i>
                <div class="dd__title">Logout</div>
              </a>
            </div>
          </div>

        </div>
      </header>

      <!-- CONTENT -->
      <section class="content">




        {{$slot}}




     
      </section>

      <footer class="footer">
        <span>© 2026 Admin Template</span>
        <span class="muted">v1.0</span>
      </footer>
    </main>
  </div>

  <div id="themePanel" class="theme-panel">
    <h4>Appearance</h4>

    <button class="theme-option" data-theme="theme-default">🟧 Blue + Orange</button>
    <button class="theme-option" data-theme="theme-blue">🔷 Modern Blue</button>
    <button class="theme-option" data-theme="theme-softblue">🌊 Soft Blue</button>
    <button class="theme-option" data-theme="theme-dark">🌑 Dark Elegant</button>
    <button class="theme-option" data-theme="theme-purple">🟣 Purple-Blue</button>
    <button class="theme-option" data-theme="theme-blueviolet">🔵 Default Blue-Violet</button>
  </div>

  <script src="/js/jquery.js"></script>
  <script src="/js/sweetalert2.min.js"></script>
  <script src="/mistemplates/assets/js/app.js"></script>
  <script src="/mistemplates/assets/js/theme.js"></script>





  <!-- Datatable -->
<script src="/datatable/datatables.min.js" defer></script>

<script src="/datatable/dataTables.buttons.min.js" defer></script>
<script src="/datatable/buttons.html5.min.js" defer></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<script>

   const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });



</script>

   @stack('scripts')

</body>

</html>