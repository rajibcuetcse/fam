<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TokenTransactionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TokenTransactionsTable Test Case
 */
class TokenTransactionsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.token_transactions',
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
        'app.star_activities',
        'app.artists',
        'app.unlocking_ability_change_histories',
        'app.unlocking_activities',
        'app.contents',
        'app.cmsusers',
        'app.companies',
        'app.roles',
        'app.role_pages',
        'app.usergroups',
        'app.usergroup_roles',
        'app.cmsuser_usergroups',
        'app.content_artists',
        'app.content_categories',
        'app.content_medias'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('TokenTransactions') ? [] : ['className' => 'App\Model\Table\TokenTransactionsTable'];
        $this->TokenTransactions = TableRegistry::get('TokenTransactions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TokenTransactions);

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
