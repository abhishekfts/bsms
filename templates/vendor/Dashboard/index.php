<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AdminUser[]|\Cake\Collection\CollectionInterface $adminUsers
 */
?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
<!-- <?= $this->Html->css('cstyle.css') ?> -->
<!-- <?= $this->Html->css('custom') ?> -->
<!-- <?= $this->Html->css('table.css') ?> -->
<!-- <?= $this->Html->css('listing.css') ?> -->
<?= $this->Html->css('v_dashboard_index.css') ?>

<div class="row p-1">

  <!-- <div class="col-sm-12 col-lg-3">
    <div class="card mb-2" style="border-radius:1rem;">
      <div class="card-header p-3 pt-2">
        <div
          class="icon icon-lg icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl position-absolute">
          <i class="material-icons opacity-10">shopping_cart</i>
        </div>
        <div class="text-end pt-1">
          <h2 class="text-sm mb-0 text-capitalize"><b>Purchase Orders</b></h2>
          <h4 class="mb-0">
            <?= $totalPos ?>
          </h4>
        </div>
      </div>

      <hr class="dark horizontal my-0">
      <div class="card-footer p-3">
        <?= $this->Html->link(__('More Info'), ['controller' => 'purchase-orders', 'action' => 'index'], ['class' => 'small-box-footer btn bg-gradient-button', 'escape' => false]) ?>
      </div>
    </div>
  </div> -->

  <!-- <div class="col-sm-12 col-lg-3">
    <div class="card  mb-2" style="border-radius:1rem;">
      <div class="card-header p-3 pt-2">
        <div
          class="icon icon-lg icon-shape bg-gradient-primary shadow-primary shadow text-center border-radius-xl mt-n4 position-absolute">
          <i class="material-icons opacity-10">request_quote</i>
        </div>
        <div class="text-end pt-1">
          <h1 class="text-sm mb-0 text-capitalize"><b>Total RFQ</b></h1>
          <h4 class="mb-0">
            <?= $totalIntransit ?>
          </h4>
        </div>
      </div>

      <hr class="dark horizontal my-0">
      <div class="card-footer p-3">
        <?= $this->Html->link(__('More Info'), '#', ['class' => 'small-box-footer btn bg-gradient-button', 'escape' => false]) ?>
      </div>
    </div>
  </div> -->

  <!-- <div class="col-sm-12 col-lg-3">
    <div class="card  mb-2" style="border-radius:1rem;">
      <div class="card-header p-3 pt-2 bg-transparent">
        <div
          class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl  position-absolute">
          <i class="material-icons opacity-10">local_shipping</i>
        </div>
        <i class="fas fa-truck"></i>
        <div class="text-end pt-1">
          <h1 class="text-sm mb-0 text-capitalize "><b>IN Transit</b>
          </h1>
          <h4 class="mb-0 ">
            <?= $totalIntransit ?>
          </h4>
        </div>
      </div>
      <hr class="horizontal my-0 dark">
      <div class="card-footer p-3">
        <?= $this->Html->link(__('More Info'), ['controller' => 'delivery-details', 'action' => 'index'], ['class' => 'small-box-footer btn bg-gradient-button', 'escape' => false]) ?>
      </div>
    </div>
  </div> -->

  <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3 mb-3">
    <div class="d-box">
      <div class="d-flex justify-content-between text-right">
        <div class="i">
          <i class="fas fa-cart-plus"></i>
        </div>
        <div class="txt">
          <h3>Purchase Order</h3>
          <h5>
            <?= $totalPos ?>
          </h5>
        </div>
      </div>
      <div class="btn-action">
        <?= $this->Html->link(__('More Info'), ['controller' => 'purchase-orders', 'action' => 'index'], ['class' => 'btn bg-gradient-button', 'escape' => false]) ?>
      </div>
    </div>
  </div>

  <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3 mb-3">
    <div class="d-box">
      <div class="d-flex justify-content-between text-right">
        <div class="i">
          <i class="fas fa-truck"></i>
        </div>
        <div class="txt">
          <h3>In Transit</h3>
          <h5>
            <?= $totalIntransit ?>
          </h5>
        </div>
      </div>
      <div class="btn-action">
        <?= $this->Html->link(__('More Info'), ['controller' => 'delivery-details', 'action' => 'index'], ['class' => 'btn bg-gradient-button', 'escape' => false]) ?>
      </div>
    </div>
  </div>
</div>

