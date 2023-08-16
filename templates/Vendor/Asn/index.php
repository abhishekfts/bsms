<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DeliveryDetail[]|\Cake\Collection\CollectionInterface $deliveryDetails
 */
?>
<?= $this->Html->css('custom') ?>
<?= $this->Html->css('v_asn_index') ?>
<div class="row">
    <div class="col-12">
        <div class="deliveryDetails index content card">
            <div class="card-body">
                <table class="table table-hover" id="example1"
                    style="border-left: .5px solid lightgray;border-right: .5px solid lightgray; border-bottom: .5px solid lightgray;">
                    <thead>
                        <tr>
                            <th>ASN NO</th>
                            <th>Purchase Order</th>
                            <th>Invoice No</th>
                            <th>Invoice Date</th>
                            <th>States</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($deliveryDetails as $deliveryDetail): 
                             switch ($deliveryDetail->status) {
                                case 2:
                                    $status = '<a class="btn btn-light text-primary" style="border: 1px solid #FFD580;"><i class="fas fa-truck" data-toggle="tooltip" title="In Transit" data-widget="chat-pane-toggle"></i></a>';
                                    break;
                                case 3:
                                    $status = '<a class="btn btn-light text-success" style="border: 1px solid #FFD580;"><i class="fas fa-truck-loading" data-toggle="tooltip" title="Received" data-widget="chat-pane-toggle"></i></a>';
                                    break;
                                default:
                                    $status = '<a class="btn btn-light text-dark" style="border: 1px solid #;"><i class="far fa-clock" data-toggle="tooltip" title="Created" data-widget="chat-pane-toggle"></i></a>';
                                    break;
                        }?>
                        <tr class="redirect"
                            data-href="<?= $this->Url->build('/') ?>vendor/asn/view/<?= $deliveryDetail->id ?>">
                            <td>
                                <?=  $deliveryDetail->asn_no ?>
                            </td>
                            <td>
                                <?= $deliveryDetail->has('po_header') ? $deliveryDetail->po_header->po_no : '' ?>
                            </td>
                            <td>
                                <?= h($deliveryDetail->invoice_no) ?>
                            </td>
                            <td>
                                <?= h($deliveryDetail->invoice_date) ?>
                            </td>
                            <td>
                                <?= $status ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        setTimeout(function () { $('.success').fadeOut('slow'); }, 2000);

        $(document).on("click", ".redirect", function () { window.location.href = $(this).data("href"); });

        var table = $("#example1").DataTable({
            "paging": true,
            "responsive": false, "lengthChange": false, "autoWidth": false, "searching": true,
            "ordering": true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search..."
            },
        });
        $('input[type=search]').attr('class', 'search-bar');
    });

</script>