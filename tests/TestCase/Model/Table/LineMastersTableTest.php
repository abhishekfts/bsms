<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LineMastersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LineMastersTable Test Case
 */
class LineMastersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LineMastersTable
     */
    protected $LineMasters;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.LineMasters',
        'app.VendorFactories',
        'app.ProductionLines',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('LineMasters') ? [] : ['className' => LineMastersTable::class];
        $this->LineMasters = $this->getTableLocator()->get('LineMasters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LineMasters);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LineMastersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LineMastersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
