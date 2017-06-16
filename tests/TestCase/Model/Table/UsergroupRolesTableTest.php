<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsergroupRolesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsergroupRolesTable Test Case
 */
class UsergroupRolesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.usergroup_roles',
        'app.roles',
        'app.companies',
        'app.cmsusers',
        'app.usergroups',
        'app.role_pages'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UsergroupRoles') ? [] : ['className' => 'App\Model\Table\UsergroupRolesTable'];
        $this->UsergroupRoles = TableRegistry::get('UsergroupRoles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UsergroupRoles);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
