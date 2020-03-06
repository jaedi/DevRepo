<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="../public/images/rocket.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Team Rocket</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->


      <!-- Sidebar Menu -->
      <nav class="mt-2 sidebar-dark-primary" style="height:100%;">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" >
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->




          <li class="nav-item" style="height:100px;">
            <a href="{{url('pairing_page')}}" class="nav-link" >
                <i class="nav-icon fas fa fa-heartbeat"></i>
                <p>
                Pairing
                </p>
            </a>
          </li>
{{--
         <li class="nav-item">
            <a href="{{url('subscribers_page')}}" class="nav-link">
              <i class="nav-icon fas fa fa-user"></i>
              <p>
                Subscribers
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('operators_page')}}" class="nav-link">
              <i class="nav-icon fas fa-headphones"></i>
              <p>
                Operators
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('services_page')}}" class="nav-link">
              <i class="nav-icon fas fa-box"></i>
              <p>
                Services
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('personas_page')}}" class="nav-link">
              <i class="nav-icon fas fa fa-comments"></i>
              <p>
                Personas
              </p>
            </a>
          </li> --}}


          <li class="nav-item">
            <a class="nav-link"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
              <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                {{ __('Logout') }}
                </p>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
