<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * VendorFactoriesFixture
 */
class VendorFactoriesFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'vendor_temp_id' => 1,
                'factory_code' => 'Lorem ipsum dolor sit amet',
                'address' => 'Lorem ipsum dolor sit amet',
                'address_2' => 'Lorem ipsum dolor sit amet',
                'pincode' => 'Lore',
                'city' => 'Lorem ipsum dolor sit amet',
                'state' => 1,
                'country' => 1,
                'installed_capacity' => 'Lorem ipsum dolor sit amet',
                'installed_capacity_file' => 'Lorem ipsum dolor sit amet',
                'machinery_available' => 'Lorem ipsum dolor sit amet',
                'machinery_available_file' => 'Lorem ipsum dolor sit amet',
                'power_available' => 'Lorem ipsum dolor sit amet',
                'power_available_file' => 'Lorem ipsum dolor sit amet',
                'raw_material' => 'Lorem ipsum dolor sit amet',
                'raw_material_file' => 'Lorem ipsum dolor sit amet',
                'added_date' => '2023-08-21 13:04:41',
                'updated_date' => '2023-08-21 13:04:41',
            ],
        ];
        parent::init();
    }
}
