<aside class="app-sidebar" id="sidebar">
  <div class="sidebar-header">
    <a class="sidebar-brand" href="<?php echo base_url($this->lang->lang().'/Back_dashboard/'); ?>"><img width="100" src="<?php echo base_url('assets/img/logos/logo-maker.png'); ?>"  alt="JVBW" title="Inicio"></a>
    <button type="button" class="sidebar-toggle">
      <i class="icon fa fa-times"></i>
    </button>
  </div>
  <div class="sidebar-menu">
    <ul class="sidebar-nav">
      <li class="<?php if($this->router->fetch_class() === 'Back_dashboard') { echo 'active'; } ?>">
        <a href="<?php echo base_url($this->lang->lang().'/Back_dashboard/'); ?>">
          <div class="icon">
            <i class="icon fa fa-tasks" aria-hidden="true"></i>
          </div>
          <div class="title">Dashboard</div>
        </a>
      </li>
     
      <li class="<?php if($this->router->fetch_method() === 'noticias') { echo 'active'; } ?>">
        <a href="<?php echo base_url($this->lang->lang().'/Back_crud/noticias'); ?>">
          <div class="icon">
            <i class="icon fa fa-newspaper-o" aria-hidden="true"></i>
          </div>
          <div class="title">Noticies</div>
        </a>
      </li>

      <li class="<?php if($this->router->fetch_method() === 'categorias') { echo 'active'; } ?>">
        <a href="<?php echo base_url($this->lang->lang().'/Back_crud/categorias'); ?>">
          <div class="icon">
            <i class="icon fa fa-tag" aria-hidden="true"></i>
          </div>
          <div class="title">Categories Noticies</div>
        </a>
      </li>

      <li class="<?php if($this->router->fetch_method() === 'perfiles') { echo 'active'; } ?>">
        <a href="<?php echo base_url($this->lang->lang().'/Back_crud/perfiles'); ?>">
          <div class="icon">
            <i class="icon fa fa-users" aria-hidden="true"></i>
          </div>
          <div class="title">Perfils</div>
        </a>
      </li>
     
      <li class="<?php if($this->router->fetch_method() === 'usuarios') { echo 'active'; } ?>">
        <a href="<?php echo base_url($this->lang->lang().'/Back_crud/usuarios'); ?>">
          <div class="icon">
            <i class="icon fa fa-user-plus" aria-hidden="true"></i>
          </div>
          <div class="title">Usuaris</div>
        </a>
      </li>

      <li class="<?php if($this->router->fetch_method() === 'equipos') { echo 'active'; } ?>">
        <a href="<?php echo base_url($this->lang->lang().'/Back_crud/equipos'); ?>">
          <div class="icon">
            <i class="icon fa fa-star" aria-hidden="true"></i>
          </div>
          <div class="title">Equips</div>
        </a>
      </li>

      <li class="<?php if($this->router->fetch_method() === 'eventos') { echo 'active'; } ?>">
        <a href="<?php echo base_url($this->lang->lang().'/Back_crud/eventos'); ?>">
          <div class="icon">
            <i class="icon fa fa-calendar" aria-hidden="true"></i>
          </div>
          <div class="title">Esdeveniments</div>
        </a>
      </li>

      <li class="<?php if($this->router->fetch_method() === 'retos') { echo 'active'; } ?>">
        <a href="<?php echo base_url($this->lang->lang().'/Back_crud/retos'); ?>">
          <div class="icon">
            <i class="icon fa fa-university" aria-hidden="true"></i>
          </div>
          <div class="title">Reptes</div>
        </a>
      </li>
      
      <li class="<?php if($this->router->fetch_method() === 'paises') { echo 'active'; } ?>">
        <a href="<?php echo base_url($this->lang->lang().'/Back_crud/paises'); ?>">
          <div class="icon">
            <i class="icon fa fa-universal-access" aria-hidden="true"></i>
          </div>
          <div class="title">Països</div>
        </a>
      </li>

      <li class="<?php if($this->router->fetch_method() === 'contact') { echo 'active'; } ?>">
        <a href="<?php echo base_url($this->lang->lang().'/Back_crud/contact'); ?>">
          <div class="icon">
            <i class="icon fa fa-sticky-note" aria-hidden="true"></i>
          </div>
          <div class="title">Contacte</div>
        </a>
      </li>

      <li class="<?php if($this->router->fetch_method() === 'paginas') { echo 'active'; } ?>">
        <a href="<?php echo base_url($this->lang->lang().'/Back_crud/paginas'); ?>">
          <div class="icon">
            <i class="icon fa fa-file-text" aria-hidden="true"></i>
          </div>
          <div class="title">Pàgines</div>
        </a>
      </li>

      <li class="<?php if($this->router->fetch_method() === 'metaseo') { echo 'active'; } ?>">
        <a href="<?php echo base_url($this->lang->lang().'/Back_crud/metaseo'); ?>">
          <div class="icon">
            <i class="icon fa fa-search" aria-hidden="true"></i>
          </div>
          <div class="title">SEO</div>
        </a>
      </li>

      <li class="<?php if($this->router->fetch_method() === 'media') { echo 'active'; } ?>">
        <a href="<?php echo base_url(); echo $this->lang->lang() . '/Back_crud/media/';?>">
          <div class="icon">
            <i class="icon fa fa-picture-o fa-4x"></i>
          </div>
          <div class="title">Media</div>
        </a>
      </li>
      
      <li class="<?php if($this->router->fetch_method() === 'settings') { echo 'active'; } ?>">
        <a href="<?php echo base_url($this->lang->lang().'/Back_crud/settings'); ?>">
          <div class="icon">
            <i class="icon fa fa-cog" aria-hidden="true"></i>
          </div>
          <div class="title">Settings</div>
        </a>
      </li>
      
    </ul>
  </div>

</aside>