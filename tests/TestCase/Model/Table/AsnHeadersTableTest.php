<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AsnHeadersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AsnHeadersTable Test Case
 */
class AsnHeadersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AsnHeadersTable
     */
    protected $AsnHeaders;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.AsnHeaders',
        'app.VendorFactories',
        'app.PoHeaders',
        'app.AsnFooters',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('AsnHeaders') ? [] : ['className' => AsnHeadersTable::class];
        $this->AsnHeaders = $this->getTableLocator()->get('AsnHeaders', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AsnHeaders);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AsnHeadersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AsnHeadersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
