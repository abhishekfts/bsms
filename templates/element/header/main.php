<style>
  .navbar{
    padding:0rem 0rem
  }
  .brand-link{
    padding:0.4rem 0.4rem
  }
  .user-panel img{
    width:1.5rem
  }
  .main-sidebar, .main-sidebar::before{
    width:207px
    
  }
  .layout-fixed .brand-link{
    width:207px
  }
  body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .content-wrapper, body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-footer, body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-header{
    margin-left:209px
    
  }
  .user-panel .image{
    margin-top:6px
  }
  .badge-warning{
    background-color:#ffc107
  }
 
  </style>

<ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link ftimage" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
  </li>
  <?= $this->element('header/menu') ?>
</ul>

<div class="navbar" style="margin-left: 0vw;margin-top:0.3vw;font-size:30px">
<h4>Dashboard</h4>
  <!-- <b>
    <img src="<?= $this->Url->build('/') ?>img/rect_logo.png" alt="vekpro" style="width: 8vw;">
  </b> -->
  <!-- </span> - &nbsp; <b>Vendor Customer Procurement</b> -->
</div>

<ul class="navbar-nav ml-auto">
  <li class="nav-item">
    <!-- <a class="nav-link" data-widget="fullscreen" href="#" role="button">
      <i class="fas fa-expand-arrows-alt"></i>
    </a> -->
  </li>
 
  <li class="nav-item dropdown show">
          <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
            <span class="dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li>

      <div class="user-panel d-flex">
      <div class="image">
        <img src="<?= $this->Url->build('/') ?>img/profile.png" class="img-circle elevation-2" alt="User Image" style="box-shadow:none !important;margin-right:15px">
        
      
      </div>
      
      
      <div style="font-size: small; color: darkcyan; padding: 0vw .5vw; display:none;">
        <b><?=$full_name?></b>
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
          <i class="far fa-bell"></i>
          <b class="badge badge-warning navbar-badge">15</b>
          
        </a>
      </div>
    </div>
  </li>
</ul>