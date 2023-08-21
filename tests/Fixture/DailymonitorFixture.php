<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DailymonitorFixture
 */
class DailymonitorFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'dailymonitor';
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
                'production_line_id' => 1,
                'material_id' => 1,
                'plan_date' => '2023-08-21',
                'target_production' => 1.5,
                'confirm_production' => 1.5,
                'status' => 1,
                'added_date' => '2023-08-21 15:20:13',
                'updated_date' => '2023-08-21 15:20:13',
            ],
        ];
        parent::init();
    }
}
