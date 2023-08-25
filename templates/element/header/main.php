<?php $polickActive = ($controller == 'PurchaseOrders') ? 'active' : ''; ?>
<?php $prlickActive = ($controller == 'PurchaseRequisitions') ? 'active' : ''; ?>
<?php $dashactive = ($controller == 'Dashboard') ? 'active' : ''; ?>
<?php $intrasactive = ($controller == 'DeliveryDetails') ? 'active' : ''; ?>
<?php $settingactive = ($controller == 'Settings') ? 'active' : ''; ?>
<?php $temvenactive = ($controller == 'VendorTemps') ? 'active' : ''; ?>
<?php $vendorIndex = ($controller == 'VendorTemps' && $action == 'index') ? 'active' : ''; ?>
<?php $createvendactive = ($controller == 'VendorTemps' && $action == 'add') ? 'active' : ''; ?>
<?php $creatsaevendactive = ($controller == 'VendorTemps' && $action == 'sapAdd') ? 'active' : ''; ?>
<?php $rfqactive = ($controller == 'Rfqs') ? 'active' : ''; ?>
<?php $stocksUpload = ($controller == 'StockUploads') ? 'active' : ''; ?>

<?php $temvenmenuopen = ($controller == 'VendorTemps') ? 'menu-open' : ''; ?>
<?php $settingmenuopen = ($controller == 'Settings') ? 'menu-open' : ''; ?>
<?php $temvenactive = ($controller == 'buyervendor-temps') ? 'active' : ''; ?>
<?php $buyvendaddactive = ($controller == 'buyervendor-temps' && $action == 'add') ? 'menu-open' : ''; ?>
<?php $buyvendsaevendactive = ($controller == 'VendorTemps' && $action == 'sapAdd') ? 'menu-open' : ''; ?>
<?php $asnactive = ($controller == 'Asn') ? 'active' : ''; ?>

<?php $settingBuyerActive = ($controller == 'Settings' && $action == 'buyerManagement') ? 'active' : ''; ?>
<?php $settingVendorActive = ($controller == 'Settings' && $action == 'vendorManagement') ? 'active' : ''; 
?>

<nav class="main-header navbar navbar-expand-md navbar-light navbar-white sticky-top">
    <div class="container-fluid">
        <a href="" class="navbar-brand pl-5 ml-4">
            <?= $this->Html->image('apar_logo.png', ['width' => '110', 'class' => 'ml-5 ft-text', 'data-image' => '2']) ?>
        </a>
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Dashboard'), ['controller' => 'dashboard', 'action' => 'index'], ['class' => "nav-link $dashactive", 'escape' => false]) ?>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle <?= $vendorIndex ?><?= $createvendactive ?><?= $creatsaevendactive ?>">Vendor Management</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li>
                            <a href="<?= $this->Url->build('/') ?>buyer/vendor-temps" class="nav-link vendor_material <?= $vendorIndex ?>">
                                <p>Vendors</p>
                              </a>
                        </li>
                        <li>
                            <a href="<?= $this->Url->build('/') ?>buyer/vendor-temps/add" class="nav-link <?= $createvendactive ?>">
                                <p>Add Vendor</p>
                              </a>
                        </li>
                        <li>
                            <a href="<?= $this->Url->build('/') ?>buyer/vendor-temps/sap-add" class="nav-link <?= $creatsaevendactive ?>">
                                <p>SAP Vendor Import</p>
                              </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Purchase Orders'), ['controller' => '/purchase-orders', 'action' => 'view'], ['class' => "nav-link po_acknowledge $polickActive", 'escape' => false]) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Intransit ASN'), ['controller' => 'delivery-details', 'action' => 'index'], ['class' => "nav-link $intrasactive", 'escape' => false]) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Gate Entry'), ['controller' => 'asn', 'action' => 'search'], ['class' => "nav-link $asnactive", 'escape' => false]) ?>
                </li>
                <li class="nav-item ">
                    <?= $this->Html->link(__('Stocks Upload'), ['controller' => '/stock-uploads', 'action' => 'add'], ['class' => "nav-link $stocksUpload", 'escape' => false]) ?>
                </li>
                
                <?= $this->element('header/menu') ?>
            </ul>
        </div>

        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <li class="nav-item dropdown show">
                <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge custom-i">0</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right notification-list" style="left: inherit; right: 0px;cursor: pointer;">
                    <div class="d-flex justify-content-between">
                        <span class="dropdown-header notifyView"> Notifications</span>
                        <span class="dropdown-header  clearNotificationsAll" style="color:#004d87">Clear All</span>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="notification-lists">
                    </div>
                </div>
            </li>
        </ul>

        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <li class="nav-item dropdown show">
                <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                    <div class="user-panel d-flex">
                        <div class="image">
                            <img src="<?= $this->Url->build('/') ?>img/profile.png" class="img-circle elevation-2" alt="User Image" style="box-shadow:none !important;margin-right:15px; ">
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right user-setting" style="left: inherit; right: 10px;">
                    <span class="dropdown-header">
                        <div class="user">
                            <div class="user-info text-left p-2">
                                <h6 class="mb-0 text-info">
                                    <?php echo $this->getRequest()->getSession()->read('first_name'); ?>
                                </h6>
                            </div>
                        </div>
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
        </ul>
    </div>
</nav>


<script>
    $(document).on("click", ".notificationTittle", function (event) {
        var menu_class = $(this).data("class");
        var targetElement = document.querySelector("." + menu_class);
        if (targetElement) { targetElement.click(); }
    });

    $(document).ready(function () {
        $(document).on("click", ".clearNotifications", function (event) {
            event.stopPropagation();
            var dataId = $(this).attr('id');
            $.ajax({
                type: "GET",
                url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'dashboard', 'action' => 'clear-message-count')); ?>",
                data: { id: dataId },
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
                data: { id: ids },
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