<div class="row p-1">
  <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-3">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
      <div class="card">
        <div class="card-header camelcaps">
          Stock By Material
        </div>
        <div class="card-body table-responsive">
          <table class="table table-bordered table-hover table-striped">
            <thead>
              <tr>
                <th>Material</th>
                <th>Opening Stock</th>
                <th>Production Stock</th>
                <th>ASN / IN transit</th>
                <th>Closing Stock</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Coarse Aggregate 60mm</td>
                <td>30</td>
                <td>22</td>
                <td>50</td>
                <td>2</td>
              </tr>
              <tr>
                <td>Coarse Aggregate 10mm</td>
                <td>30</td>
                <td>22</td>
                <td>50</td>
                <td>2</td>
              </tr>
              <tr>
                <td>Coarse Aggregate 20mm</td>
                <td>30</td>
                <td>22</td>
                <td>50</td>
                <td>2</td>
              </tr>
              <tr>
                <td>Coarse Aggregate 40mm</td>
                <td>30</td>
                <td>22</td>
                <td>50</td>
                <td>2</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>

  <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-3">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
      <div class="card">
        <div class="card-header camelcaps">
          Stock Intransit
        </div>
        <div class="card-body table-responsive">
          <table class="table table-bordered table-hover table-striped">
            <thead>
              <tr>
                <th>Invoice Date</th>
                <th>Invoice No</th>
                <th>Purchase Order</th>
                <th>ASN No</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>11/07/2023</td>
                <td>234</td>
                <td>4510000421</td>
                <td>4510000421</td>
                <td>Received</td>
              </tr>
              <tr>
                <td>11/07/2023</td>
                <td>234</td>
                <td>4510000421</td>
                <td>4510000421</td>
                <td>Intransit</td>
              </tr>
              <tr>
                <td>11/07/2023</td>
                <td>234</td>
                <td>4510000421</td>
                <td>4510000421</td>
                <td>Created</td>
              </tr>
              <tr>
                <td>11/07/2023</td>
                <td>234</td>
                <td>4510000421</td>
                <td>4510000421</td>
                <td>Received</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>

  <!-- <div class="col-sm-12 col-lg-3">
    <div class="card  mb-2" style="border-radius:1rem;">
      <div class="card-header p-3 pt-2 bg-transparent">
        <div
          class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
          <i class="material-icons opacity-10">monetization_on</i>
        </div>
        <div class="text-end pt-1">
          <h1 class="text-sm mb-0 text-capitalize "><b>Payment Balance</b>
          </h1>
          <h4 class="mb-0 ">
            <?= $this->Html->link(__('250000/-'), ['#'], ['class' => 'small-box-footer', 'escape' => false]) ?>
          </h4>
        </div>
      </div>
      <hr class="horizontal my-0 dark">
      <div class="card-footer p-3">
        <?= $this->Html->link(__('More Info'), '#', ['class' => 'small-box-footer btn bg-gradient-button', 'escape' => false]) ?>
      </div>
    </div>
  </div> -->

</div>

<!-- New RFQs-->
<?php $rfqnewDetails = [];?>
<?php if(count($rfqnewDetails)) : ?>
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-sm-12 col-lg-10">
        <h3 class="mb-0" style="color:navy;"><b>Open RFQs</b></h3>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover" id="newrfqlist"
        style="border-left: .5px solid lightgray;border-right: .5px solid lightgray;border-bottom: .5px solid lightgray;">
        <thead>
          <tr style="background-color: #d3d3d36e;">
            <th>
              <?= h('RFQ No.') ?>
            </th>
            <th>
              <?= h('Category') ?>
            </th>
            <th>
              <?= h('Part Name') ?>
            </th>
            <th>
              <?= h('Make') ?>
            </th>
            <th>
              <?= h('UOM') ?>
            </th>
            <th>
              <?= h('Remarks') ?>
            </th>
            <th>
              <?= h('Date') ?>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rfqnewDetails as $key => $val): 
                    
                    ?>
          <tr redirect="<?= $this->Url->build('/') ?>vendor/dashboard/rfq-view/<?= $val['id'] ?>">
            <td>
              <?= $val['rfq_no'] ?>
            </td>

            <td>
              <?=$val['product']?>
            </td>
            <td>
              <?=$val['part_name']?>
            </td>
            <td>
              <?=$val['make']?>
            </td>
            <td>
              <?=$val['uom']?>
            </td>
            <td>
              <?=$val['remarks']?>
            </td>
            <td>
              <?=$val['added_date']?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php endif; ?>


<!-- Responded RFQs-->
<?php $rfqRequested = array(); ?>
<?php if(count($rfqRequested)) : ?>
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-sm-12 col-lg-10">
        <h4 class="mb-0" style="color:navy;"><b> Submitted RFQs</b></h4>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover" id="respondedrfqlist"
        style="border-left: .5px solid lightgray;border-right: .5px solid lightgray;border-bottom: .5px solid lightgray; padding:0rem">
        <thead>
          <tr style="background-color: #d3d3d36e;">
            <th>
              <?= h('RFQ No.') ?>
            </th>
            <th>
              <?= h('Category') ?>
            </th>
            <th>
              <?= h('Part Name') ?>
            </th>
            <th>
              <?= h('Make') ?>
            </th>
            <th>
              <?= h('UOM') ?>
            </th>
            <th>
              <?= h('Remarks') ?>
            </th>
            <th>
              <?= h('Date') ?>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rfqRequested as $key => $val): 
                    ?>
          <tr redirect="<?= $this->Url->build('/') ?>vendor/dashboard/rfq-view/<?= $val['id'] ?>">
            <td>
              <?= $val['rfq_no'] ?>
            </td>

            <td>
              <?=$val['product']?>
            </td>
            <td>
              <?=$val['part_name']?>
            </td>
            <td>
              <?=$val['make']?>
            </td>
            <td>
              <?=$val['uom']?>
            </td>
            <td>
              <?=$val['remarks']?>
            </td>
            <td>
              <?=$val['added_date']?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php endif; ?>

<?= $this->Html->script('v_dashboard_index') ?>