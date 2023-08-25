<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Stockupload $stockupload
 */

use PhpOffice\PhpSpreadsheet\Calculation\Information\Value;

?>

<div class="row">
    <div class="col-12">
        <?= $this->Form->create($stockupload, ['id' => 'stockuploadForm']) ?>
        <div class="card">
            <div class="card-header pb-1 pt-2">
                <div class="row">   
                    <div class="col-lg-6 d-flex justify-content-start">
                        <h5><b>Add Stock Upload</b></h5>
                    </div>
                </div>
            </div>
            <div class="card-body invoice-details">
                <div class="row dgf m-0">
                <div class="col-sm-8 col-md-3">
                        <div class="form-group">
                            <?php echo $this->Form->control('vendor_factory_id', array('class' => 'form-control w-100', 'options' => $vendor_factory, 'id' => 'descripe',  'empty' => 'Please Select', 'label' => 'Factory Code')); ?>
                        </div>
                    </div>
                    <div class="col-sm-8 col-md-3">
                        <div class="form-group">
                            <?php echo $this->Form->control('material_id', array('class' => 'form-control w-100', 'options' => $vendor_mateial, 'id' => 'descripe',  'empty' => 'Please Select', 'label' => 'Material Code')); ?>
                        </div>
                    </div>

                    <div class="col-sm-8 col-md-2">
                        <div class="form-group">
                            <?php echo $this->Form->control('opening_stock', array('type' => 'number', 'class' => 'form-control rounded-0 w-100', 'min' => "1", 'div' => 'form-group')); ?>
                        </div>
                    </div>
                    <div class="col-sm-8 col-md-1 d-flex justify-content-end align-items-end">
                        <div class="form-group">
                        <button type="button" class="btn bg-gradient-submit" id="stockClick">Submit</button>
                        <button type="submit" style="display: none;" id="stockInputSubmit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-6 d-flex justify-content-start">
                        <h5><b>UPLOAD STOCKS</b></h5>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <?= $this->Form->create(null, ['id' => 'formUpload', 'url' => ['controller' => '/stock-uploads', 'action' => 'upload']]) ?>
                <div class="row">
                    <div class="col-sm-2 col-md-2 mt-3">
                        <?= $this->Form->control('upload_file', [
                                'type' => 'file', 'label' => false, 'class' => 'pt-1 rounded-0', 'style' => 'visibility: hidden; position: absolute;', 'div' => 'form-group', 'id' => 'bulk_file']); ?>
                        <?= $this->Form->button('Choose File', ['id' => 'OpenImgUpload','type' => 'button','class' => 'd-block btn bg-gradient-button btn-block mb-0 file-upld-btn' ]); ?>
                        <span id="filessnames"></span>
                    </div>
                    <div class="col-sm-2 col-md-2 mt-3 d-flex justify-content-start align-items-baseline">
                        <button class="btn bg-gradient-submit" id="id_import" type="button">
                            Submit
                        </button>
                    </div>
                    <div class="col-sm-12 col-md-12 mt-3">
                        <i style="color: black;">
                            <a href="<?= $this->Url->build('/') ?>webroot/templates/material_stock_upload_vendor.xlsx"
                                download>stock_upload_template</a>
                        </i>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
            
            <div class="card-footer" id="id_pohead">
                <table class="table table-hover" id="example1">
                    <thead>
                        <tr>
                            <th>Facotry</th>
                            <th>Material Code</th>
                            <th>Material Description</th>
                            <th>Opening Stock</th>
                            <th>Unit Of Measurement</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
                <button type="button" class="btn addCancel"  data-dismiss="modal">Cancel</button>
                <button type="button" class="btn addSubmit">Ok</button>
            </div>
        </div>
    </div>
</div>


<script>
    $("#stockuploadForm").validate({
        rules: {
            code: {
                required: true
            },
            description: {
                required: true
            },
            uom: {
                required: true
            },
            opening_stock: {
                required: true,
                number: true
            }
        },
        messages: {
            code: {
                required: "Please select a material code"
            },
            description: {
                required: "Please enter a material description"
            },
            uom: {
                required: "Please enter a unit of measurement"
            },
            opening_stock: {
                required: "Please enter the opening stock quantity",
                number: "Please enter a valid number"
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
            $('#modal-confirm').modal('show');
            return false;
        }
    });


    $('#stockClick').click(function () {
        if ($('#stockuploadForm').valid()) {
            $('#modal-sm').modal('show');
            submitStatus = true
        }
    });

    $('#stockFileSubmit').click(function() {
        $('#modal-sm').modal('show');
        submitStatus = false
    });


    $('.addSubmit').click(function() {
        if (submitStatus && $('#stockuploadForm').valid()) {
            $('#stockuploadForm')[0].submit();
        } else {
            $('#id_import').trigger('click');
        }
        $('#modal-sm').modal('hide');

    });




    $(document).ready(function() {

        var submitStatus;

        var csrf = $("input[name=_csrfToken]").val();
        $("input").val("");
        $('select').prop('selectedIndex', 0);
        $("input[name=_csrfToken]").val(csrf);

        $('#OpenImgUpload').click(function() {
            $('#bulk_file').trigger('click');
        });
        $('#bulk_file').change(function () {
            var file = $(this).prop('files')[0].name;
            $("#filessnames").append(file);
        });

        setTimeout(function () {
            $('.success').fadeOut('slow');
        }, 2000);

        $("#descripe").change(function () {
            var vendorId = $(this).val();
            if (vendorId != "") {
                $.ajax({
                    type: "get",
                    url: "<?php echo \Cake\Routing\Router::url(array('controller' => '/stock-uploads', 'action' => 'material')); ?>/" + vendorId,
                    dataType: "json",
                    beforeSend: function (xhr) {
                        $("#gif_loader").show();
                        xhr.setRequestHeader(
                            "Content-type",
                            "application/x-www-form-urlencoded"
                        );
                    },
                    success: function (response) {
                        if (response.status == "1") {
                            $("#description").val(response.data.description);
                            $("#uom").val(response.data.uom);
                        }
                    },
                    error: function (e) {
                        alert("An error occurred: " + e.responseText.message);
                        console.log(e);
                    },
                    complete: function () { $("#gif_loader").hide(); }
                });
            }
        });
    });

    $("#id_import").click(function () {
        var fd = new FormData($('#formUpload')[0]);

        $.ajax({
            url: "<?php echo \Cake\Routing\Router::url(array('controller' => '/stock-uploads', 'action' => 'upload')); ?>",
            type: "post",
            dataType: 'json',
            processData: false, // important
            contentType: false, // important
            data: fd,
            beforeSend: function () { $("#gif_loader").show(); },
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
                        <td> `+ val.material +` </td>
                        <td> `+ val.description + `</td>
                        <td> `+ val.opening_stock + `</td>
                        <td> `+ val.uom + `</td>
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
                $("#formUpload")[0].reset();
            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    title: 'An error occured, please try again.'
                });
            },
            complete: function () { $("#gif_loader").hide(); }
        });
    });
</script>