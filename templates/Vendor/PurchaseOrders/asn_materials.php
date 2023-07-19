<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PoHeader $poHeader
 */
?>
<!-- <?= $this->Html->css('cstyle.css') ?> -->
<!-- <?= $this->Html->css('table.css') ?>
<?= $this->Html->css('listing.css') ?> -->
<?= $this->Html->css('v_index.css') ?>
<link rel="stylesheet"
href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<?= $this->Html->css('custom') ?>
<?= $this->Html->css('v_purchaseorder_asn_material') ?>
<?= $this->Form->create(null, ['url' => '/vendor/purchase-orders/view/' . $poHeader[0]->id, 'type' => 'file', 'id' => 'asnForm']) ?>
<?= $this->form->control('po_header_id', ['label' => false, 'type' => 'hidden', 'value' => $poHeader[0]->id]) ?>
<div class="create-asn">
  <div class="card">
    <div class="card-header p-2">
      <div class="d-flex">
        <div class="col-md-4 align-self-center">
          <div class="d-flex justify-content-between">
            <h6 class="mb-0"><small>PO NO :</small>
              <b>
                <?= h($poHeader[0]->po_no) ?>
              </b>
            </h6>
            <h6 class="mb-0"><small>Vendor Name: </small><b>
                <?php echo $this->getRequest()->getSession()->read('first_name'); ?>
              </b></h6>

          </div>
        </div>
        <div class="col-md-8 d-flex justify-content-end">
          <!-- <h6 class="text-right">Expected Delivery Date <br> <b>May 28, 2022</b></h6> -->
          <a href="/bsms/vendorpurchase-orders/create-asn" id="id_backmodal" class=" back-btn d-block nav-link"><i
              class="fas fa-angle-double-left"></i> BACK</a>
          <button type="button" class="btn btn-custom mb-0 ml-2" id="Create-btn">Create ASN</button>
           <!-- modal -->
           <div class="modal fade" id="modal-confirm" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <h6>Are you sure you want to create asn ?</h6>
                                            </div>
                                            <div class="modal-footer justify-content-between p-1">
                                                <button type="button" class="btn btn-sm btn-link"
                                                    data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success btn-sm mb-0">OK</button>
                                                
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end modal -->
        </div>
      </div>
    </div>
  </div>


  <div class="card">
    <div class="card-header pb-1 pt-2">
      <h5><b>
          <?= __('Invoice Details') ?>
        </b></h5>
    </div>
    <div class="card-body invoice-details p-0">

      <div class="row dgf m-0" style="background-color:#f1f1f1 !important;width:100%">
        <div class="col-sm-8  col-md-2">
          <div class="form-group">

            <?php echo $this->Form->control('invoice_no', array('class' => 'form-control rounded-0', 'div' => 'form-group', 'required')); ?>
          </div>

        </div>
        <div class="col-sm-8 col-md-2">
          <div class="form-group">
            <?php echo $this->Form->control('invoice_date', array('type' => 'date', 'class' => 'form-control rounded-0', 'div' => 'form-group', 'required')); ?>
          </div>
        </div>

        <div class="col-sm-8 col-md-2">
          <div class="form-group">
            <?php echo $this->Form->control('invoice_value', array('id' => 'invoice_value', 'type' => 'number', 'class' => 'form-control rounded-0', 'div' => 'form-group', 'required', 'readonly')); ?>
          </div>
        </div>

        <div class="col-sm-8 col-md-2">
          <div class="form-group">
            <?php echo $this->Form->control('vehicle_no', array('class' => 'form-control rounded-0', 'div' => 'form-group', 'required')); ?>
          </div>
        </div>
        <div class="col-sm-8 col-md-2">
          <div class="form-group">
            <?php echo $this->Form->control('driver_name', array('class' => 'form-control rounded-0', 'div' => 'form-group', 'required')); ?>
          </div>
        </div>

        <div class="col-sm-8 col-md-2">
          <div class="form-group">
            <?php echo $this->Form->control('driver_contact', array('type' => 'mobile', 'class' => 'form-control rounded-0', 'div' => 'form-group', 'required')); ?>
          </div>
        </div>

        <div class="col-sm-8 col-md-2">
          <div class="form-group">
            <?php echo $this->Form->control('transporter_name', array('type' => 'text', 'class' => 'form-control rounded-0', 'div' => 'form-group', 'required')); ?>
          </div>
        </div>


        <div class="col-sm-8 col-md-3">
          <div class="form-group">
            <label for="invoices">Upload Invoice</label>
            <input type="file" name="invoices[]" accept=".pdf" multiple="multiple" class="pt-1 rounded-0"
              style="visibility: hidden;position:absolute;" div="form-group" required="required" id="invoices">
            <button id="OpenImgUpload" type="button" class="d-block btn btn-secondary mb-0 file-upld-btn">Choose
              File</button>

            <p id="files-area">
              <span id="filesList">
                <span id="files-names"></span>
              </span>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header pb-1 pt-2 pl-2">
      <h5><b>
          <?= __('Material List') ?>
        </b></h5>
    </div>
    <div class="card-body p-2">
      <?php if (count($poHeader)) : ?>
      <div class="table-responsive">
        <table class="table table-bordered material-list">
          <thead>
            <tr>
              <th>
                <?= __('Item') ?>
              </th>
              <th>
                <?= __('Material') ?>
              </th>
              <th>
                <?= __('Short Text') ?>
              </th>
              <th>
                <?= __('Pending Qty') ?>
              </th>
              <th>
                <?= __('Base Price') ?>
              </th>
              <th>
                <?= __('Shipping Qty') ?>
              </th>
              <th>
                <?= __('Net Value') ?>
              </th>


            </tr>
          </thead>
          <tbody>
            <?php foreach ($poHeader as $row) : ?>
            <tr>
              <td>
                <?= h($row['PoFooters']['item']) ?>
              </td>
              <td>
                <?= h($row['PoFooters']['material']) ?>
              </td>
              <td>
                <?= h($row['PoFooters']['short_text']) ?>
              </td>
              <td>
                <?= h($row['actual_qty']) ?>&nbsp;
                <?= h($row['PoFooters']['order_unit']) ?>
              </td>
              <td>
                <?= h($row['PoFooters']['net_price']) ?> &nbsp;
                <?= h($row['currency']) ?>
              </td>
              <td style="width:50px;">
                <div class="form-group mb-0">
                  <?= $this->form->control('po_footer_id[]', ['label' => false, 'type' => 'hidden', 'value' => $row['PoFooters']['id']]) ?>
                  <?= $this->form->control('schedule_id[]', ['label' => false, 'type' => 'hidden', 'value' => $row['PoItemSchedules']['id']]) ?>
                  <?= $this->form->control('qty[]', ['label' => false, 'value' => $row['actual_qty'], 'class' => 'form-control check_qty', 'type' => 'number', 'required', 'data-item' => $row['PoFooters']['item'], 'min' => '0', 'max' => $row['actual_qty'],  'div' => 'form-group', 'data-net-price' => $row['PoFooters']['net_price']]) ?>
                </div>
              </td>
              <td class="net_value" id="net_value_<?= h($row['PoFooters']['item']) ?>">
                <?= ($row['PoFooters']['net_price'] * $row['actual_qty']) ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="calcu">
        <table>
          <tbody>
            <tr>
              <td> Sub Total : </td>
              <td><span id="sub_total"> 0 </span></td>
            </tr>
            <tr>
              <td> Total GST(18%) : </td>
              <td><span id="total_gst"> 0 </span></td>
            </tr>
            <tr>
              <td colspan="2">
                <hr class="mt-2 mb-2">
              </td>
            </tr>
            <tr>
              <td> <b>Total Value : </b></td>
              <td><b><span id="total_value"> 0 </span></b></td>
            </tr>
          </tbody>
        </table>
      </div>

      <?php endif; ?>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header border-0 pt-2 pb-2">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <i class="fas fa-question-circle text-warning" style="font-size: 55px;"></i>
          <h5 class="mb-0 pt-2 fw-bold">Are You Sure ?</h5>
          <small>Your data will be lost!</small>
        </div>
        <div class="modal-footer border-0 justify-content-between">
          <button type="button" id="leaveButton" class="btn btn-link text-danger">Leave</button>
          <button type="button" class="btn btn-link text-info" data-dismiss="modal">Stay</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
