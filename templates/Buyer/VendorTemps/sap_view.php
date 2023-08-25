<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\VendorTemp $vendorTemp
 */


switch ($vendorTemp->status) {

    case 0:
        $status = '<span class="badge bg-warning">Sent to Vendor</span>';
        break;
    case 1:
        $status = '<span class="badge bg-info">Pending for approval</span>';
        break;
    case 2:
        $status = '<span class="badge bg-info">Sent to SAP</span>';
        break;
    case 3:
        $status = '<span class="badge bg-success">Approved</span>';
        break;
    case 4:
        $status = '<span class="badge bg-danger">Rejected</span>';
        break;
    case 5:
        $status = '<span class="badge bg-info">Sap Import</span>';
        break;
}

?>

<?= $this->Html->css('cstyle.css') ?>
<style>
    p {
        margin-bottom: 0px;
    }

    /* .docs-list {
    width: 30% !important;
} */
</style>
<?= $this->Html->css('cstyle.css') ?>
<?= $this->Html->css('custom') ?>
<?= $this->Html->css('table.css') ?>
<?= $this->Html->css('listing.css') ?>
<?= $this->Html->css('b_index.css') ?>

<div class="row">
    <div class="col-12">
        <div class="vendorTemps view content card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h5 class="align-self-center">
                        <b>
                            <?= h($vendorTemp->name) ?>
                        </b>
                    </h5>
                    <div class="m-3">
                        <div class="text">

                            <?= $this->Html->link(__('Edit'), '#', ['class' => 'btn btn-info edit-button mb-0 btn-sm']) ?>


                            <?= $this->Html->link(__('Update'), '#', ['class' => 'btn btn-info update-button mb-0 btn-sm', 'style' => 'display:none', 'id' => $vendorTemp->id]) ?>

                            <?php if ($vendorTemp->status == 5) : ?>
                            <button type="button" class="btn btn-success btn-sm mb-0 sendCrendential" data-toggle="modal" data-target="#modal-sm">
                                Send Credentials
                            </button>
                            <?php endif; ?>
                            <!-- modal -->
                            <div class="modal fade" id="modal-sm" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-body text-center">
                                            <h6>Are you sure send login credentials?</h6>
                                        </div>
                                        <div class="modal-footer justify-content-between p-1">
                                            <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                                            <button type="button" data-id="<?= h($vendorTemp->id) ?>" class="btn btn-link notify">Ok</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <?= $this->Form->create(null, ['id' => 'userForm']) ?>
            <input type="hidden" name="">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <table class="table vendor-info mb-0">
                                <tr>
                                    <th>
                                        <?= __('SAP Vendor Code') ?>
                                    </th>
                                    <td>
                                        <?= !empty($vendorTemp->sap_vendor_code) ? $vendorTemp->sap_vendor_code : '' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('Purchasing Organization') ?>
                                    </th>
                                    <td>
                                        <?= $vendorTemp->has('purchasing_organization') ? $vendorTemp->purchasing_organization->name : '' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('Schema Group') ?>
                                    </th>
                                    <td>
                                        <?= $vendorTemp->has('schema_group') ? $vendorTemp->schema_group->name : '' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('Address 1') ?>
                                    </th>
                                    <td>
                                        <?= h($vendorTemp->address) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('Address 2') ?>
                                    </th>
                                    <td>
                                        <?= h($vendorTemp->address_2) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('Pincode') ?>
                                    </th>
                                    <td>
                                        <?= h($vendorTemp->pincode) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('Email Id') ?>
                                    </th>
                                    <td>

                                        <span class="email-text"><?= h($vendorTemp->email) ?></span>

                                        <input type="email" style="display: none;" name="email" class="form-control" required value="<?= h($vendorTemp->email) ?>" placeholder="Enter email">

                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('Order Currency') ?>
                                    </th>
                                    <td>
                                        <?= h($vendorTemp->order_currency) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('Pan No') ?>
                                    </th>
                                    <td>
                                        <?= h($vendorTemp->pan_no) ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        <?= __('Cin No') ?>
                                    </th>
                                    <td>
                                        <?= h($vendorTemp->cin_no) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('Added Date') ?>
                                    </th>
                                    <td>
                                        <?= h($vendorTemp->added_date) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('Updated Date') ?>
                                    </th>
                                    <td>
                                        <?= h($vendorTemp->updated_date) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('Status') ?>
                                    </th>
                                    <td  class="statusVendor">
                                        <?= $status ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="text-info mb-2 pl-2">Uploaded Documents</h6>
                                <table class="table docs-list vendor-info table-bordered">
                                    <tbody>
                                        <?php if ($vendorTemp->gst_file) : ?>
                                            <tr>
                                                <td>GST NO</td>
                                                </td>
                                                <td>
                                                    <?= $this->Html->link('<i class="fas fa-download"></i>', '/' . $vendorTemp->gst_file, array('escape' => false)); ?>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if ($vendorTemp->pan_file) : ?>
                                            <tr>
                                                <td>Pan card</td>
                                                <td>
                                                    <?= $this->Html->link('<i class="fas fa-download"></i>', '/' . $vendorTemp->pan_file, array('escape' => false)); ?>
                                                </td>
                                            </tr>
                                        <?php endif ?>
                                        <?php if ($vendorTemp->bank_file) : ?>
                                            <tr>
                                                <td>Bank Documents</td>
                                                <td>
                                                    <?= $this->Html->link('<i class="fas fa-download"></i>', '/' . $vendorTemp->bank_file, array('escape' => false)); ?>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <table class="table vendor-info mb-0">
                                <tr>
                                    <th>
                                        <?= __('Account Group') ?>
                                    </th>
                                    <td>
                                        <?= $vendorTemp->has('account_group') ? $vendorTemp->account_group->name : '' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('Name') ?>
                                    </th>
                                    <td>
                                        <?= h($vendorTemp->name) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('City') ?>
                                    </th>
                                    <td>
                                        <?= h($vendorTemp->city) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('Mobile') ?>
                                    </th>
                                    <td>

                                        <span class="mobile-text"><?= h($vendorTemp->mobile) ?></span>

                                        <input type="text" style="display: none;" name="mobile" class="form-control" required value="<?= h($vendorTemp->mobile) ?>">


                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('State') ?>
                                    </th>
                                    <td>
                                        <?= h($vendorTemp->state) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('Country') ?>
                                    </th>
                                    <td>
                                        <?= h($vendorTemp->country) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('Gst No') ?>
                                    </th>
                                    <td>
                                        <?= h($vendorTemp->gst_no) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('Contact Person') ?>
                                    </th>
                                    <td>
                                        <?= h($vendorTemp->contact_person) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('Contact Email Id') ?>
                                    </th>
                                    <td>
                                        <?= h($vendorTemp->contact_email) ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        <?= __('Contact Mobile') ?>
                                    </th>
                                    <td>
                                        <?= h($vendorTemp->contact_mobile) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('Contact Department') ?>
                                    </th>
                                    <td>
                                        <?= h($vendorTemp->contact_department) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('Contact Designation') ?>
                                    </th>
                                    <td>
                                        <?= h($vendorTemp->contact_designation) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('Tan No') ?>
                                    </th>
                                    <td>
                                        <?= h($vendorTemp->tan_no) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <?= __('Payment Term') ?>
                                    </th>
                                    <td>
                                        <?= h($vendorTemp->payment_term) ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <?= $this->Form->end() ?>

        </div>
    </div>
