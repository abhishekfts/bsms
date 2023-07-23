<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\VendorMaterial> $vendorMaterial
 */
?>
<!-- <?= $this->Html->css('cstyle.css') ?> -->
<!-- <?= $this->Html->css('custom') ?> -->
<!-- <?= $this->Html->css('table.css') ?> -->
<!-- <?= $this->Html->css('listing.css') ?> -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-1 pt-2">
                <div class="row">
                    <div class="col-lg-6 d-flex justify-content-start">
                        <h5>Vendor Materials</h5>
                    </div>
                    <div class="col-lg-6 d-flex justify-content-end text-align-end">
                        <!-- <a href="<?= $this->Url->build('/') ?>vendor/materials/add"><button type="button" id="continueSub" class="btn mb-0 continue_btn btn-dark">Add Material</button></a> -->
                        <button type="button" id="reload_stocks" class="btn bg-gradient-button mb-0 continue_btn">Refresh min. Stk.</button>
                    </div>
                </div>
            </div>

            <div class="card-header p-0 mb-0 mt-3 ml-3 mr-3">
                <table class="table table-hover" id="example1">
                    <thead>
                        <tr>
                            <th>Material Code</th>
                            <th>Description</th>
                            <th>Minimum Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($vendorMaterial)) : ?>
                            <?php foreach ($vendorMaterial as $vendorMaterials) : ?>
                            <tr>
                                <td>
                                    <?= h($vendorMaterials->code) ?>
                                </td>
                                <td>
                                    <?= h($vendorMaterials->description) ?>
                                </td>
                                <td>
                                    <?= h($vendorMaterials->minimum_stock . " " . $vendorMaterials->uom) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
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
    </div>
</div>

<script>
    $(document).ready(function () {
        var table = $("#example1").DataTable({
            "paging": true,
            "responsive": false,
            "lengthChange": false,
            "autoWidth": false,
            "searching": false,
            "ordering": false,
            "destroy": true,
            "columns": [{
                    "data": "code"
                },
                {
                    "data": "description"
                },
                {
                    "data": "minimum_stock",
                    // "render": function(data, type, row) {
                    //     return data + " " + row.uom;
                    // }
                }
            ]
        });

        setTimeout(function () {
            $('.success').fadeOut('slow');
        }, 2000);

        $(document).on("click", ".redirect", function () {
            window.location.href = $(this).data("href");
        });



        $(document).on("click", "#reload_stocks", function () {
            $.ajax({
                type: "get",
                url: "<?php echo \Cake\Routing\Router::url(array('prefix' => false, 'controller' => 'api', 'action' => 'get-material-masters')); ?> ",

                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (response.status == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });

                        table.clear().rows.add(response.data).draw();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response.message
                        });
                    }

                }
            });
        });

    });
</script>