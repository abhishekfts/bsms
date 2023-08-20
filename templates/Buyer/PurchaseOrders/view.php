<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PoHeader $poHeader
 * @var \App\Model\Entity\PoHeader $poHeader
 */
?>
<!-- <?= $this->Html->css('cstyle.css') ?> -->
<?= $this->Html->css('custom') ?>
<?= $this->Html->css('table.css') ?>
<?= $this->Html->css('custom_table.css') ?>
<!-- <?= $this->Html->css('listing.css') ?> -->
<!-- <?= $this->Html->css('b_index.css') ?> -->
<?= $this->Html->css('b_purchase_order_view.css') ?> 
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />


<div class="row purchase-order">
  <div class="col-12">
    <div class="poHeaders view content card" id="">
      <div class="table-responsive p-2" id="purViewId">
        <div class="search-bar mb-2">
          <input type="search" placeholder="Search all orders, meterials" class="form-control search-box">
        </div>
        <div class="po-list">
          <div class="d-flex" id="poItemss"></div>
        </div>
      </div>
    </div>

    <div class="related card">
      <div class="card-header">
        <span id="res_message"></span>
        <button type="button" disabled class="btn bg-gradient-button" id="action_schedule" onclick="prepare()" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#scheduleModal">Schedule</button>
      </div>
      <div class="table-responsive card-body" id="id_potableresp" style="display:none;"></div>
    </div>
  </div>
</div>

<!-- <?php foreach ($poHeader->po_footers as $poFooters) :
        $actualQty = $poFooters->po_qty;
        $totalQty = 0;
      ?> -->
<!-- delivery modal -->
<div class="modal fade" id="item_<?= h($poFooters->item) ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">

    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title"><b>Delivery Detail :</b>
          <?= h($poHeader->po_no . ' - ' . $poFooters->item) ?>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table" id="example2">
          <thead>
            <tr>
              <th>
                <?= __('Item') ?>
              </th>
              <th>
                <?= __('Short Text') ?>
              </th>
              <th>
                <?= __('Challan No.') ?>
              </th>
              <th>
                <?= __('Qty') ?>
              </th>
              <th>
                <?= __('Eway Bill No.') ?>
              </th>
              <th>
                <?= __('Einvoice No') ?>
              </th>
              <th class="actions">
                <?= __('Actions') ?>
              </th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($poFooters->delivery_details as $delivery) :
              $totalQty = $totalQty + $delivery->qty;
            ?>
              <tr>
                <td>
                  <?= h($poFooters->item) ?>
                </td>
                <td>
                  <?= h($poFooters->short_text) ?>
                </td>
                <td>
                  <?= h($delivery->challan_no) ?>
                </td>
                <td>
                  <?= h($delivery->qty) ?>
                </td>
                <td>
                  <?= h($delivery->eway_bill_no) ?>
                </td>
                <td>
                  <?= h($delivery->einvoice_no) ?>
                </td>
                <td class="actions">
                  <!-- <?= $this->Html->link(__('View'), ['controller' => 'PoFooters', 'action' => 'view', $poFooters->id]) ?> -->
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <b>Actual Qty :</b>
        <?php echo $actualQty ?>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        <b>Delivered Qty :</b>
        <?php echo $totalQty ?>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>

<!-- Modal stock -->
<div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="scheduleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <?= $this->Form->create(null, ['id' => 'scheduleForm', 'class' => 'mb-0',  'url' => ['controller' => 'po-footers', 'action' => 'create-schedule']]) ?>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Schedule</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="alert-body text-center d-none">
          <h6>Are you sure you want to create schedule ?</h6>
        </div>
        <div class="a-data">
          <table class="table table-bordered table-hover table-striped">
            <thead>
              <tr>
                <th>PO</th>
                <th>Item</th>
                <th>Actual Qty</th>
                <th>Delivery Date</th>
              </tr>
            </thead>
            <tbody id="id_scheduletbl"></tbody>
          </table>
        </div>
        <div id="error_msg" class="text-danger"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary dismiss-btn" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-secondary d-none" id="btnClose">Close</button>
        <button type="button" class="btn btn-custom btnSub">Submit</button>
        <button type="submit" class="btn btn-success btn-sm d-none">Ok</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal update schedule -->
