<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AsnHeadersFixture
 */
class AsnHeadersFixture extends TestFixture
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
                'vendor_factory_id' => 1,
                'po_header_id' => 1,
                'asn_no' => 'Lorem ipsum d',
                'invoice_path' => '',
                'invoice_no' => 'Lorem ipsum d',
                'invoice_date' => '2023-08-24',
                'invoice_value' => 1.5,
                'vehicle_no' => 'Lorem ipsu',
                'driver_name' => 'Lorem ipsum d',
                'driver_contact' => 'Lorem ipsum d',
                'status' => 1,
                'added_date' => '2023-08-24 15:18:27',
                'updated_date' => '2023-08-24 15:18:27',
                'gateout_date' => '2023-08-24 15:18:27',
            ],
        ];
        parent::init();
    }
}
