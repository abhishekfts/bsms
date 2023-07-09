<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\VendorMaterial> $vendorMaterial
 */
?>
</style>
<?= $this->Html->css('custom') ?>
<div class="card">
    <div class="card-header pb-1 pt-2">
        <div class="row">
            <div class="col-lg-6 d-flex justify-content-start">
                <h5>Vendor Material</h5>
            </div>
            <div class="col-lg-6 d-flex justify-content-end text-align-end">
                <a href="<?= $this->Url->build('/') ?>vendor/vendor-material/add"><button type="button" id="continueSub" class="btn mb-0 continue_btn btn-dark">Add Material</button></a>
            </div>
        </div>
    </div>

    <div class="card-header p-0 mb-0 mt-3 ml-3 mr-3" id="id_pohead">
        <table class="table table-bordered material-list">
            <thead>
                <tr>
                    <th>Vendor Material Code</th>
                    <th>Material</th>
                    <th>Minimum Stock</th>
                    <th>Unit Of Measurement</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php if (isset($vendorMaterial)) : ?>
                <?php foreach ($vendorMaterial as $vendorMaterials) : ?>
                    <tr>
                        <td><?= h($vendorMaterials->vendor_material_code) ?></td>
                        <td><?= h($vendorMaterials->description) ?></td>
                        <td><?= h($vendorMaterials->minimum_stock) ?></td>
                        <td><?= h($vendorMaterials->uom) ?></td>
                        <td>
                            <div class="float-left">
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $vendorMaterials->id], ['class' => 'btn btn-info btn-sm mb-0']) ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="5">
                    No Records Found
                </td>
            </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>