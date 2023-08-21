<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StockUploadsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StockUploadsTable Test Case
 */
class StockUploadsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\StockUploadsTable
     */
    protected $StockUploads;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.StockUploads',
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
        $config = $this->getTableLocator()->exists('StockUploads') ? [] : ['className' => StockUploadsTable::class];
        $this->StockUploads = $this->getTableLocator()->get('StockUploads', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->StockUploads);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\StockUploadsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\StockUploadsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
