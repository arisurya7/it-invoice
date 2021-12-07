<!DOCTYPE html>
<html lang="en">
<head>
  @include('partials.head')
  @yield('style')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  @include('partials.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('partials.sidebar')

  <!-- Content Wrapper. Contains page content -->
  @yield('content')
  
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  @include('partials.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
@include('partials.script')
@yield('script')
</body>
</html>