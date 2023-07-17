<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Productionline> $productionline
 */
?>
<?= $this->Html->css('cstyle.css') ?>
<?= $this->Html->css('custom') ?>
<?= $this->Html->css('table.css') ?>
<?= $this->Html->css('listing.css') ?>
<?= $this->Html->css('v_index.css') ?>
<div class="card">
    <div class="card-header pb-1 pt-2">
        <div class="row">
            <div class="col-lg-6 d-flex justify-content-start">
                <h5>Production Line</h5>
            </div>
            <div class="col-lg-6 d-flex justify-content-end text-align-end">
                <a href="<?= $this->Url->build('/') ?>vendor/productionline/add"><button type="button" id="continueSub" class="btn mb-0 continue_btn btn-dark">Add Producation</button></a>
            </div>
        </div>
    </div>

    <div class="card-header p-0 mb-0 mt-3 ml-3 mr-3" id="id_pohead">
        <table class="table table-hover" id="example1">
            <thead>
                <tr>
                    <th>Production Line</th>
                    <th>Material Code</th>
                    <th>Material Description</th>
                    <th>UOM</th>
                    <th>Production Line Capacity</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($productionline)) : ?>
                    <?php foreach ($productionline as $productionlines) : ?>
                        <tr class="redirect" data-href="<?= $this->Url->build('/') ?>vendor/productionline/edit/<?= $productionlines->id ?>">
                            <td>
                                <?= h($productionlines->prdline_description) ?>
                            </td>
                            <td>
                                <?= h($productionlines->vm_vendor_code) ?>
                            </td>
                            <td>
                                <?= h($productionlines->vm_description) ?>
                            </td>
                            <td>
                                <?= h($productionlines->uom_desp) ?>
                            </td>
                            <td>
                                <?= h($productionlines->prdline_capacity) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6">
                            No Records Found
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('.success').fadeOut('slow');
        }, 2000);

        $(document).on("click", ".redirect", function() {
            window.location.href = $(this).data("href");
        });

        var table = $("#example1").DataTable({
            "paging": true,
            "responsive": false,
            "lengthChange": false,
            "autoWidth": false,
            "searching": false,
            "ordering": false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search..."
            },
        });
    });
</script>