<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

<?= $this->Html->css('view.css') ?>
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

            <!-- <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope text-info mr-2"></i>Asn Material
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div> -->

        </div>
    </li>
    <!--    
        <li class="nav-item dropdown show">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge custom-i">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right notification-list" style="left: inherit; right: 0px;">
                <span class="dropdown-header">No Notifications</span>
            </div>
        </li> -->

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
  $(document).on("click", ".notificationTittle", function (event) {
        var menu_class = $(this).data("class");
        var targetElement = document.querySelector("." + menu_class);

        if (targetElement) {
            targetElement.click();
        }


    });



    $(document).ready(function () {

        $(document).on("click", ".clearNotifications", function (event) {
            event.stopPropagation();
            var dataId = $(this).attr('id');
            $.ajax({
                type: "GET",
                url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'dashboard', 'action' => 'clear-message-count')); ?>",
                data: {
                    id: dataId
                },
                dataType: 'json',
                beforeSend: function () { $("#gif_loader").show(); },
                success: function (response) {
                    if (response.status === 1) {
                        $('.notificationId[data-id="' + dataId + '"]').remove();

                        var currentCount = parseInt($('.navbar-badge.custom-i').text());
                        var newCount = currentCount - 1;
                        $('.navbar-badge.custom-i').text(newCount);

                        if (newCount === 0) {
                            $('.notification-list').empty();
                            $('.notification-list').append('<div class="dropdown-item">No Notifications</div>');
                        } else {
                            $('.dropdown-header.notifyView').text(newCount + ' Notifications');
                        }
                    }

                },
                error: function (xhr, status, error) {
                    console.log(error);
                },
                complete: function () { $("#gif_loader").hide(); }
            });
        });


        $('.clearNotificationsAll').click(function (event) {

            event.stopPropagation();
            var ids = [];

            $('.notificationId').each(function () {
                var dataId = $(this).data('id');
                ids.push(dataId);
            });

            $.ajax({
                type: "GET",
                url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'dashboard', 'action' => 'clear-message-count')); ?>",
                data: {
                    id: ids
                },
                dataType: 'json',
                beforeSend: function () { $("#gif_loader").show(); },
                success: function (response) {

                    $('.navbar-badge.custom-i').text('0');
                    $('.notification-list').empty();

                    $('.notification-list').append('<div class="dropdown-item">No Notifications</div>');

                },
                error: function (xhr, status, error) {
                    console.log(error);
                },
                complete: function () { $("#gif_loader").hide(); }
            });
        });

    })
</script>