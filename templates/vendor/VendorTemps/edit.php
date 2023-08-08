<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\VendorTemp $vendorTemp
 * @var string[]|\Cake\Collection\CollectionInterface $purchasingOrganizations
 * @var string[]|\Cake\Collection\CollectionInterface $accountGroups
 * @var string[]|\Cake\Collection\CollectionInterface $schemaGroups
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

<!-- <?= $this->Html->css('cstyle.css') ?> -->
<!-- <?= $this->Html->css('table.css') ?> -->
<!-- <?= $this->Html->css('listing.css') ?> -->
<!-- <?= $this->Html->css('v_index.css') ?> -->
<?= $this->Html->css('v_vendorCustom') ?>
<?= $this->Html->css('v_vendortemp_view') ?>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" /> -->

<style>
    .hide {
        display: none;
    }

    /* Default Button */
    .bg-gradient-button {
        background: #F2EDD7FF linear-gradient(180deg, #F2EDD7FF, #e5e1cc) repeat-x !important;
        color: #755139FF !important;
    }

    .bg-gradient-button.btn:not(:disabled):not(.disabled):active,
    .bg-gradient-button.btn:not(:disabled):not(.disabled).active,
    .show>.bg-gradient-button.btn.dropdown-toggle {
        background-image: none !important;
    }

    .bg-gradient-button.btn:hover {
        background: #F2EDD7FF linear-gradient(180deg, #e5e1cc, #F2EDD7FF) repeat-x !important;
        border-color: #F2EDD7FF;
        color: #755139FF !important;
    }

    .bg-gradient-button.btn:not(:disabled):not(.disabled):active,
    .bg-gradient-button.btn:not(:disabled):not(.disabled).active,
    .bg-gradient-button.btn:active,
    .bg-gradient-button.btn.active {
        background: #F2EDD7FF linear-gradient(180deg, #e5e1cc, #e5e1cc) repeat-x !important;
        border-color: #F2EDD7FF;
        color: #755139FF !important;
    }

    .bg-gradient-button.btn:disabled,
    .bg-gradient-button.btn.disabled {
        background-image: none !important;
        border-color: #F2EDD7FF;
        color: #755139FF !important;
    }

    /* Default Button */


    /* Submit Button */
    .bg-gradient-submit {
        background: #08132f linear-gradient(180deg, #5b8aff, #102b71) repeat-x !important;
        border-color: #ffffff;
        color: #fff;
    }

    .bg-gradient-submit.btn:not(:disabled):not(.disabled):active,
    .bg-gradient-submit.btn:not(:disabled):not(.disabled).active,
    .show>.bg-gradient-submit.btn.dropdown-toggle {
        background-image: none !important;
    }

    .bg-gradient-submit.btn:hover {
        background: #08132f linear-gradient(180deg, #102b71, #5b8aff) repeat-x !important;
        border-color: #ffffff;
        color: #fff;
    }

    .bg-gradient-submit.btn:not(:disabled):not(.disabled):active,
    .bg-gradient-submit.btn:not(:disabled):not(.disabled).active,
    .bg-gradient-submit.btn:active,
    .bg-gradient-submit.btn.active {
        background: #08132f linear-gradient(180deg, #5b8aff, #102b71) repeat-x !important;
        border-color: #ffffff;
        color: #fff;
    }

    .bg-gradient-submit.btn:disabled,
    .bg-gradient-submit.btn.disabled {
        background-image: none !important;
        border-color: #ffffff;
        color: #fff;
    }

    /* Submit Button */

    /* Reject Button */
    .bg-gradient-reject {
        background: #F1F4FFFF linear-gradient(180deg, #F1F4FFFF, #ffc8be) repeat-x !important;
        border-color: #F1F4FFFF;
        color: #990011FF;
    }

    .bg-gradient-reject.btn:not(:disabled):not(.disabled):active,
    .bg-gradient-reject.btn:not(:disabled):not(.disabled).active,
    .show>.bg-gradient-reject.btn.dropdown-toggle {
        background-image: none !important;
    }

    .bg-gradient-reject.btn:hover {
        background: #F1F4FFFF linear-gradient(180deg, #ffc8be, #F1F4FFFF) repeat-x !important;
        border-color: #F1F4FFFF;
        color: #990011FF;
    }

    .bg-gradient-reject.btn:not(:disabled):not(.disabled):active,
    .bg-gradient-reject.btn:not(:disabled):not(.disabled).active,
    .bg-gradient-reject.btn:active,
    .bg-gradient-reject.btn.active {
        background: #F1F4FFFF linear-gradient(180deg, #ffc8be, #F1F4FFFF) repeat-x !important;
        border-color: #F1F4FFFF;
        color: #990011FF;
    }

    .bg-gradient-reject.btn:disabled,
    .bg-gradient-reject.btn.disabled {
        background-image: none !important;
        border-color: #F1F4FFFF;
        color: #990011FF;
    }

    /* Reject Button */


    /* Cancel Button */
    .bg-gradient-cancel {
        background: #F1F4FFFF linear-gradient(180deg, #edeff7, #ccd7fd) repeat-x !important;
        border-color: #F1F4FFFF;
        color: #496e97;
    }

    .bg-gradient-cancel.btn:not(:disabled):not(.disabled):active,
    .bg-gradient-cancel.btn:not(:disabled):not(.disabled).active,
    .show>.bg-gradient-cancel.btn.dropdown-toggle {
        background-image: none !important;
    }

    .bg-gradient-cancel.btn:hover {
        background: #F1F4FFFF linear-gradient(180deg, #ccd7fd, #edeff7) repeat-x !important;
        border-color: #F1F4FFFF;
        color: #496e97;
    }

    .bg-gradient-cancel.btn:not(:disabled):not(.disabled):active,
    .bg-gradient-cancel.btn:not(:disabled):not(.disabled).active,
    .bg-gradient-cancel.btn:active,
    .bg-gradient-cancel.btn.active {
        background: #F1F4FFFF linear-gradient(180deg, #ccd7fd, #edeff7) repeat-x !important;
        border-color: #F1F4FFFF;
        color: #496e97;
    }

    .bg-gradient-cancel.btn:disabled,
    .bg-gradient-cancel.btn.disabled {
        background-image: none !important;
        background-color: #F1F4FFFF !important;
        border-color: #F1F4FFFF;
        color: #496e97;
    }

    /* Cancel Button */

    /* warn Button */
    .bg-gradient-warn {
        background: #ff2700 linear-gradient(180deg, #ff2700, #c71f00) repeat-x !important;
        border-color: #ff2700;
        color: #fff;
    }

    .bg-gradient-warn.btn:not(:disabled):not(.disabled):active,
    .bg-gradient-warn.btn:not(:disabled):not(.disabled).active,
    .show>.bg-gradient-warn.btn.dropdown-toggle {
        background-image: none !important;
    }

    .bg-gradient-warn.btn:hover {
        background: #ff2700 linear-gradient(180deg, #ff2700, #ff836c) repeat-x !important;
        border-color: #ff2700;
        color: #fff;
    }

    .bg-gradient-warn.btn:not(:disabled):not(.disabled):active,
    .bg-gradient-warn.btn:not(:disabled):not(.disabled).active,
    .bg-gradient-warn.btn:active,
    .bg-gradient-warn.btn.active {
        background: #ff2700 linear-gradient(180deg, #ff836c, #ff2700) repeat-x !important;
        border-color: #ff2700;
        color: #fff;
    }

    .bg-gradient-warn.btn:disabled,
    .bg-gradient-warn.btn.disabled {
        background-image: none !important;
        border-color: #ff2700;
        color: #fff;
    }

    #onbordingSubmit .form-control[disabled] {
        padding: 0 !important;
        line-height: 1.45 !important;
    }

    /* Reject Button */
