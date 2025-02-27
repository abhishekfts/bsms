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
}

?>
<?= $this->Html->css('v_vendorCustom') ?>
<?= $this->Html->css('v_vendortemp_view') ?>
<div class="row">
    <div class="col-sm-12 col-md-3 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="prof-img text-center"><i class="fas fa-user-circle"></i></div>
                <div class="desc">
                    <ul>
                        <li>
                            <p>Name : <b>
                                    <?= h($vendorTemp->name) ?>
                                </b></p>
                        </li>
                        <li>
                            <p>Mobile No :<b>
                                    <?= h($vendorTemp->mobile) ?>
                                </b></p>
                        </li>
                        <li>
                            <p>Email ID : <b>
                                    <?= h($vendorTemp->email) ?>
                                </b></p>
                        </li>
                        <li>
                            <p>SAP Vendor Code : <b>
                                    <?= !empty($vendorTemp->sap_vendor_code) ? $vendorTemp->sap_vendor_code : '' ?>
                                </b></p>
                        </li>
                        <li>
                            <p>Status : <b>
                                    <?= $status ?>
                                </b></p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="card-header">
                <span>User Details
                    <div class="float-right">
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $vendorTemp->id], ['class' => 'btn btn-info btn-sm']) ?>
                    </div>
                </span>
            </div>
            <div class="card-body">
                <table style="width: 100%;">
                    <tr>
                        <th><?= __('Address 1') ?></th>
                        <td>: &nbsp;<?= h($vendorTemp->address) ?></td>
                        <th><?= __('Contact Person') ?></th>
                        <td>: &nbsp;<?= h($vendorTemp->contact_person) ?></td>                        
                    </tr>
                    <tr>
                        <th><?= __('Address 2') ?></th>
                        <td>: &nbsp;<?= h($vendorTemp->address_2) ?></td>
                        <th><?= __('Contact Email Id') ?></th>
                        <td>: &nbsp;<?= h($vendorTemp->contact_email) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('City') ?></th>
                        <td>: &nbsp;<?= h($vendorTemp->city) ?></td>
                        <th><?= __('Contact Mobile') ?></th>
                        <td>: &nbsp;<?= h($vendorTemp->contact_mobile) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('State') ?></th>
                        <td>: &nbsp;<?= h($vendorTemp->state) ?></td>
                        <th><?= __('Contact Department') ?></th>
                        <td>: &nbsp;<?= h($vendorTemp->contact_department) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Country') ?></th>
                        <td>: &nbsp;<?= h($vendorTemp->country) ?></td>
                        <th><?= __('Contact Designation') ?></th>
                        <td>: &nbsp;<?= h($vendorTemp->contact_designation) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Pincode') ?></th>
                        <td>: &nbsp;<?= h($vendorTemp->pincode) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Gst No') ?></th>
                        <td>: &nbsp;<?= h($vendorTemp->gst_no) ?></td>
                        <th><?= __('Purchasing Organization') ?></th>
                        <td>: &nbsp;<?= $vendorTemp->has('purchasing_organization') ? $vendorTemp->purchasing_organization->name : '' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Tan No') ?></th>
                        <td>: &nbsp;<?= h($vendorTemp->tan_no) ?></td>
                        <th><?= __('Account Group') ?></th>
                        <td>: &nbsp;<?= $vendorTemp->has('account_group') ? $vendorTemp->account_group->name : '' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Pan No') ?></th>
                        <td>: &nbsp;<?= h($vendorTemp->pan_no) ?></td>
                        <th><?= __('Schema Group') ?></th>
                        <td>: &nbsp;<?= $vendorTemp->has('schema_group') ? $vendorTemp->schema_group->name : '' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Order Currency') ?></th>
                        <td>: &nbsp;<?= h($vendorTemp->order_currency) ?></td>
                        <th><?= __('Payment Term') ?></th>
                        <td>: &nbsp;<?= (h($vendorTemp->payment_term)); ?></td>
                    </tr>
                </table>
            </div>
            <div class="card-footer p-3">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <?php if ($vendorTemp->gst_file): ?>
                        <h5 class="mb-1">
                            <?= $this->Html->link('<i class="far fa-file-archive fa-lg"></i> &nbsp; GST NO', '/' . $vendorTemp->gst_file, ['escape' => false, 'class' => 'btn btn-block mb-0 text-info text-left p-2', 'target' => '_blank']); ?>
                        </h5>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <?php if ($vendorTemp->pan_file): ?>
                        <h5 class="mb-1">
                            <?= $this->Html->link('<i class="far fa-file-archive fa-lg"></i> &nbsp; PAN NO', '/' . $vendorTemp->pan_file, ['escape' => false, 'class' => 'btn mb-0 btn-block text-info text-left p-2', 'target' => '_blank']); ?>
                        </h5>
                        <?php endif ?>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <?php if ($vendorTemp->pan_file): ?>
                        <h5 class="mb-1">
                            <?= $this->Html->link('<i class="far fa-file-archive fa-lg"></i> &nbsp; Bank Documents', '/' . $vendorTemp->bank_file, ['escape' => false, 'class' => 'btn mb-0 btn-block text-info text-left p-2', 'target' => '_blank']); ?>
                        </h5>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script('v_vendortemps_view') ?>