<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StarActivitiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StarActivitiesTable Test Case
 */
class StarActivitiesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.star_activities',
        'app.users',
        'app.api_tokens',
        'app.collections',
        'app.content_comment_likes',
        'app.content_comment_reports',
        'app.content_comments',
        'app.content_comments_copy',
        'app.content_likes',
        'app.friend_invitations',
        'app.log_events',
        'app.payment_receipts',
        'app.transactions',
        'app.products',
        'app.payment_receipt_logs',
        'app.token_transactions',
        'app.unlocking_ability_change_histories',
        'app.unlocking_activities',
        'app.artists'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('StarActivities') ? [] : ['className' => 'App\Model\Table\StarActivitiesTable'];
        $this->StarActivities = TableRegistry::get('StarActivities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StarActivities);

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
