<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductSubCategory $productSubCategory
 * @var string[]|\Cake\Collection\CollectionInterface $products
 */
?>
  <?= $this->Html->css('cstyle.css') ?>
  <?= $this->Html->css('table.css') ?>
  <?= $this->Html->css('listing.css') ?>
  <?= $this->Html->css('b_index.css') ?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $productSubCategory->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $productSubCategory->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Product Sub Categories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="productSubCategories form content">
            <?= $this->Form->create($productSubCategory) ?>
            <fieldset>
                <legend><?= __('Edit Product Sub Category') ?></legend>
                <?php
                    echo $this->Form->control('product_id', ['options' => $products]);
                    echo $this->Form->control('name');
                    echo $this->Form->control('description');
                    echo $this->Form->control('status');
                    echo $this->Form->control('added_date');
                    echo $this->Form->control('updated_date');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
