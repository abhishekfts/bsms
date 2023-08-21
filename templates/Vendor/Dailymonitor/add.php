<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dailymonitor $dailymonitor
 */
?>
<!-- <?= $this->Html->css('cstyle.css') ?> -->
<!-- <?= $this->Html->css('custom') ?> -->
<!-- <?= $this->Html->css('table.css') ?> -->
<!-- <?= $this->Html->css('listing.css') ?> -->
<!-- <?= $this->Html->css('v_index.css') ?> -->
<div class="row">
    <div class="col-12">
        <?= $this->Form->create($dailymonitor) ?>
        <div class="card">
            <div class="card-header pb-1 pt-2">
                <div class="row">
                    <div class="col-lg-6 d-flex justify-content-start">
                        <h5><b>Add Production Planner</b></h5>
                    </div>
                </div>
            </div>
            <div class="card-body invoice-details">

                <div class="row dgf m-0">
                    <div class="col-sm-8 col-md-3">
                        <div class="form-group">
                            <?php echo $this->Form->control('plan_date', array('type'=>'date', 'class' => 'form-control w-100', 'style' => "height: unset !important;")); ?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <?php echo $this->Form->control('vendor_factory_id', array('class' => 'form-control w-100', 'options' => $factory, 'style' => "height: unset !important;", 'empty' => 'Please Select', 'label' => 'Factory', 'required')); ?>
                        </div>
                    </div>
                    
                    <div class="col-sm-8 col-md-3">
                        <div class="form-group">
                            <?php echo $this->Form->control('production_line_id', array('name' => 'production_line_id', 'class' => 'form-control w-100',  'style' => "height: unset !important;", 'empty' => 'Please Select')); ?>
                        </div>
                    </div>
                    <div class="col-sm-8 col-md-3">
                        <div class="form-group">
                            <?php echo $this->Form->control('material_id', array('class' => 'form-control w-100', 'style' => "height: unset !important;", 'empty' => 'Please Select')); ?>
                        </div>
                    </div>

                    <div class="col-sm-8 col-md-3">
                        <div class="form-group">
                            <?php echo $this->Form->control('target_production', array('type' => 'number', 'class' => 'form-control rounded-0 w-100', 'style' => "height: unset !important;", 'div' => 'form-group', 'required')); ?>
                        </div>
                    </div>

                    <div class="col-sm-8 col-md-3" style="display:none;">
                        <div class="form-group">
                            <?php echo $this->Form->control('confirm_production', array('type' => 'number', 'value' => '0','class' => 'form-control rounded-0 w-100', 'style' => "height: unset !important;", 'div' => 'form-group', 'required')); ?>
                        </div>
                    </div>
                    <div class="col-sm-8 col-md-3 d-flex justify-content-start align-items-end">
                        <button type="button" class="btn bg-gradient-submit" onclick="showConfirmationModal()">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-sm" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h6>Are you sure you want to Add?</h6>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn" style="border:1px solid #6610f2" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn" style="border:1px solid #28a745">Ok</button>
                    </div>
                </div>
            </div>
        </div>

        <?= $this->Form->end() ?>
    </div>
    <div class="col-12">
        <?= $this->Form->create($dailymonitor) ?>
        <div class="card">
            <div class="card-header">
                <h5><b>Bulk Production Planner</b></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-lg-2">
                        <?= $this->Form->control('vendor_code', [
                                'type' => 'file', 'label' => false, 'class' => 'pt-1 rounded-0', 'style' => 'visibility: hidden; position: absolute;', 'div' => 'form-group', 'id' => 'vendorCodeInput']); ?>
                        <?= $this->Form->button('Choose File', ['id' => 'OpenImgUpload','type' => 'button','class' => 'd-block btn bg-gradient-button btn-block mb-0 file-upld-btn'
                            ]); ?>
                        <span id="filessnames"></span>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2">
                        <button type="submit" class="btn bg-gradient-submit" id="id_exportme">IMPORT FILE</button>
                    </div>
                    <div class="col-12 pt-2">
                        <i style="color: black;">
                            <a href="<?= $this->Url->build('/') ?>webroot/templates/production_planner_template.xlsx"
                                target="_blank" rel="noopener noreferrer">Sample_Excel_Template.xlsx</a>
                        </i>
                    </div>
                </div>
            </div>
            <div class="card-footer table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Plan Date</th>
                            <th>Production Line</th>
                            <th>Material</th>
                            <th>Target Production</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="text-center">No data found !</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
<?= $this->Html->script('v_dailymonitor_add') ?>
<script>
    $("#vendor-factory-id").change(function () {
  var lineId = $(this).val();
  $("#production-line-id").empty().append("<option value=''>Please Select</option>");
  $("#material-id").empty().append("<option value=''>Please Select</option>");

  if (lineId != "") {
      $.ajax({
          type: "get",
          url: "<?php echo \Cake\Routing\Router::url(array('controller' => '/line-masters', 'action' => 'get-factory-lines')); ?>/" + lineId,
          dataType: "json",
          beforeSend: function (xhr) {
              xhr.setRequestHeader(
                  "Content-type",
                  "application/x-www-form-urlencoded"
              );
          },
          success: function (response) {
              if (response.status) {
                  $.each(response.data.lines, function (key, val) { 
                       $("#production-line-id").append("<option value='"+val.id+"'>"+val.name+"</option>");
                  });
                  $.each(response.data.materials, function (key, val) { 
                       $("#material-id").append("<option value='"+val.id+"'>"+val.code+"</option>");
                  });
              }
          },
          error: function (e) {
              alert("An error occurred: " + e.responseText.message);
              console.log(e);
          },
      });
  }
});

$("#production-line-id").change(function () {
        var lineId = $(this).val();
        $("#material-id").empty().append("<option value=''>Please Select</option>");
        if (lineId != "") {
            $.ajax({
                type: "get",
                url: "<?php echo \Cake\Routing\Router::url(array('controller' => '/production-lines', 'action' => 'get-line-materials')); ?>/" + lineId,
                dataType: "json",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader(
                        "Content-type",
                        "application/x-www-form-urlencoded"
                    );
                },
                success: function (response) {
                    if (response.status) {
                        $.each(response.data.materials, function (key, val) { 
                            $("#material-id").append("<option value='"+val.id+"' data-capacity='"+val.capacity+"'>"+val.description+"</option>");
                        });
                    }
                },
                error: function (e) {
                    alert("An error occurred: " + e.responseText.message);
                    console.log(e);
                },
            });
        }
    });


    $("#material-id").change(function () {
        var capacity = $('option:selected', this).attr("data-capacity");
        console.log(capacity);
        $("#target-production").val(capacity);
    });

</script>