</style>

<div class="row">
    <div class="col-sm-12 col-md-3 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="prof-img text-center"><i class="fas fa-user-circle"></i></div>
                <div class="desc">
                    <ul>
                        <li>
                            <p>Name :
                                <b>
                                    <?= h($vendorTemp->name) ?>
                                </b>
                            </p>
                        </li>
                        <li>
                            <p>Mobile No :
                                <b>
                                    <?= h($vendorTemp->mobile) ?>
                                </b>
                            </p>
                        </li>
                        <li>
                            <p>Email ID :
                                <b>
                                    <?= h($vendorTemp->email) ?>
                                </b>
                            </p>
                        </li>
                        <li>
                            <p>SAP Vendor Code :
                                <b>
                                    <?= !empty($vendorTemp->sap_vendor_code) ? $vendorTemp->sap_vendor_code : '' ?>
                                </b>
                            </p>
                        </li>
                        <li>
                            <p>Status :
                                <b>
                                    <?= $status ?>
                                </b>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-9 col-lg-9">
        <?= $this->Form->create($vendorTemp, ['type' => 'file', 'id' => 'onbordingSubmit', 'class' => 'mb-0']) ?>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-lg-3 mb-3">
                                <?php echo $this->Form->control('purchasing_organization_id', ['disabled' => 'disabled', 'options' => $purchasingOrganizations, 'class' => 'form-control']); ?>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-3 mb-3">
                                <?php echo $this->Form->control('account_group_id', ['disabled' => 'disabled', 'options' => $accountGroups, 'class' => 'form-control']); ?>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-3 mb-3">
                                <?php echo $this->Form->control('schema_group_id', ['disabled' => 'disabled', 'options' => $schemaGroups, 'class' => 'form-control']); ?>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-3 mb-3">
                                <?php echo $this->Form->control('payment_term', ['disabled' => 'disabled', 'class' => 'form-control']); ?>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-3 mb-3">
                                <div class="form-group">
                                    <?php
                                    $businessTypes  = [
                                        'PROPRIETARY' => 'Proprietary',
                                        'PARTNERSHIP' => 'Partnership Concern',
                                        'PUBLIC_LIMITED' => 'Public Limited Company',
                                        'PRIVATE_LIMITED' => 'Private Limited Company'
                                    ];
                                    echo $this->Form->control('status', ['class' => 'form-control', 'options' => $businessTypes, 'label' => 'Status']);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card card-outline card-outline-tabs">
                    <div class="card-header p-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab_address" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="true">Address</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab_branchoffice" data-toggle="pill" href="#custom-tabs-four-branch" role="tab" aria-controls="custom-tabs-four-branch" aria-selected="false">Branch Office</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab_productionfaculty" data-toggle="pill" href="#custom-tabs-four-productionfaculty" role="tab" aria-controls="custom-tabs-four-productionfaculty" aria-selected="false">Production
                                    Facility</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="tab_contactperson" data-toggle="pill" href="#custom-tabs-four-contactperson" role="tab" aria-controls="custom-tabs-four-contactperson" aria-selected="false">Contact
                                    Person</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="tab_paymentdetails" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">Payment
                                    Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab_certificate" data-toggle="pill" href="#custom-tabs-four-certificate" role="tab" aria-controls="custom-tabs-four-certificate" aria-selected="false">Certificate</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="tab_questionnaire " data-toggle="pill" href="#custom-tabs-four-questionnaire" role="tab" aria-controls="custom-tabs-four-questionnaire" aria-selected="false">Questionnaire</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab_customerAddress" data-toggle="pill" href="#custom-tabs-four-customerAddress" role="tab" aria-controls="custom-tabs-four-customerAddress" aria-selected="false">Reputed
                                    Customer</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade active show" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="tab_address" style="background-color: white;">
                                <h5>Permanent Address</h5>
                                <div class="row">
                                    <div class="col-3 mt-3 col-md-3">
                                        <div class="form-group">
                                            <?php echo $this->Form->control('address', ['name' => 'permanent_address[address]', 'class' => 'form-control ', 'id' => 'id_permanent_address_address1', 'label' => "Address"]); ?>
                                        </div>
                                    </div>
                                    <div class="col-3 mt-3 col-md-3">
                                        <div class="form-group">
                                            <?php echo $this->Form->control('address_2', ['name' => 'permanent_address[address_2]', 'label' => 'Address 1', 'id' => 'id_permanent_address_address2', 'class' => 'form-control']); ?>
                                        </div>
                                    </div>
                                    <div class="col-3 mt-3 col-md-3">
                                        <div class="form-group">
                                            <?php echo $this->Form->control('pincode', ['name' => 'permanent_address[pincode]', 'class' => 'form-control ', 'id' => 'id_permanent_address_pincode']); ?>
                                        </div>
                                    </div>

                                    <div class="col-3 mt-3 col-md-3">
                                        <div class="form-group">
                                            <?php echo $this->Form->control('city', ['type' => 'text', 'name' => 'permanent_address[city]', 'class' => 'form-control alphaonly capitalize', 'id' => 'id_permanent_address_city']); ?>
                                        </div>
                                    </div>

                                    <div class="col-3 mt-3 col-md-3">
                                        <div class="form-group">
                                            <?php echo $this->Form->control('country', ['name' => 'permanent_address[country]', 'id' => 'id_permanent_address_country', 'class' => 'selectpicker form-control my-select ', 'options' => $countries, 'data-live-search' => 'true', 'title' => 'Select Country']); ?>
                                        </div>
                                    </div>

                                    <div class="col-3 mt-3 col-md-3">
                                        <div class="form-group">
                                            <?php echo $this->Form->control('state', ['name' => 'permanent_address[state]', 'id' => 'id_permanent_address_state', 'class' => 'selectpicker form-control my-select', 'options' => $states, 'data-live-search' => 'true', 'title' => 'Select State']); ?>
                                        </div>
                                    </div>
                                    <div class="col-3 mt-3 col-md-3">
                                        <div class="form-group">
                                            <?php echo $this->Form->control('Telephone', ['name' => 'permanent_address[telephone]', 'type' => 'number', 'class' => 'form-control maxlength_validation', 'maxlength' => '10', 'id' => 'id_permanent_address_telephone']); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 mt-3">
                                        <div class="form-group">
                                            <?php echo $this->Form->control('register_office_faxno', ['name' => 'permanent_address[faxno]', 'id' => 'id_permanent_address_faxno', 'type' => 'number', 'class' => 'form-control maxlength_validation', 'label' => 'Fax No.', 'maxlength' => '10']); ?>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border: revert;">
                                <h5>Registered Office Address</h5>
                                <div class="icheck-primary">
                                    <input type="checkbox" id="copypermanant">
                                    <label for="copypermanant">Same as Permanent Address</label>
                                </div>
                                <div class="row">
                                    <div class="col-3 mt-3 col-md-3">
                                        <div class="form-group">
                                            <?php echo $this->Form->control('register_office_address1', ['name' => 'registered_office[address1]', 'id' => 'register_office_address1', 'class' => 'form-control', 'label' => "Address 1"]); ?>
                                        </div>
                                    </div>
                                    <div class="col-3 mt-3 col-md-3">
                                        <div class="form-group">
                                            <?php echo $this->Form->control('register_office_address2', ['name' => 'registered_office[address2]', 'label' => 'Address 2', 'class' => 'form-control', 'id' => 'register_office_address2']); ?>
                                        </div>
                                    </div>
                                    <div class="col-3 mt-3 col-md-3">
                                        <div class="form-group">
                                            <?php echo $this->Form->control(
                                                'register_office_pincode',
                                                ['type' => 'number', 'name' => 'registered_office[pincode]', 'label' => 'Pincode', 'class' => 'form-control maxlength_validation', 'id' => 'register_office_pincode', 'maxlength' => '6']
                                            ); ?>
                                        </div>

                                    </div>
                                    <div class="col-3 mt-3 col-md-3">
                                        <div class="form-group">
                                            <?php echo $this->Form->control('register_office_city', ['type' => 'text', 'name' => 'registered_office[city]', 'class' => 'form-control alphaonly capitalize', 'label' => 'City', 'id' => 'register_office_city']); ?>
                                        </div>
                                    </div>
                                    <div class="col-3 mt-3 col-md-3">
                                        <div class="form-group">
                                            <?php echo $this->Form->control('register_office_country', ['name' => 'registered_office[country]', 'class' => 'selectpicker show-menu-arrow form-control my-select1', 'options' => $countries, 'label' => 'Country', 'data-live-search' => 'true', 'title' => 'Select Country', 'id' => 'register_office_country']); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 mt-3">
                                        <div class="form-group">
                                            <?php echo $this->Form->control('register_office_state', ['name' => 'registered_office[state]', 'class' => 'selectpicker form-control my-select1', 'options' => $states, 'label' => 'State', 'data-live-search' => 'true', 'title' => 'Select State', 'id' => 'register_office_state']); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 mt-3">
                                        <div class="form-group">
                                            <?php echo $this->Form->control('Telephone', ['name' => 'registered_office[telephone]', 'type' => 'number', 'class' => 'form-control maxlength_validation', 'id' => 'register_office_telephone', 'maxlength' => '10']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="custom-tabs-four-branch" role="tabpanel" aria-labelledby="tab_branchoffice" style="background-color: white;">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h5>Branch Office Address</h5>
                                        <span data-class="branch_office" class="badge lgreenbadge mt-2 add" id="id_branch_office_add" data-toggle="tooltip" data-placement="right" title="Add Address">
                                            <i class="fas fa-plus-circle"></i>
                                        </span>
                                    </div>
                                    <div class="card-body branch_office_card_body">
                                        <div class="row branch_office branch_office_0" data-id="0" id="branch_office_0">
                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('register_office_address1', ['type' => 'text', 'name' => 'branch[branch_office][0][address1]', 'id' => 'branch_office_0_address1', 'class' => 'form-control', 'label' => "Address 1"]); ?>
                                                </div>
                                            </div>
                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('register_office_address2', ['type' => 'text', 'name' => 'branch[branch_office][0][address2]', 'id' => 'branch_office_0_address2', 'label' => 'Address 2', 'class' => 'form-control']); ?>
                                                </div>
                                            </div>
                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('register_office_pincode', ['type' => 'number', 'name' => 'branch[branch_office][0][pincode]', 'label' => 'Pincode', 'class' => 'form-control pincode-input', 'id' => 'branch_office_0_pincode', 'maxlength' => '6']); ?>
                                                </div>
                                            </div>
                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('register_office_city', ['type' => 'text', 'name' => 'branch[branch_office][0][city]', 'class' => 'form-control alphaonly capitalize', 'label' => 'City', 'id' => 'branch_office_0_city']); ?>
                                                </div>
                                            </div>
                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('register_office_country', ['name' => 'branch[branch_office][0][country]', 'class' => 'selectpicker form-control my-select', 'options' => $countries, 'label' => 'Country', 'data-live-search' => 'true', 'title' => 'Select Country', 'id' => 'branch_office_0_country']); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-3 mt-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('register_office_state', ['name' => 'branch[branch_office][0][state]', 'class' => 'selectpicker form-control my-select', 'options' => $states, 'label' => 'State', 'data-live-search' => 'true', 'title' => 'Select State', 'id' => 'branch_office_0_state']); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-3 mt-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('register_office_telno', ['name' => 'branch[branch_office][0][telno]', 'type' => 'number', 'class' => 'form-control maxlength_validation', 'id' => 'branch_office_0_telno', 'label' => 'Tel No', 'maxlength' => '10']); ?>
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-3 mt-4 pt-4 hide">
                                                <span class="badge redbadge delete" data-toggle="tooltip" data-class="branch_office" data-placement="right" data-id="0" data-original-title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <hr class="branch_office_0" style="border: revert;">
                                    </div>
                                </div>

                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h5>Small Scale Industry</h5>
                                    </div>
                                    <div class="card-body address-card">
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-4">
                                                <label>Year:</label>
                                                <input type="number" name="branch[small_scale][year]" class="form-control">
                                            </div>

                                            <div class="col-sm-4 col-lg-4">
                                                <label>Registration No.</label>
                                                <input type="text" name="branch[small_scale][registration_no]" class="form-control">
                                            </div>

                                            <div class="col-sm-4 col-lg-4">
                                                <label class="form-label">Upload File</label>
                                                <div class="custom-file">
                                                    <input name="branch[small_scale][certificate]" type="file" accept=".pdf" class="custom-file-input">
                                                    <label class="custom-file-label">Choose File</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card card-primary card-outline">
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-sm-12 col-lg-4">
                                                <label>Year of Registration:</label>
                                                <input name="branch[vendor][year]" type="number" class="form-control">
                                            </div>

                                            <div class="col-sm-12 col-lg-4">
                                                <label>Registration No.</label>
                                                <input name="branch[vendor][registration_no]" type="text" class="form-control">
                                            </div>

                                            <div class="col-sm-12 col-lg-4">
                                                <label class="form-label">Registration Certificate</label>
                                                <div class="custom-file">
                                                    <input name="branch[vendor][certificate]" type="file" accept=".pdf" class="custom-file-input">
                                                    <label class="custom-file-label">Choose File</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="custom-tabs-four-productionfaculty" role="tabpanel" aria-labelledby="tab_productionfaculty" style="background-color: white;">
                                <h5>
                                    Facility Details
                                </h5>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 col-lg-4 mb-5">
                                        <label>Laboratory facilities available:</label><br>
                                        <input type="radio" name="production_facility[laboratory][a]" value="yes" class="showme" data-trigger="yes" data-show="lab_facilities">
                                        <label>Yes</label>&nbsp; &nbsp; &nbsp; &nbsp;
                                        <input type="radio" name="production_facility[laboratory][a]" value="no" class="showme" data-trigger="yes" data-show="lab_facilities">
                                        <label>No</label><br>
                                        <div id="lab_facilities" style="display: none;">
                                            <div class="text-container" id="lab_facilities_text">
                                                <div class="custom-file">
                                                    <input name="production_facility[laboratory][f]" type="file" accept=".pdf" class="custom-file-input">
                                                    <label class="custom-file-label">Choose File</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-4 col-lg-4 mb-5">
                                        <label>Whether there is any isi registration :</label><br>
                                        <input type="radio" name="production_facility[isi_registration][a]" value="yes" class="showme" data-trigger="yes" data-show="isi_registration">
                                        <label>Yes</label>&nbsp; &nbsp; &nbsp; &nbsp;
                                        <input type="radio" name="production_facility[isi_registration][a]" value="no" class="showme" data-trigger="yes" data-show="isi_registration">
                                        <label>No</label>
                                        <div id="isi_registration" style="display: none;">
                                            <div class="text-container" id="isi_registration-text">
                                                <div class="custom-file">
                                                    <input name="production_facility[isi_registration][f]" type="file" accept=".pdf" class="custom-file-input">
                                                    <label class="custom-file-label">Choose File</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-4 col-lg-4 mb-5">
                                        <label>Test facilities available</label><br>
                                        <input type="radio" name="production_facility[test_facility][a]" value="yes" class="showme" data-trigger="yes" data-show="test_facilities">
                                        <label>Yes</label>&nbsp; &nbsp; &nbsp; &nbsp;
                                        <input type="radio" name="production_facility[test_facility][a]" value="no" class="showme" data-trigger="yes" data-show="test_facilities">
                                        <label>No</label>
                                        <div id="test_facilities" style="display: none;">
                                            <div class="text-container" id="test_facilities-info">
                                                <div class="custom-file">
                                                    <input name="production_facility[test_facility][f]" type="file" accept=".pdf" class="custom-file-input">
                                                    <label class="custom-file-label">Choose File</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-4 col-lg-4 mb-5">
                                        <label>Facilities for effective after sales services</label><br>
                                        <input type="radio" name="production_facility[sales_services][a]" value="yes" class="showme" data-trigger="yes" data-show="sales_services">
                                        <label>Yes</label>&nbsp; &nbsp; &nbsp; &nbsp;
                                        <input type="radio" name="production_facility[sales_services][a]" value="no" class="showme" data-trigger="yes" data-show="sales_services">
                                        <label>No</label>
                                        <div id="sales_services" style="display: none;">
                                            <div class="text-container" id="sales_services_text">
                                                <div class="custom-file">
                                                    <input name="production_facility[sales_services][f]" type="file" accept=".pdf" class="custom-file-input">
                                                    <label class="custom-file-label">Choose File</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-4 col-lg-4 mb-5">
                                        <label>Quality control procedure adopted.</label><br>
                                        <input type="radio" name="production_facility[quality_control][a]" value="yes" class="showme" data-trigger="yes" data-show="quality_control">
                                        <label>Yes</label>&nbsp; &nbsp; &nbsp; &nbsp;
                                        <input type="radio" name="production_facility[quality_control][a]" value="no" class="showme" data-trigger="yes" data-show="quality_control">
                                        <label>No</label>
                                        <div id="quality_control" style="display: none;">
                                            <div class="text-container" id="quality-control_text">
                                                <div class="custom-file">
                                                    <input name="production_facility[quality_control][f]" type="file" accept=".pdf" class="custom-file-input">
                                                    <label class="custom-file-label">Choose File</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <label>Annual turn over in last 3 years (In Rupee):</label>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <input type="hidden" name="annual_turnover[0][q]" class="year1">
                                        <input type="number" class="form-control placeholder1" name="annual_turnover[0][a]">
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <input type="hidden" name="annual_turnover[1][q]" class="year2">
                                        <input type="number" class="form-control placeholder2" name="annual_turnover[1][a]">
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <input type="hidden" name="annual_turnover[2][q]" class="year3">
                                        <input type="number" class="form-control placeholder3" name="annual_turnover[2][a]">
                                    </div>
                                </div>
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        Income tax cleaning certificate
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <label>Certificate No</label>
                                                <input type="number" name="income_tax[registration_no]" class="form-control">
                                            </div>
                                            <div class="col-lg-3">
                                                <label>Date</label>
                                                <input type="date" id="datePickerId" name="income_tax[year]" class="form-control">
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="form-label">Documents</label>
                                                <div class="custom-file">
                                                    <input name="income_tax[certificate]" type="file" accept=".pdf" class="custom-file-input">
                                                    <label class="custom-file-label">Choose File</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="form-label">Latest Copy of Balance Sheet</label>
                                                <div class="custom-file">
                                                    <input name="balance_sheet" type="file" accept=".pdf" class="custom-file-input">
                                                    <label class="custom-file-label">Choose File</label>
                                                </div>
                                                <!-- <a href="/bsms/webroot/templates/stock_upload.xlsx"
                                                    download="">sample_file_template</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        Factory Address
                                        <span class="badge lgreenbadge float-right add" id="id_factory_office_add" data-toggle="tooltip" data-class="factory_office" data-id="0" data-placement="right" title="Add Address">
                                            <i class="fas fa-plus-circle"></i>
                                        </span>
                                    </div>
                                    <div class="card-body factory_office_card_body">
                                        <div class="row factory_office factory_office_0" data-id="0" id="factory_office_0">
                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('register_office_address1', ['name' => 'prdflt[factory_office][0][address1]', 'id' => 'factory_0_address1', 'class' => 'form-control', 'label' => "Address 1"]); ?>
                                                </div>
                                            </div>
                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('register_office_address2', ['name' => 'prdflt[factory_office][0][address2]', 'id' => 'factory_0_address2', 'label' => 'Address 2', 'class' => 'form-control']); ?>
                                                </div>
                                            </div>
                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('register_office_pincode', ['type' => 'number', 'name' => 'prdflt[factory_office][0][pincode]', 'label' => 'Pincode', 'class' => 'form-control maxlength_validation', 'id' => 'factory_0_pincode', 'maxlength' => '6']); ?>
                                                </div>
                                            </div>
                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('register_office_city', ['type' => 'text', 'name' => 'prdflt[factory_office][0][city]', 'class' => 'form-control alphaonly capitalize', 'label' => 'City', 'id' => 'factory_0_city']); ?>
                                                </div>
                                            </div>
                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('register_office_country', ['name' => 'prdflt[factory_office][0][country]', 'class' => 'selectpicker form-control my-select', 'options' => $countries, 'label' => 'Country', 'data-live-search' => 'true', 'title' => 'Select Country', 'id' => 'factory_0_country']); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-3 mt-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('register_office_state', ['name' => 'prdflt[factory_office][0][state]', 'class' => 'selectpicker form-control my-select', 'options' => $states, 'label' => 'State', 'data-live-search' => 'true', 'title' => 'Select State', 'id' => 'factory_0_state']); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-3 mt-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('register_office_telno', ['name' => 'prdflt[factory_office][0][telno]', 'type' => 'number', 'class' => 'form-control maxlength_validation', 'id' => 'factory_0_telno', 'label' => 'Tel No', 'maxlength' => '10']); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-3 mt-4 pt-4 hide">
                                                <span class="badge redbadge delete" data-toggle="tooltip" data-id="0" data-placement="right" data-class="factory_office" data-original-title="Delete Address">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-6 mt-4">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                                        <label class="text-info">Installed Capacity</label>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <input type="text" class="form-control" name="prdflt[factory_office][0][installed_capacity][a]" placeholder="Installed Capacity" id="">
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="custom-file">
                                                            <input name="prdflt[factory_office][0][installed_capacity][f]" type="file" accept=".pdf" class="custom-file-input">
                                                            <label class="custom-file-label">Choose
                                                                File</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-6 mt-4">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                                        <label class="text-info">Power Available</label>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <input type="text" class="form-control" name="prdflt[factory_office][0][power_available][a]" placeholder="Power Available" id="">
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="custom-file">
                                                            <input name="prdflt[factory_office][0][power_available][f]" type="file" accept=".pdf" class="custom-file-input">
                                                            <label class="custom-file-label">Choose
                                                                File</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-6 mt-4">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                                        <label class="text-info">Machinery Available</label>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <input type="text" class="form-control" name="prdflt[factory_office][0][machinery_available][a]" placeholder="Machinery Available" id="">
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="custom-file">
                                                            <input name="prdflt[factory_office][0][machinery_available][f]" type="file" accept=".pdf" class="custom-file-input">
                                                            <label class="custom-file-label">Choose
                                                                File</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-6 mt-4">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                                        <label class="text-info">Raw Material Avi. and Source</label>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <input type="text" class="form-control" name="prdflt[factory_office][0][raw_material][a]" placeholder="Raw Material Avi. and Source" id="">
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="custom-file">
                                                            <input name="prdflt[factory_office][0][raw_material][f]" type="file" accept=".pdf" class="custom-file-input">
                                                            <label class="custom-file-label">Choose
                                                                File</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-12 mt-4">
                                                <div class="card card-primary card-outline">
                                                    <div class="card-header">
                                                        <div class="row">
                                                            <div class="col-10">
                                                                <h5>Actual production during preceding 3 years</h5>
                                                            </div>
                                                            <div class="col-2">
                                                                <span class="badge lgreenbadge add float-right" data-toggle="tooltip" data-class="commencement" data-placement="right" id="id_commencement_add" title="" data-original-title="Add Commencement">
                                                                    <i class="fas fa-plus-circle"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body commencement_card_body">
                                                        <div class="row mb-3 commencement commencement_0" data-id="0" id="commencement_0">
                                                            <div class="col-sm-12 col-md-3 col-lg-3">
                                                                <label for="">Year Of Commencement Of Production</label>
                                                                <input type="number" class="form-control" name="prdflt[factory_office][0][commencement][0][year]" id="factory_0">
                                                            </div>
                                                            <div class="col-sm-12 col-md-2 col-lg-2">
                                                                <label for="">Material</label>
                                                                <input type="text" class="form-control" name="prdflt[factory_office][0][commencement][0][material]" id="" placeholder="Material">
                                                            </div>
                                                            <div class="col-sm-12 col-md-2 col-lg-2">
                                                                <label id="productionyear1">2020-2021</label>
                                                                <input type="hidden" class="year1" name="prdflt[factory_office][0][commencement][0][production][0][year]" id="">
                                                                <input type="number" class="form-control placeholder1" name="prdflt[factory_office][0][commencement][0][production][0][qty]" id="factory_0">
                                                            </div>
                                                            <div class="col-sm-12 col-md-2 col-lg-2">
                                                                <label id="productionyear2">2021-2022</label>
                                                                <input type="hidden" class="year2" name="prdflt[factory_office][0][commencement][0][production][1][year]" id="">
                                                                <input type="number" class="form-control placeholder2" name="prdflt[factory_office][0][commencement][0][production][1][qty]" id="">
                                                            </div>
                                                            <div class="col-sm-12 col-md-2 col-lg-2">
                                                                <label id="productionyear3">2022-2023</label>
                                                                <input type="hidden" class="year3" name="prdflt[factory_office][0][commencement][0][production][2][year]" id="">
                                                                <input type="number" class="form-control placeholder3" name="prdflt[factory_office][0][commencement][0][production][2][qty]" id="">
                                                            </div>
                                                            <div class="col-sm-12 col-md-1 col-lg-1 mt-3 pt-3 hide">
                                                                <span class="badge redbadge delete" data-toggle="tooltip" data-id="0" data-placement="right" data-class="commencement" data-original-title="Delete Address">
                                                                    <i class="fas fa-trash"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <hr class="commencement_0" style="border: revert;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="factory_office_0" style="border: revert;">
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="custom-tabs-four-contactperson" role="tabpanel" aria-labelledby="tab_contactperson" style="background-color: white;">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 col-lg-4 mt-1">
                                        <div class="form-group">
                                            <?php echo $this->Form->control('contact_person', ['name' => 'contact_person[name]', 'class' => 'form-control capitalize alphaonly', 'label' => 'Name']); ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-4 col-lg-4 mt-1">
                                        <div class="form-group">
                                            <?php echo $this->Form->control('contact_email', ['type' => 'email', 'name' => 'contact_person[email]', 'class' => 'form-control', 'label' => 'Email']); ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-4 col-lg-4 mt-1">
                                        <div class="form-group">
                                            <?php echo $this->Form->control('contact_mobile', ['type' => 'number', 'name' => 'contact_person[mobile]', 'class' => 'form-control maxlength_validation', 'label' => 'Mobile', 'maxlength' => '10']); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4 mt-1">
                                        <div class="form-group">
                                            <?php echo $this->Form->control('contact_department', ['name' => 'contact_person[department]', 'class' => 'form-control capitalize alphaafternumberonly', 'label' => 'Department']); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4 mt-1">
                                        <div class="form-group">
                                            <?php echo $this->Form->control('contact_designation', ['name' => 'contact_person[designation]', 'class' => 'form-control capitalize alphaafternumberonly', 'label' => 'Designation']); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        Address of Proprietor / Partner / Director
                                        <span data-class="other_address" class="badge lgreenbadge mt-2 add" id="id_other_address_add" data-toggle="tooltip" data-placement="right" title="" data-original-title="Add Proprietor / Partner / Director">
                                            <i class="fas fa-plus-circle"></i>
                                        </span>
                                    </div>
                                    <div class="card-body other_address_card_body">
                                        <div class="row other_address other_address_0" data-id="0" id="other_address_0">
                                            <div class="col-2 mt-1">
                                                <input type="radio" name="contact_person[other_address][0][type]" value="Proprietor">
                                                <label>Proprietor</label>
                                            </div>
                                            <div class="col-2 mt-1">
                                                <input type="radio" name="contact_person[other_address][0][type]" value="Partner">
                                                <label>Partner</label>
                                            </div>
                                            <div class="col-2 mt-1">
                                                <input type="radio" name="contact_person[other_address][0][type]" checked value="Director">
                                                <label>Director</label>
                                            </div>

                                            <div class="col-3 col-md-3 hide">
                                                <span class="badge redbadge delete" data-toggle="tooltip" data-id="0" data-class="other_address" data-placement="right" data-original-title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                            </div>

                                            <div class="col-12 mt-1">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('contact_person[other_address][0][name]', ['class' => 'form-control form-control-sm alphaonly capitalize', 'label' => "Name"]); ?>
                                                </div>
                                            </div>

                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('contact_person[other_address][0][address]', ['class' => 'form-control', 'id' => 'id_address1', 'label' => "Address 1"]); ?>
                                                </div>
                                            </div>
                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('contact_person[other_address][0][address_2]', ['label' => 'Address 2', 'id' => 'id_address2', 'class' => 'form-control']); ?>
                                                </div>
                                            </div>
                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('contact_person[other_address][0][pincode]', ['type' => 'number', 'class' => 'form-control maxlength_validation', 'id' => 'id_pincode', 'label' => 'Pincode', 'maxlength' => '6']); ?>
                                                </div>
                                            </div>

                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('contact_person[other_address][0][city]', ['class' => 'form-control alphaonly capitalize', 'id' => 'id_city', 'label' => 'City']); ?>
                                                </div>
                                            </div>

                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('contact_person[other_address][0][country]', ['id' => 'id_country', 'class' => 'selectpicker form-control my-select ', 'options' => $countries, 'data-live-search' => 'true', 'title' => 'Please select', 'label' => 'Country', '    empty' => '']); ?>
                                                </div>
                                            </div>

                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('contact_person[other_address][0][state]', ['id' => 'id_state', 'class' => 'selectpicker form-control my-select', 'options' => $states, 'data-live-search' => 'true', 'title' => 'Select State', 'label' => 'State']); ?>
                                                </div>
                                            </div>
                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('contact_person[other_address][0][telephone]', ['id' => 'id_telephone', 'type' => 'number', 'class' => 'form-control maxlength_validation', 'label' => 'Telephone', 'maxlength' => '10']); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-3 mt-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('contact_person[other_address][0][faxno]', ['id' => 'id_faxno', 'type' => 'number', 'class' => 'form-control maxlength_validation', 'label' => 'Fax No.', 'maxlength' => '10']); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="other_address_0" style="border: revert;">
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="tab_paymentdetails" style="background-color: white;">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        Bank Details
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-3 mb-3">
                                                <label for="id_bank_name">Bank name</label>
                                                <input type="text" name="bank[name]" class="form-control alphaonly capitalize" id="id_bank_name">
                                            </div>

                                            <div class="col-3 mb-3">
                                                <label for="id_bank_branch">Bank Branch</label>
                                                <input type="text" class="form-control alphaonly capitalize" id="id_bank_branch" name="bank[branch]">
                                            </div>

                                            <div class="col-3 mb-3">
                                                <label for="id_bank_no">Bank number</label>
                                                <input type="number" maxlength="18" class="form-control maxlength_validation" id="id_bank_no" name="bank[number]">
                                            </div>

                                            <div class="col-3 mb-3">
                                                <label for="id_bank_ifsc">IFSC Code</label>
                                                <input type="text" maxlength="11" name="bank[ifsc_code]" class="form-control maxlength_validation UpperCase" id="id_bank_ifsc">
                                            </div>

                                            <div class="col-3 mb-3">
                                                <label for="id_bank_key">Bank Key</label>
                                                <input type="text" maxlength="11" name="bank[key]" class="form-control" id="id_bank_key">
                                            </div>


                                            <div class="col-3 mb-3">
                                                <?php echo $this->Form->control('bank_country', ['name' => 'bank[country]', 'id' => 'id_bank_country', 'class' => 'selectpicker form-control my-select ', 'options' => $countries, 'data-live-search' => 'true', 'title' => 'Select Country']); ?>
                                            </div>

                                            <div class="col-3 mb-3">
                                                <label for="id_bank_city">City</label>
                                                <input type="text" class="form-control capitalize" id="id_bank_city" name="bank[city]">
                                            </div>

                                            <div class="col-3 mb-3">
                                                <?php echo $this->Form->control('order_currency', ['name' => 'bank[order_currency]', 'readonly' => 'readonly', 'class' => 'form-control']); ?>
                                            </div>

                                            <div class="col-3 mb-3">
                                                <label for="id_swift_bic">SWIFT/BIC</label>
                                                <input type="text" class="form-control" id="id_swift_bic" name="bank[swift]">
                                            </div>

                                            <div class="col-3 mb-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('tan_no', ['name' => 'bank[tan_no]', 'class' => 'form-control UpperCase', 'label' => 'TAN No']); ?>
                                                </div>
                                            </div>

                                            <div class="col-3 mb-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('cin_no', ['name' => 'bank[cin_no]', 'class' => 'form-control UpperCase', 'label' => 'CIN No.']); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-4 mt-3">
                                        <div class="card card-primary card-outline">
                                            <div class="card-body p-2">
                                                <label for="">GST No</label>
                                                <input type="text" name="bank[other][gst][a]" class="form-control UpperCase" id='gst-no'>
                                            </div>
                                            <div class="card-footer p-2" style="background-color: whitesmoke;">
                                                <div class="custom-file">
                                                    <input name="bank[other][gst][f]" type="file" accept=".pdf" class="custom-file-input">
                                                    <label class="custom-file-label">Choose File</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 mt-3">
                                        <div class="card card-primary card-outline">
                                            <div class="card-body p-2">
                                                <label for="">PAN No</label>
                                                <input type="text" name="bank[other][pan][a]" class="form-control UpperCase" id="pan-no">
                                            </div>
                                            <div class="card-footer p-2" style="background-color: whitesmoke;">
                                                <div class="custom-file">
                                                    <input name="bank[other][pan][f]" type="file" accept=".pdf" class="custom-file-input">
                                                    <label class="custom-file-label">Choose File</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 mt-3">
                                        <div class="card card-primary card-outline">
                                            <div class="card-footer p-2" style="background-color: whitesmoke;">
                                                <label for="">Cancelled Cheque</label>
                                                <div class="custom-file">
                                                    <input type="hidden" name="bank[other][cancelled_cheque][a]">
                                                    <input name="bank[other][cancelled_cheque][f]" type="file" accept=".pdf,image/jpeg, image/png" class="custom-file-input">
                                                    <label class="custom-file-label">Choose File</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="custom-tabs-four-certificate" role="tabpanel" aria-labelledby="tab_certificate" style="background-color: white;">
                                <div class="row">
                                    <div class="col-sm-12 col-md-3 col-lg-3 mt-3">
                                        <div class="form-group">
                                            <label for="id_sigma">Six Sigma</label>
                                            <textarea id="id_sigma" name="certificate[six_sigma][a]" cols="30" rows="1" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 mt-3">
                                        <label class="form-label">Upload File</label>
                                        <div class="custom-file">
                                            <input name="certificate[six_sigma][f]" type="file" accept=".pdf" class="custom-file-input">
                                            <label class="custom-file-label">Choose File</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 mt-3">
                                        <label>Registration No.</label>
                                        <input type="number" class="form-control" name="certificate[registration_no][a]">
                                    </div>

                                    <div class="col-sm-12 col-md-3 col-lg-3 mt-3">
                                        <label class="form-label">ISO Registration / Certificate</label>
                                        <div class="custom-file">
                                            <input name="certificate[registration_no][f]" type="file" accept=".pdf" class="custom-file-input">
                                            <label class="custom-file-label">Choose File</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        HALAL Registration / certificate
                                    </div>
                                    <div class="card-body p-2">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-6 mt-3" style="border-right: 1px solid #dee2e6;">
                                                <label class="form-label">Certificate File</label>
                                                <div class="custom-file">
                                                    <input name="halal[certificate]" type="file" accept=".pdf" class="custom-file-input">
                                                    <label class="custom-file-label">Choose File</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6 mt-3">
                                                <label class="form-label">Declaration</label>
                                                <div class="custom-file">
                                                    <input name="halal[declaration]" type="file" accept=".pdf" class="custom-file-input">
                                                    <label class="custom-file-label">Choose File</label>
                                                </div>
                                                <i class="mt-2" style="color: black;">
                                                    <a href="/bsms/webroot/templates/stock_upload.xlsx" download="">sample_file_template</a>
                                                </i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h5>Other Quality Certification</h5>
                                    <label>Whether the item is completely manufactured in applicant's
                                        factory?</label>
                                    <div class="col-lg-12 mt-3">
                                        <input class="fully_manufactured_radio" type="radio" name="fully_manufactured[a]" value="yes">
                                        <label>Yes</label>
                                        <input class="fully_manufactured_radio ml-5" type="radio" name="fully_manufactured[a]" value="no">
                                        <label>No</label>
                                    </div>

                                    <div class="col-6 mt-1">
                                        <div class="sub-contractors-info" style="display: none;">
                                            <div class="form-group">
                                                <?php echo $this->Form->control('sub-contractor', ['id' => 'other_manufacturer', 'name' => 'fully_manufactured[f]', 'class' => 'form-control', 'label' => 'Suppliers Name']); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="custom-tabs-four-questionnaire" role="tabpanel" aria-labelledby="tab_questionnaire" style="background-color: white;">
                                <h5>Other information considered relevent to be furnished by supplier</h5>
                                <div class="row">
                                    <div class="col-lg-12 mt-3">
                                        <label>Does the company have any policy wrt to child labour appoint in
                                            work
                                            place</label>
                                        <input type="hidden" name="questionnaire[0][q]" value="Does the company have any policy wrt to child labour appoint in work place">
                                        <textarea placeholder="" name="questionnaire[0][a]" class="form-control" cols="30" rows="3"></textarea>
                                    </div>
                                    <div class="col-lg-12 mt-3">
                                        <label>Does your company follow any anit - corruption policy (zero
                                            corruption )
                                            &
                                            has follow ethical code of code / corporate social
                                            responsibilities:-</label>
                                        <input type="hidden" name="questionnaire[1][q]" value="Does your company follow any anit - corruption policy (zero corruption ) & has follow ethical code of code / corporate social responsibilities">
                                        <textarea placeholder="" name="questionnaire[1][a]" class="form-control" cols="30" rows="3"></textarea>
                                    </div>
                                    <div class="col-lg-12 mt-3">
                                        <label>Does the company have policy & decimate between sexual worker wrt
                                            cast,
                                            gender, religion and harassment at work place</label>
                                        <input type="hidden" name="questionnaire[2][q]" value="Does the company have policy & decimate between sexual worker wrt cast, gender, religion and harassment at work place">
                                        <textarea placeholder="" name="questionnaire[2][a]" class="form-control" cols="30" rows="3"></textarea>
                                    </div>
                                    <div class="col-lg-12 my-3">
                                        <label>Does the company use any product in the manufacturing of material
                                            through
                                            recycled material :-</label>
                                        <input type="hidden" name="questionnaire[3][q]" value="Does the company use any product in the manufacturing of material through recycled material">
                                        <textarea placeholder="" name="questionnaire[3][a]" class="form-control" cols="30" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="custom-tabs-four-customerAddress" role="tabpanel" aria-labelledby="tab_customerAddress" style="background-color: white;">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h5 class="modal-title" style="text-transform: lowercase;">
                                            Address of your reputed customers to whom reference can be made (use separate sheet) if necessary
                                            <span data-class="customer" class="badge lgreenbadge mt-2 add" id="id_customer_add" data-toggle="tooltip" data-placement="right" title="Add Reputed Customer">
                                                <i class="fas fa-plus-circle"></i>
                                            </span>
                                        </h5>
                                    </div>
                                    <div class="card-body customer_card_body">
                                        <div class="row customer customer_0" data-id="0" id="customer_0">
                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('reputed[customer][0][name]', ['class' => 'form-control alphaonly capitalize', 'id' => 'id_name', 'label' => "Customer Name"]); ?>
                                                </div>
                                            </div>
                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('reputed[customer][0][address]', ['label' => 'Address', 'class' => 'form-control']); ?>
                                                </div>
                                            </div>
                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('reputed[customer][0][pincode]', ['type' => 'number', 'class' => 'form-control maxlength_validation', 'id' => 'reputed_pincode', 'label' => 'Pincode', 'maxlength' => '6']); ?>
                                                </div>
                                            </div>

                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('reputed[customer][0][city]', ['class' => 'form-control alphaonly capitalize', 'id' => '', 'label' => 'City']); ?>
                                                </div>
                                            </div>

                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('reputed[customer][0][country]', ['class' => 'selectpicker form-control my-select ', 'options' => $countries, 'data-live-search' => 'true', 'title' => 'Select Country', 'label' => 'Country']); ?>
                                                </div>
                                            </div>

                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('reputed[customer][0][state]', ['name' => 'reputed[customer][0][state]', 'id' => '', 'class' => 'selectpicker form-control my-select', 'options' => $states, 'data-live-search' => 'true', 'title' => 'Select State', 'label' => 'State']); ?>
                                                </div>
                                            </div>
                                            <div class="col-3 mt-3 col-md-3">
                                                <div class="form-group">
                                                    <label for="id_telephone">Telephone</label>
                                                    <input type="number" id="reputed_telephone" name="reputed[customer][0][telephone]" class="form-control maxlength_validation" maxlength="10">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-3 mt-3">
                                                <div class="form-group">
                                                    <?php echo $this->Form->control('register_office_faxno', ['name' => 'reputed[customer][0][faxno]', 'id' => 'reputed_faxno', 'type' => 'number', 'class' => 'form-control maxlength_validation', 'label' => 'Fax No.', 'maxlength' => '10']); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-1 mt-4 pt-4 hide">
                                                <span class="badge redbadge delete" data-toggle="tooltip" data-id="0" data-class="customer" data-placement="right" data-original-title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <hr class="customer_0" style="border: revert;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-3" style="background-color: whitesmoke;">
                        <?php echo $this->Form->button('Submit', array('class' => 'btn bg-gradient-submit mb-0', 'type' => 'submit', 'id' => 'id_fksubmit')); ?>
                    </div>
                </div>
                <div class="modal fade" id="modal-sm" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                                <h6>Are you sure you want to proceed? This action cannot be edit.</h6>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn cancelButton" style="border:1px solid #6610f2" data-dismiss="modal">Cancel</button>
                                <?php echo $this->Form->button('Ok', array('class' => 'btn mt-3', 'style' => "border:1px solid #28a745", 'id' => 'id_ogsubmit')); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
<script>
    var vendorLink = '<?php echo \Cake\Routing\Router::url(array('controller' => '/VendorTemps', 'action' => 'state-by-countryId')); ?>';
</script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script> -->
<?= $this->Html->script('v_vendortemps_edit') ?>