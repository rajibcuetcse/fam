<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FriendInvitationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FriendInvitationsTable Test Case
 */
class FriendInvitationsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.friend_invitations',
        'app.users',
        'app.api_tokens',
        'app.collections',
        'app.content_comment_likes',
        'app.content_comment_reports',
        'app.content_comments',
        'app.content_comments_copy',
        'app.content_likes',
        'app.log_events',
        'app.payment_receipts',
        'app.transactions',
        'app.products',
        'app.price_codes',
        'app.payment_receipt_logs',
        'app.star_activities',
        'app.artists',
        'app.token_transactions',
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
        'app.content_medias',
        'app.unlocking_activities',
        'app.unlocking_ability_change_histories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('FriendInvitations') ? [] : ['className' => 'App\Model\Table\FriendInvitationsTable'];
        $this->FriendInvitations = TableRegistry::get('FriendInvitations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FriendInvitations);

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
