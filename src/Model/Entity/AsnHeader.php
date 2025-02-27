<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AsnHeader Entity
 *
 * @property int $id
 * @property string $asn_no
 * @property int $po_header_id
 * @property array $invoice_path
 * @property string $invoice_no
 * @property \Cake\I18n\FrozenDate|null $invoice_date
 * @property string $invoice_value
 * @property string $vehicle_no
 * @property string $driver_name
 * @property string $driver_contact
 * @property \Cake\I18n\FrozenTime|null $gateout_date
 * @property int $status
 * @property \Cake\I18n\FrozenTime $added_date
 * @property \Cake\I18n\FrozenTime $updated_date
 *
 * @property \App\Model\Entity\PoHeader $po_header
 * @property \App\Model\Entity\AsnFooter[] $asn_footers
 */
class AsnHeader extends Entity
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
        'asn_no' => true,
        'po_header_id' => true,
        'invoice_path' => true,
        'invoice_no' => true,
        'invoice_date' => true,
        'invoice_value' => true,
        'vehicle_no' => true,
        'driver_name' => true,
        'driver_contact' => true,
        'gateout_date' => true,
        'status' => true,
        'added_date' => true,
        'updated_date' => true,
        'po_header' => true,
        'asn_footers' => true,
    ];
}