</div>

<!-- Modal Reject remarks-->
<div class="modal fade" id="remarkModal" tabindex="-1" role="dialog" aria-labelledby="remarkModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <?= $this->Form->create(null, ['id' => 'rejectRemarks', 'url' => ['action' => 'approve-vendor', $vendorTemp->id, 'rej']]) ?>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rejection Remark</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                echo $this->Form->control('remarks', ['label' => false, 'type' => 'textarea', 'class' => 'form-control rounded-0', 'div' => 'form-group']);

                ?>
            </div>
            <div id="error_msg"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Reject</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {


        $('.edit-button').click(function() {


            var $editButton = $(this);
            var $emailText = $('.email-text');
            var $mobileText = $('.mobile-text');
            var $emailInput = $('input[name="email"]');
            var $mobileInput = $('input[name="mobile"]');

            if ($editButton.text() === 'Edit') {
                $emailText.hide();
                $mobileText.hide();
                $emailInput.val($emailText.text()).show();
                $mobileInput.val($mobileText.text()).show();
                $editButton.hide();
                $('.update-button').show();
            } else {


                $emailText.text($emailInput.val()).show();
                $mobileText.text($mobileInput.val()).show();
                $emailInput.hide();
                $mobileInput.hide();
                $editButton.text('Edit');
            }
        });

        // var Toast = Swal.mixin({
        //     toast: true,
        //     position: "top-end",
        //     showConfirmButton: false,
        //     timer: 3000,
        // });

        $('.notify').click(function(e) {
            e.preventDefault();

            var $id = $(this).attr('data-id');

            // alert($username);

            $.ajax({
                type: "GET",
                url: "<?php echo \Cake\Routing\Router::url(array('controller' => '/VendorTemps', 'action' => 'user-credentials')); ?>/" + $id,
                dataType: 'json',
                beforeSend: function () { $("#gif_loader").show(); },
                success: function(response) {
                    if (response.status == "1") {
                        Toast.fire({
                            icon: "success",
                            title: response.message,
                        });
                        $('#modal-sm').modal('hide');
                        $(".sendCrendential").hide();
                        $(".statusVendor span").text("Approved");
                    } else {
                        Toast.fire({
                            icon: "error",
                            title: response.message,
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error case if needed
                },
                complete: function () { $("#gif_loader").hide(); }
            });
        });


        $('.update-button').click(function() {
            $vendorId = $('.update-button').attr('id');
            $.ajax({
                type: "POST",
                url: "<?php echo \Cake\Routing\Router::url(array('controller' => '/vendorTemps', 'action' => 'sap-edit')); ?>/" + $vendorId,
                data: $("#userForm").serialize(),

                dataType: "json",
                beforeSend: function () { $("#gif_loader").show(); },
                success: function(response) {
                    console.log(response);
                    if (response.status == "1") {
                        Toast.fire({
                            icon: "success",
                            title: response.message,
                        });
                        // form.submit();
                      $emailData = $('input[name="email"]').val()
                        $('.email-text').show();
                        $('.email-text').text($emailData);
                        $mobileData = $('input[name="mobile"]').val()
                        $('.mobile-text').show();
                        $('.mobile-text').text($mobileData);
                        $('input[name="email"]').val($('.email-text').text()).hide();
                        $('input[name="mobile"]').val($('.mobile-text').text()).hide();
                        $('.edit-button').show();
                        $('.update-button').hide();
                    } else {
                        Toast.fire({
                            icon: "error",
                            title: response.message,
                        });
                    }
                },
                complete: function () { $("#gif_loader").hide(); }
            });


        });

    });
</script>