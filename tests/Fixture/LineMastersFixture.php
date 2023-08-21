<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LineMastersFixture
 */
class LineMastersFixture extends TestFixture
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
                'sap_vendor_code' => 'Lorem ip',
                'vendor_factory_id' => 1,
                'name' => 'Lorem ipsum dolor ',
                'capacity' => 1.5,
                'uom' => 'L',
                'status' => 1,
                'added_date' => '2023-08-21 13:10:32',
                'updated_date' => '2023-08-21 13:10:32',
            ],
        ];
        parent::init();
    }
}
