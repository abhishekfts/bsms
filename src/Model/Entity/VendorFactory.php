<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VendorFactory Entity
 *
 * @property int $id
 * @property int|null $vendor_temp_id
 * @property string $factory_code
 * @property string|null $address
 * @property string|null $address_2
 * @property string|null $pincode
 * @property string|null $city
 * @property int $state
 * @property int $country
 * @property string|null $installed_capacity
 * @property string|null $installed_capacity_file
 * @property string|null $machinery_available
 * @property string|null $machinery_available_file
 * @property string|null $power_available
 * @property string|null $power_available_file
 * @property string|null $raw_material
 * @property string|null $raw_material_file
 * @property \Cake\I18n\FrozenTime|null $added_date
 * @property \Cake\I18n\FrozenTime|null $updated_date
 *
 * @property \App\Model\Entity\VendorTemp $vendor_temp
 * @property \App\Model\Entity\VendorCommencement[] $vendor_commencements
 */
class VendorFactory extends Entity
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
        'vendor_temp_id' => true,
        'factory_code' => true,
        'address' => true,
        'address_2' => true,
        'pincode' => true,
        'city' => true,
        'state' => true,
        'country' => true,
        'installed_capacity' => true,
        'installed_capacity_file' => true,
        'machinery_available' => true,
        'machinery_available_file' => true,
        'power_available' => true,
        'power_available_file' => true,
        'raw_material' => true,
        'raw_material_file' => true,
        'added_date' => true,
        'updated_date' => true,
        'vendor_temp' => true,
        'line_masters' => true,
        'stock_uploads' => true,
        'vendor_commencements' => true,
    ];
}
