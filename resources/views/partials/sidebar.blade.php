<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        {{-- <img src="{{ asset('assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
       
        <span class="brand-text font-weight-light ml-4">IT Invoice</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ auth()->user()->foto? asset('storage/'.auth()->user()->foto) :asset('assets/dist/img/avatar5.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{ route('users.edit', ['id'=>auth()->user()->id]) }}" class="d-block">{{ auth()->user()->firstname? auth()->user()->firstname.' '.auth()->user()->lastname : 'User'}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ $isDashboard ?? ''}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('project') }}" class="nav-link {{ $isProject ?? ''}}">
              <i class="nav-icon fas fa-server"></i>
              <p>
                Project
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('invoice') }}" class="nav-link {{ $isInvoice ?? ''}}">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Invoice
              </p>
            </a>
          </li>
          @can('admin')
          <li class="nav-item">
            <a href="{{ route('users') }}" class="nav-link {{ $isUsers ?? ''}}">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Users
              </p>
            </a>
          </li>
          @endcan
          <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>