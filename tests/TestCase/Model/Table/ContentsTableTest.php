<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContentsTable Test Case
 */
class ContentsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.contents',
        'app.cmsusers',
        'app.companies',
        'app.roles',
        'app.role_pages',
        'app.usergroups',
        'app.usergroup_roles',
        'app.cmsuser_usergroups',
        'app.collections',
        'app.content_artists',
        'app.content_categories',
        'app.content_comments',
        'app.content_comments_copy',
        'app.content_likes',
        'app.content_medias',
        'app.token_transactions',
        'app.unlocking_activities'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Contents') ? [] : ['className' => 'App\Model\Table\ContentsTable'];
        $this->Contents = TableRegistry::get('Contents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Contents);

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
