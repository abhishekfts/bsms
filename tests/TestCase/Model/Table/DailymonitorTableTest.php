<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DailymonitorTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DailymonitorTable Test Case
 */
class DailymonitorTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DailymonitorTable
     */
    protected $Dailymonitor;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Dailymonitor',
        'app.ProductionLines',
        'app.Materials',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Dailymonitor') ? [] : ['className' => DailymonitorTable::class];
        $this->Dailymonitor = $this->getTableLocator()->get('Dailymonitor', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Dailymonitor);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DailymonitorTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DailymonitorTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
