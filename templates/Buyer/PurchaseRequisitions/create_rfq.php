<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PoHeader $poHeader
 */
?>
<?= $this->Html->css('cstyle.css') ?>
<?= $this->Html->css('custom') ?>
<?= $this->Html->css('table.css') ?>
<?= $this->Html->css('listing.css') ?>
<?= $this->Html->css('b_index.css') ?>
<link rel="stylesheet"
  href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

  <?= $this->Html->css('CakeLte./AdminLTE//plugins/summernote/summernote-bs4.min.css') ?>
  

<div class="row">
<?= $this->Form->create(null, ['id' => 'rfqForm']) ?>
<?= $this->Form->control('pr_header_id', array('type' => 'hidden', 'id' => 'pr_header_id', 'value' => $prHeader->id)); ?>
  <div class="col-12">
    <div class="poHeaders view content card">
      <div class="card-header">
        <h5><b>
          <?= "Purchase Requisition : " . h($prHeader->pr_no) ?>
</b></h5>
      </div>
    </div>

    <div class="related card">
      <div class="card-header">
        <h5><b>
          <?= __('Material List') ?>
</b></h5>
      </div>
      <div class="card-body">
        <?php if (!empty($prHeader->pr_footers)) : ?>
        <div class="table-responsive">
          <table class="table" id="example1">
            <thead>
              <tr>
              <td>
                &nbsp;
              </td>
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
                  <?= __('Qty') ?>
                </th>
                
                <th>
                  <?= __('Delivery Date') ?>
                </th>
                
              </tr>
            </thead>
            <tbody>
              <?php foreach ($prHeader->pr_footers as $key => $prFooters) : ?>
              <tr>
                <th>
                    <?php echo $this->Form->control("item.$key",['label' => false, 'type' => 'checkbox', 'checked' => 'checked', 'data-id' => $prFooters->item, 'value' => $prFooters->id]); ?>
                </th>
                <td>
                  <?= h($prFooters->item) ?>
                </td>
                <td>
                  <?= h($prFooters->material) ?>
                </td>
                <td>
                  <?= h($prFooters->short_text) ?>
                </td>
                <td>
                  <?= h($prFooters->qty) ?>
                </td>
                <td>
                  <?= h($prFooters->delivery_date) ?>
                </td>
                
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="related card">
      <!-- <div class="card-header">
        
      </div> -->
      <div class="card-body rfq-editor">
        <?php if (!empty($vendors)) : ?>
        <div class="table-responsive ">
        <?php 
          echo $this->Form->control('search_supplier', ['label' => 'Search Supplier', 'class' => 'search_supplier form-control']);
        //echo $this->Form->control("Suppliers", ['label' => false, 'class' => 'form-control', 'id' => 'suppliers', 'options' => $vendors, 'empty' => 'Select', 'multiple' => true, 'required' => true]); ?>
        </div>

          <table id="selected_supplier_table"> </table>

        <?php echo $this->Form->control('Comments', [ 'type' => 'textarea','class' => 'summernote form-control rounded-0','div' => 'form-group', 'required', 'data-msg'=>"Please write something"]); ?>

        <?php endif; ?>
        <button label="Login"
                            class="button btn-custom button-rounded button-reveal button-large button-yellow button-light text-end"
                            type="submit" style="float:right;">
                            <i class="icon-line-save"></i>
                            <span>SAVE RFQ</span>
                        </button>
      </div>
    </div>
  </div>
  <?= $this->Form->end() ?>
</div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<?= $this->Html->script('CakeLte./AdminLTE/plugins/summernote/summernote-bs4.min.js') ?>

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>
  $(document).ready(function () {

    var selectedSuppliers = [];
    // var Toast = Swal.mixin({
    //   toast: true,
    //   position: 'top-end',
    //   showConfirmButton: false,
    //   timer: 3000
    // });

    /*$(".search_supplier").on('keyup', function (e) {
      if (e.key === 'Enter' || e.keyCode === 13) {
        // Do something
        alert('test');
      }
    }); */

    $( ".search_supplier" ).autocomplete({
      source: "<?php echo \Cake\Routing\Router::url(array('controller' => '/vendor-temps', 'action' => 'get-list')); ?>/" + $(".search_supplier").val(),

      minLength: 2,
      select: function( event, ui ) {
        if ($.inArray(ui.item.id, selectedSuppliers) < 0) {
          selectedSuppliers.push(ui.item.id);
          $("#selected_supplier_table").append("<tr id='supplier_"+ui.item.id+"'><td>"+ui.item.value+
          "<input type='hidden' name='Suppliers[]' value='"+ui.item.id+"'></td><td><ion-icon name='trash' class='delete_supplier' data-id='"+ui.item.id+"'></ion-icon></a></td></tr>");
        }
        
        $(this).val("");
        return false;
      }
    } );

    $(document).on('click', '.delete_supplier', function(){
        var id = $(this).attr('data-id');
        deleteSupplier(id);
    });

    function deleteSupplier(removeItem) {
      $("#supplier_"+removeItem).remove();
      selectedSuppliers = jQuery.grep(selectedSuppliers, function(value) {
        return value != removeItem;
      });
    }


    var summernoteForm = $('.form-validate-summernote');
    var summernoteElement = $('.summernote');

    var summernoteValidator = summernoteForm.validate({
        errorElement: "div",
        errorClass: 'is-invalid',
        validClass: 'is-valid',
        ignore: ':hidden:not(.summernote),.note-editable.card-block',
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("invalid-feedback");
            console.log(element);
            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.siblings("label"));
            } else if (element.hasClass("summernote")) {
                error.insertAfter(element.siblings(".note-editor"));
            } else {
                error.insertAfter(element);
            }
        }
    });

    summernoteElement.summernote({
        height: 150,
        callbacks: {
            onChange: function (contents, $editable) {
                summernoteElement.val(summernoteElement.summernote('isEmpty') ? "" : contents);
                summernoteValidator.element(summernoteElement);
            }
        }
    });

    
    $.validator.setDefaults({
      submitHandler: function () {
        var formdatas = new FormData($('#rfqForm')[0]);
        $.ajax({
          type: "POST",
          url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'purchase-requisitions', 'action' => 'create-rfq', $prHeader->id)); ?> ",
          data: $("#rfqForm").serialize(),
          dataType: 'json',
          beforeSend: function () { $("#gif_loader").show(); },
          success: function (response) {
            console.log(response);
            if (response.status == 'success') {
              $('#scheduleModal').modal('toggle');
              Toast.fire({
                icon: 'success',
                title: response.message
              });
            } else {
              Toast.fire({
                icon: 'error',
                title: response.message
              });
            }

          },
          complete: function () { $("#gif_loader").hide(); }
        });
        return false;
      }
    });
    
  });
</script>
