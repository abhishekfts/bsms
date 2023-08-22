<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Dailymonitor> $dailymonitor
 */
?>
<!-- <?= $this->Html->css('cstyle.css') ?> -->
<!-- <?= $this->Html->css('custom') ?> -->
<!-- <?= $this->Html->css('table.css') ?> -->
<!-- <?= $this->Html->css('listing.css') ?> -->
<?= $this->Html->css('v_index.css') ?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-6 d-flex justify-content-start">
                        <h5>Production Confirmation</h5>
                    </div>
                </div>
            </div>
            <div class="card-header" id="id_pohead">
                <table class="table table-bordered table-hover table-striped material-list" id="example1">
                    <thead>
                        <tr>
                            <th>Factory</th>
                            <th>Production Line</th>
                            <th>Material</th>
                            <th>Target Production</th>
                            <th>Confirm Production</th>
                            <th>Plan Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($dailymonitor)) : ?>
                        <?php foreach ($dailymonitor as $dailymonitors) : ?>
                        <tr>
                            <td>
                            <?= h($dailymonitors->production_line->line_master->vendor_factory->factory_code) ?>
                            </td>
                            <td>
                                <?= h($dailymonitors->production_line->line_master->name) ?>
                            </td>
                            <td>
                                <?= h($dailymonitors->material->description) ?>
                            </td>
                            <td>
                                <?= h($dailymonitors->target_production) ?>
                                <input type="hidden" value="<?php echo $dailymonitors->target_production;?>"
                                    id="plan_qty_<?= h($dailymonitors->id) ?>" data-id="<?= h($dailymonitors->id) ?>">
                            </td>
                            
                            <?php if ($dailymonitors->status == 1) : ?>
                            <td>
                                <input type="number" class="form-control form-control-sm confirm-input"
                                    id="confirmprd<?= h($dailymonitors->id) ?>" data-id="<?= h($dailymonitors->id) ?>">
                            </td>
                            <td>
                                <button class="btn btn-success save btn-sm mb-0"
                                    id="confirmsave<?= h($dailymonitors->id) ?>"
                                    data-id="<?= h($dailymonitors->id) ?>">Save</button>
                            </td>
                            <td>
                                <?= h($dailymonitors->plan_date) ?>
                            </td>
                            <?php elseif ($dailymonitors->status == 2) : ?>
                            <td colspan="2" class="text-center">
                                Plan Cancelled
                            </td>
                            <?php else: ?>
                            <td>
                                <input type="number" class="form-control form-control-sm"
                                    value="<?= h($dailymonitors->confirm_production) ?>" disabled>
                            </td>
                            <td>
                                <?= h($dailymonitors->plan_date) ?>
                            </td>
                            <td></td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="6">
                                No Records Found
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
            <?= $this->Form->create(null, ['id' => 'formUpload', 'url' => ['controller' => '/dailymonitor', 'action' => 'upload']]) ?>
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-lg-2">
                        <?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')); ?>
                        <?= $this->Form->control('upload_file', ['type' => 'file', 'label' => false, 'class' => 'pt-1 rounded-0', 'style' => 'visibility: hidden; position: absolute;', 'div' => 'form-group', 'id' => 'bulk_file']); ?>
                        <?= $this->Form->button('Upload File', ['id' => 'OpenImgUpload', 'type' =>
                'button', 'label' => 'Upload File', 'class' => 'd-block btn btn-block bg-gradient-button mb-0 file-upld-btn']); ?>
                        <span id="filessnames"></span>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2">
                    <button type="button" class="btn bg-gradient-submit" id="id_exportme">IMPORT FILE</button>
                    </div>
                    <div class="col-12 pt-2">
                        <i style="color: black;">
                            <a href="<?= $this->Url->build('/') ?>webroot/templates/production_confirmation.xlsx"
                                target="_blank" rel="noopener noreferrer">Production Confirmation.xlsx</a>
                        </i>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
<script>
    var getConfirmedProductionUrl = "<?php echo \Cake\Routing\Router::url(array('controller' => '/dailymonitor', 'action' => 'confirmedproduction')); ?>"
    var uploadConfirmedProductionUrl = "<?php echo \Cake\Routing\Router::url(array('controller' => '/dailymonitor', 'action' => 'upload')); ?>";
    $(".confirm-input").keyup(function () {
        var id = $(this).attr('data-id');
        var val = parseFloat($(this).val().trim());
        var maxQty = parseFloat($("#plan_qty_" + id).val().trim());
        console.log(val + "=" + maxQty);
        if (val > maxQty) {
            $(this).val(maxQty);
        }
    });

    $('#OpenImgUpload').click(function() {
        $('#bulk_file').trigger('click');
    });
    $('#bulk_file').change(function() {
        var file = $(this).prop('files')[0].name;
        $("#filessnames").append(file);
    });

    $("#id_exportme").click(function() {
        var fd = new FormData($('#formUpload')[0]);

        $.ajax({
            url: "<?php echo \Cake\Routing\Router::url(array('controller' => '/dailymonitor', 'action' => 'upload')); ?>",
            type: "post",
            dataType: 'json',
            processData: false, // important
            contentType: false, // important
            data: fd,
            success: function(response) {
                if (response.status) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });

                    $("#example1 tbody").empty();

                    // Loop through the response data and build the table rows dynamically
                    $.each(response.data, function (key, val) { 
                        var rowHtml = `<tr>
                        <td> `+ val.factory_code + `</td>
                        <td> `+ val.line + `</td>
                        <td> `+ val.material +`</td>
                        <td> `+ val.target_production + `</td>
                        <td> `+ val.confirm_production + `</td>
                        <td> `+ val.plan_date + `</td>
                        <td> `+ val.error + `</td>
                        </tr>`;
                        $("#example1 tbody").append(rowHtml);
                    });

                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }
            },
            error: function() {
                Toast.fire({
                    icon: 'error',
                    title: 'An error occured, please try again.'
                });
            }
        });
    });
</script>
<?= $this->Html->script('v_dailymonitor_dailyentry') ?>