<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Rfq> $rfqs
 */
?>
<?= $this->Html->css('custom') ?>
<div class="rfqs index content card">
    
<!-- <div class="card-header">
        <h5>
            <b>
                RFQ LIST
            </b>
        </h5>
    </div> -->

    <div class="card-body p-2">
    <div class="table-responsive">
        <table class="table table-hover table-bordered mb-0" id="example1">
            <thead>
                <tr>
                    <th><?= h(_('RFQ No')) ?></th>
                    <th><?= h(_('Vendor')) ?></th>
                    <th><?= h(_('PR')) ?></th>
                    <th><?= h(_('Added Date')) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rfqs as $rfq): ?>
                    <tr redirect="<?= $this->Url->build('/') ?>buyer/rfqs/view/<?= $rfq->rfq_no ?>">
                    <td><?= $this->Number->format($rfq->rfq_no) ?></td>
                    <td><?= $rfq->has('vendor_temp') ? $rfq->vendor_temp->name : '' ?></td>
                    <td><?= $rfq->has('pr_header') ? $rfq->pr_header->pr_no : '' ?></td>
                    <td><?= h($rfq->added_date) ?></td>
                    <!-- <td class="actions">
                        
                    </td> -->
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
                </div>
</div>

<script>

    $(document).ready(function () {

        $('#example1').on('click', 'tbody tr', function(){
            window.location = $(this).closest('tr').attr('redirect');
        });

        $("#example1").DataTable({
            "responsive": {"details": {"type": none}},
            "paging": true,
            "responsive": false, "lengthChange": false, "autoWidth": false, "searching": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>