<div class="modal fade" id="modal-sm" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <?= $this->Form->create(null, ['id' => 'scheduleUpdate']) ?>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Schedule</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <!-- <div class="alert-body text-center d-none">
          <h6>Are you sure you want to create schedule ?</h6>
        </div> -->
        <div class="a-data">
          <table class="table table-bordered table-hover table-striped">
            <thead>
              <tr>
                <th>PO</th>
                <th>Item</th>
                <th>Actual Qty</th>
                <th>Delivery Date</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td id="schedule_po"></td>
                <td id="schedule_item"></td>
                <td id="schedule_actual_qty"></td>
                <td><input type="date" class="form-control" name="delivery_date" id="delivery_dates"></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div id="error_msg" class="text-danger"></div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-custom schedule_button">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal stock -->
<div class="modal fade" id="notifyModal" tabindex="-1" role="dialog" aria-labelledby="notifyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">
      <div class="overlay">
        <i class="fas fa-2x fa-sync fa-spin"></i>
      </div>

      <?= $this->Form->create(null, ['id' => 'notifyForm',  'url' => ['controller' => 'purchase-orders', 'action' => 'save-schedule-remarks']]) ?>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Communication</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <div id="past_messages"></div>
        <?php
        echo $this->Form->control('schedule_id', ['type' => 'hidden', 'id' => 'schedule_id']);
        echo $this->Form->control('message', ['type' => 'textarea', 'class' => 'form-control rounded-0']);
        //echo $this->Form->control('message', [ 'type' => 'textarea','class' => 'summernote form-control rounded-0','div' => 'form-group', 'required', 'data-msg'=>"Please write something"]);
        ?>
      </div>
      <div id="error_msg"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="padding: 9px 15px;">Close</button>
        <button type="submit" class="btn btn-custom-2">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- modal cancel  -->
<div class="modal fade" id="modal-cancel" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cancel Schedule</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <div class="text-center">
          <h6>Are you sure you want to cancel schedule ?</h6>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success schedule_cancel_ok btn-sm">Ok</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="container" style="display:none;">
  <table cellpadding="0" cellspacing="0" border="0" class="dataTable table table-bordered table-hover table-striped" id="example2">
    <thead>
      <tr>
        <th>L3Type</th>
        <th>L3Variation</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>A</td>
        <td>5</td>
      </tr>
      <tr>
        <td>B</td>
        <td>4</td>
      </tr>
    </tbody>
  </table>
</div>

<script>
  var get_po_Footers = "<?php echo \Cake\Routing\Router::url(array('controller' => '/purchase-orders', 'action' => 'get-po-Footers')); ?>/";
  var create_schedule = "<?php echo \Cake\Routing\Router::url(array('controller' => '/purchase-orders', 'action' => 'create-schedule')); ?>";
  var get_schedules = "<?php echo \Cake\Routing\Router::url(array('controller' => '/purchase-orders', 'action' => 'get-schedulelist')); ?>/";
  var get_schedule_messages = "<?php echo \Cake\Routing\Router::url(array('controller' => '/purchase-orders', 'action' => 'get-schedule-messages')); ?> /";
  var create_schedule_update = "<?php echo \Cake\Routing\Router::url(array('controller' => '/purchase-orders', 'action' => 'create-schedule-update')); ?>/";
  var create_schedule_cancel = "<?php echo \Cake\Routing\Router::url(array('controller' => '/purchase-orders', 'action' => 'update')); ?>/";
  var po_api = "<?php echo \Cake\Routing\Router::url(array('controller' => '/purchase-orders', 'action' => 'po-api')); ?>";
  var save_schedule_remarks = "<?php echo \Cake\Routing\Router::url(array('controller' => 'purchase-orders', 'action' => 'save-schedule-remarks')); ?>";
</script>
<?= $this->Html->script('b_purchaseorder_view') ?>