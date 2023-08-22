<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
<style>
    body,
    h5,
    h6,
    p,
    h4,
    h3,
    label {
        font-family: 'Roboto', sans-serif !important;
    }

    .custom-i {
        background-color: #ffc107 !important;
    }

    .navbar {
        padding: 0rem 0rem
    }

    .brand-link {
        padding: 0.4rem 0.4rem
    }

    .user-panel img {
        width: 1.5rem
    }

    /* aside.main-sidebar:hover {
    width: 210px !important;
} */
    .main-sidebar,
    .main-sidebar::before {
        width: 207px
    }

    .layout-fixed .brand-link {
        width: 207px
    }

    body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .content-wrapper,
    body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-footer,
    body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-header {
        margin-left: 209px
    }

    .user-panel .image {
        padding-left: 0px;
    }

    .badge-warning {
        background-color: #ffc107
    }

    .navbar.card-header h4 {
        /* color: #004d87; */
        text-transform: uppercase;
        font-size: 20px;
        letter-spacing: 0.04rem;
        margin-bottom: 0px;
        margin-top: 0px;
    }

    .navbar-nav .nav-item i.fas.fa-bars {
        line-height: 1.6rem;
    }

    .nav-sidebar .nav-item .nav-link p {
        font-size: 13px;
    }

    .user .thumb {
        margin-right: 10px;
        height: 35px;
        width: 35px;
        border-radius: 50px;
        color: #fff;
        text-align: center;
    }

    .user .thumb img {
        width: 35px;
    }

    .user {
        display: flex;
        align-items: center;
    }

    .user-setting {
        width: auto;
        max-width: 250px;
        min-width: 200px;
    }

    .user-info h6 {
        white-space: initial;
    }
</style>

<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link ftimage" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <?= $this->element('header/menu') ?>
</ul>

<div class="navbar card-header" style="margin-top:0.3vw;border-bottom:none;">
    <h4><b><?= (isset($headTitle)) ? $headTitle : '' ?></b></h4>
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
            <span class="badge badge-warning navbar-badge custom-i">0</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right notification-list" style="left: inherit; right: 0px;cursor: pointer;">
            <div class="d-flex justify-content-between">
                <span class="dropdown-header notifyView"> Notifications</span>
                <span class="dropdown-header clearNotifications">Clear</span>
            </div>

            <div class="dropdown-divider"></div>

            <div class="notification-lists">

            </div>


        </div>
    </li>


    <li class="nav-item dropdown show">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
            <div class="user-panel d-flex">
                <div class="image">
                    <img src="<?= $this->Url->build('/') ?>img/profile.png" class="img-circle elevation-2" alt="User Image" style="box-shadow:none !important;margin-right:15px">


                </div>
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right user-setting" style="left: inherit; right: 10px;">
            <span class="dropdown-header">
                <div class="user"><span class="thumb"><img src="<?= $this->Url->build('/') ?>img/profile.png" class="img-circle" alt=""></span>
                    <div class="user-info text-left">
                        <h6 class="mb-0 text-info">
                            <?php echo $this->getRequest()->getSession()->read('first_name'); ?></h6>
                    </div>
                </div>
                <!-- <p class="unm">Snehal</p>
                <p class="role">Vendor</p> -->
            </span>
            <div class="dropdown-divider"></div>

            <?php if ($role == 2) : ?>
                <a href="<?= $this->Url->build(['controller' => '/admin-users', 'action' => 'view']) ?>" class="dropdown-item">
                    <i class="fas fa-user-cog text-info mr-2"></i>
                    <span>Profile</span>
                </a>
            <?php endif; ?>
            <?php if ($role == 3) : ?>
                <a href="<?= $this->Url->build(['controller' => '/vendor-temps', 'action' => 'view']) ?>" class="dropdown-item">
                    <i class="fas fa-user-cog text-info mr-2"></i>
                    <span>Profile</span>
                </a>
            <?php endif; ?>
            <div class="dropdown-divider"></div>
            <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'users', 'action' => 'logout']) ?>" class="dropdown-item">
                <i class="fas fa-power-off text-danger mr-2"></i>
                <span>Logout</span>
            </a>

        </div>
    </li>




    <!-- <div style="font-size: small; color: darkcyan; padding: 0vw .5vw;">
        <b><?= $full_name ?></b>
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
          <i class="far fa-bell"></i>
          <b class="badge badge-warning navbar-badge">15</b>
          
        </a>
      </div> -->

</ul>


<script>
    $(document).ready(function() {
        $('.clearNotifications').click(function(event) {
            event.stopPropagation();
            $.ajax({
                type: "GET",
                url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'dashboard', 'action' => 'clear-message-count')); ?>",
                dataType: 'json',
                success: function(response) {

                    $('.navbar-badge.custom-i').text('0');
                    $('.notification-list').empty();

                    $('.notification-list').append('<div class="dropdown-item">No Notifications</div>');

                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });

    })
</script>