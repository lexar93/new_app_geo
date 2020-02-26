<div class="app-container">
  <nav class="navbar navbar-default" id="navbar">
  <div class="container-fluid">
    <div class="navbar-collapse collapse in">
      <ul class="nav navbar-nav navbar-mobile">
        <li>
          <button type="button" class="sidebar-toggle">
            <i class="fa fa-bars"></i>
          </button>
        </li>
        <li class="logo">
          <a class="navbar-brand" href="<?php echo base_url($this->lang->lang().'/Back_dashboard/'); ?>"><span class="highlight"></span></a>
        </li>
        <li>
          <button type="button" class="navbar-toggle">
             <img class="profile-img" width="175" height="75" src="<?php echo base_url('assets/img/logos/logo-maker.png'); ?>">
          </button>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-left">
        <li class="navbar-title">Administració</li>        
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown profile">
          <a href="#" class="dropdown-toggle"  data-toggle="dropdown">
            <img height="50" src="<?php echo base_url('assets/img/logos/logo-maker.png'); ?>">
            <div class="title">Perfil</div>
          </a>
          <div class="dropdown-menu">
            <div class="profile-info">
              <h4 class="username">Administrador</h4>
            </div>
            <ul class="action">
              <li>
                <a style="cursor:pointer;" onclick="logout();">Sortir</a>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>



