<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GlobalConfigurationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GlobalConfigurationsTable Test Case
 */
class GlobalConfigurationsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.global_configurations'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('GlobalConfigurations') ? [] : ['className' => 'App\Model\Table\GlobalConfigurationsTable'];
        $this->GlobalConfigurations = TableRegistry::get('GlobalConfigurations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->GlobalConfigurations);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
