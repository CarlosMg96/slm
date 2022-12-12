  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <!--<li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>-->
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i><img src="https://img.icons8.com/color/30/000000/locked-inside.png"/></i>
          <span class="badge badge-warning navbar-badge"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"><i class="fas fa-user"></i> {{@Auth::user()->name}}</span>
          <div class="dropdown-divider"></div>
          <!--<a href="{{route('config.config_productos')}}" class="dropdown-item dropdown-footer"><i class="fa fa-sign-out"></i> Configuración de Productos (Default)</a>-->
          <div class="dropdown-divider"></div>
          <a href="{{route('admin.auth.logout')}}" class="dropdown-item dropdown-footer"><i class="fa fa-sign-out"></i> Cerrar Sesión</a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->