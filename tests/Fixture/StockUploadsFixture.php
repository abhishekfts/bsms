<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StockUploadsFixture
 */
class StockUploadsFixture extends TestFixture
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
                'factory_id' => 1,
                'material_id' => 1,
                'opening_stock' => 1.5,
                'current_stock' => 1.5,
                'asn_stock' => 1.5,
                'added_date' => '2023-08-20 21:42:22',
                'updated_date' => '2023-08-20 21:42:22',
            ],
        ];
        parent::init();
    }
}
