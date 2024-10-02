<!doctype html>
<html lang="en">

<head>
  <title>@yield('title', 'Sidebar')</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Custom Styles -->
  <link rel="stylesheet" href="{{ asset('css/staff/style.css') }}">

  @yield('head') <!-- For additional styles or scripts -->
</head>

<body>
  <div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar">
      <div class="custom-menu">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
          <i class="fa fa-bars"></i>
          <span class="sr-only">Toggle Menu</span>
        </button>
      </div>
      <div class="p-4">
        <img id="lib" src="{{asset('assets/imgs/LIBRARY LOGO.png')}}" alt="" style="height: 150px; display: flex;">
        <ul class="list-unstyled components mb-5">
          <li class="{{ request()->routeIs('add-student') ? 'active' : '' }}">
            <a href="{{ route('add-student') }}"><span class="fa fa-user-plus mr-3"></span> Add Student</a>
          </li>
          <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}"><span class="fa fa-chart-area mr-3"></span> Dashboard</a>
          </li>
          <li class="{{ request()->routeIs('staff.students.tables') ? 'active' : '' }}">
            <a href="{{ route('staff.students.tables') }}"><span class="fa-solid fa-table mr-3"></span> Students Table</a>
          </li>
          <li class="{{ request()->routeIs('staff.archives.table') ? 'active' : '' }}">
            <a href="{{ route('staff.archives.table') }}"><span class="fa fa-sticky-note mr-3"></span> Archives</a>
          </li>
          <li>
            <a href="#"><span class="fa fa-suitcase mr-3"></span> Gallery</a>
          </li>
          <li>
            <a href="#"><span class="fa fa-cogs mr-3"></span> Services</a>
          </li>

          <br><br>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>

          <button class="btn btn-danger" style="width:150px; height:30px; font-size:12px;" onclick="confirmLogout()">Logout</button>

          <script>
            function confirmLogout() {
              if (confirm('Are you sure you want to log out?')) {
                document.getElementById('logout-form').submit();
              }
            }
          </script>

        </ul>

        <div class="footer">
          <p>
            Copyright &copy; <script>
              document.write(new Date().getFullYear());
            </script>
            All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i>
            by <a href="https://colorlib.com" target="_blank">Colorlib.com</a>
          </p>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div id="content" class="p-4 p-md-5 pt-5">
      @yield('contentDashboard')
      @yield('contentAddStudent')
      @yield('contentStudentsTable')
      @yield('contentEditStudent')
      @yield('contentArchivesTable')
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('js/staff/jquery.min.js') }}"></script>
  <script src="{{ asset('js/staff/popper.js') }}"></script>
  <script src="{{ asset('js/staff/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/staff/main.js') }}"></script>

  @yield('scripts') <!-- Additional scripts -->
</body>

</html>