<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LineMaster Entity
 *
 * @property int $id
 * @property string $sap_vendor_code
 * @property int|null $vendor_factory_id
 * @property string $name
 * @property string $capacity
 * @property string $uom
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $added_date
 * @property \Cake\I18n\FrozenTime $updated_date
 *
 * @property \App\Model\Entity\VendorFactory $vendor_factory
 * @property \App\Model\Entity\ProductionLine[] $production_lines
 */
class LineMaster extends Entity
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
        'vendor_factory_id' => true,
        'name' => true,
        'capacity' => true,
        'uom' => true,
        'status' => true,
        'added_date' => true,
        'updated_date' => true,
        'vendor_factory' => true,
        'production_lines' => true,
    ];
}
