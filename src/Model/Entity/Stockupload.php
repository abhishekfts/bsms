<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StockUpload Entity
 *
 * @property int $id
 * @property string $sap_vendor_code
 * @property int|null $factory_id
 * @property int $material_id
 * @property string $opening_stock
 * @property string $current_stock
 * @property string $asn_stock
 * @property \Cake\I18n\FrozenTime|null $added_date
 * @property \Cake\I18n\FrozenTime|null $updated_date
 *
 * @property \App\Model\Entity\Material $material
 * @property \App\Model\Entity\Factory $factory
 */
class StockUpload extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'sap_vendor_code' => true,
        'factory_id' => true,
        'material_id' => true,
        'opening_stock' => true,
        'current_stock' => true,
        'asn_stock' => true,
        'added_date' => true,
        'updated_date' => true,
        'material' => true,
        'factory' => true,
    ];
}
