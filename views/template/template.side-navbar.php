<nav class="navbar navbar-vertical navbar-vertical-sm fixed-left navbar-expand-md navbar-light d-none d-md-block" id="sidebar">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="sidebarCollapse">

      <!-- Navigation -->
      <ul class="navbar-nav d-none d-md-block">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Home">
          <a class="nav-link<?php echo ($CurrentPage === 'home') ? ' active' : ''; ?>" href="<?php echo $handle->path('home'); ?>" data-ajax>
            <i class="bi bi-plus-circle sz-24 my-2"></i>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Pages">
          <a class="nav-link<?php echo ($CurrentPage === 'pages') ? ' active' : ''; ?>" href="<?php echo $handle->path('pages'); ?>" data-ajax>
            <i class="bi bi-file-ppt sz-24 my-2"></i>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Analytics">
          <a class="nav-link<?php echo ($CurrentPage === 'analytics') ? ' active' : ''; ?>" href="<?php echo $handle->path('analytics'); ?>" data-ajax="">
            <i class="bi bi-bar-chart sz-24 my-2"></i>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Settings">
          <a class="nav-link<?php echo ($CurrentPage === 'settings') ? ' active' : ''; ?> " href="<?php echo $handle->path('settings'); ?>" data-ajax>
            <i class="bi bi-gear-wide-connected sz-24 my-2"></i>
          </a>
        </li>
        <li class="nav-item d-md-none">
          <a class="nav-link" href="#sidebarModalActivity" data-toggle="modal">
            <i class="bi bi-bell sz-24 my-2"></i>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Switch dark mode">
          <a class="nav-link toggle_dark" href="javascript:void(0);">
            <i class="bi bi-lightbulb-off sz-24 my-2"></i>
          </a>
        </li>

      </ul>
      <!-- Push content down -->
      <div class="mt-auto"></div>
      <div class="navbar-user">
        <div class="dropright">

          <!-- Toggle -->
          <a href="#" class="avatar avatar-sm avatar-online dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo $User->Details($User->AuthID())["user_name"]; ?>">
            <img src="<?php
                      echo $handle->path($User->photos($User->Details($User->AuthID())));
                      ?>" class="avatar-img rounded-circle" />
          </a>
          <!-- Menu -->
          <div class="dropdown-menu" aria-labelledby="user">
            <a href="<?php echo $handle->path('settings'); ?>" class="dropdown-item">Settings</a>
            <hr class="dropdown-divider">
            <a href="<?php echo $handle->path('logout'); ?>" class="dropdown-item">Logout</a>
          </div>

        </div>
      </div>

    </div> <!-- / .navbar-collapse -->

  </div>
</nav>