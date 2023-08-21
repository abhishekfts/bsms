<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Dailymonitor Entity
 *
 * @property int $id
 * @property string $sap_vendor_code
 * @property int|null $production_line_id
 * @property int|null $material_id
 * @property \Cake\I18n\FrozenDate|null $plan_date
 * @property string $target_production
 * @property string|null $confirm_production
 * @property int|null $status
 * @property \Cake\I18n\FrozenTime|null $added_date
 * @property \Cake\I18n\FrozenTime|null $updated_date
 *
 * @property \App\Model\Entity\ProductionLine $production_line
 * @property \App\Model\Entity\Material $material
 */
class Dailymonitor extends Entity
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
        'production_line_id' => true,
        'material_id' => true,
        'plan_date' => true,
        'target_production' => true,
        'confirm_production' => true,
        'status' => true,
        'added_date' => true,
        'updated_date' => true,
        'production_line' => true,
        'material' => true,
    ];
}