</div>
<?= $this->form->end() ?>

<script>
  $(document).ready(function () {

    $(document).ready(function ($) {
      $('.check_qty').trigger('keyup');
    });

    // var Toast = Swal.mixin({
    //   toast: true,
    //   position: 'top-end',
    //   showConfirmButton: false,
    //   timer: 3000
    // });


    const dt = new DataTransfer();

    $('#invoices').on('change', function (event) {
      var files = event.target.files;
      for (var i = 0; i < this.files.length; i++) {
        let fileBloc = $('<span/>', {
          class: 'file-block'
        }),
          fileName = $('<span/>', {
            class: 'name',
            text: this.files.item(i).name
          });
        $("#filesList > #files-names").append(fileBloc);
        fileBloc.append('<span class="file-delete"><span><i class="fas fa-times-circle text-danger"></i></span></span>')
          .append(fileName);

      };
      for (let file of this.files) {
        dt.items.add(file);
      }
      this.files = dt.files;

      $('span.file-delete').click(function () {
        let name = $(this).next('span.name').text();
        $(this).parent().remove();
        for (let i = 0; i < dt.items.length; i++) {
          if (name === dt.items[i].getAsFile().name) {
            dt.items.remove(i);
            // console.log(dt.files);
            continue;
          }
        }
        document.getElementById('invoices').files = dt.files;

      });

    });

    // file upload button
    $('#OpenImgUpload').click(function () {
      $('#invoices').trigger('click');

    });


    $(document).on('keyup', '.check_qty', function () {
      var id = $(this).attr('data-item');
      var netPrice = $(this).attr('data-net-price');

      $("#net_value_" + id).html($(this).val() * netPrice);

      var subTotal = 0;
      $('.net_value').each(function (i, obj) {
        var tmp = 0
        if ($(obj).html() == NaN) {
          tmp = 0;
        } else {
          tmp = $(obj).html();
        }
        subTotal = (subTotal + parseFloat(tmp));
        console.log(subTotal);
      });

      gst = subTotal * 18 / 100;
      $("#sub_total").html(subTotal);
      $("#total_gst").html(gst);
      $("#total_value").html(subTotal + gst);
      $('#invoice_value').val(subTotal + gst)
    });


    $("#asnForm").validate({
      rules: {
        vehicle_no: {
          required: true
        },
        driver_name: {
          required: true,
        },
        driver_contact: {
          required: true,
          number: true,
          maxlength: 10
        },
        invoices: {
          required: true
        },
        "qty[]": {
          required: true,
          number: true,
          //maxlength: 5,
          checkQty: true
        },
      },
      messages: {
        vehicle_no: {
          required: "Please enter a vehicle no"
        },
        driver_name: {
          required: "Please enter a driver name"
        },
        driver_contact: {
          required: "Please enter a driver contact",
          number: "Please enter number only"
        },
        invoices: {
          required: "Please upload file"
        },
        "qty[]": {
          required: "Please enter a quantity",
          number: "Please enter a valid number",
          //maxlength: "Maximum length exceeded",
          checkQty: "Current value is less than actual_qty"
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
      submitHandler: function (form, event) {
        event.preventDefault();
        // $('#asnForm')[0].submit();
        $('#modal-confirm').modal('show');
        return false;
      }
    });

    $("#Create-btn").click(function () {
  if ($("#asnForm").valid()) { // Check form validation
    $('#modal-confirm').modal('show'); // Show the modal
  }
});
// 
$('#modal-confirm').on('click', '.btn-success', function () {
  if ($("#asnForm").valid()) { // Check form validation again before submitting
    $('#modal-confirm').modal('hide'); // Hide the modal
    $('#asnForm')[0].submit(); // Submit the form
  }
});
    $.validator.addMethod('checkQty', function (value, element) {
      if (parseInt(value) == 0) {
        return false;
      }

      if (parseInt(value) > parseInt($(element).attr('data-check'))) {
        return false;
      }
      return true;
    }, 'message');

    $('.row').attr('style', 'width:110vw;');


    $(document).on("click", ".flu", function () {
      if ($(this).data('alt') == '+') {
        $(this).data('alt', '-');
        $(this).empty();
        $(this).append('Remove');
      } else {
        $(this).data('alt', '+');
        $(this).empty();
        $(this).append('add');
      }
    });



  });
  // for page leave popup
  $(document).ready(function() {
    var previousUrl = null;
  $('.nav-link').click(function() {
    previousUrl = $(this).attr('href');
    $("#modal-default").modal('show');
    $("#leaveButton").click(function() {
      if (previousUrl) {
        window.location.href = previousUrl;
      }
    });
        return false; // cancel the event
    });
  });
</script>