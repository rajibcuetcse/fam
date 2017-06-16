<?php
namespace App\Test\TestCase\Controller;

use App\Controller\CollectionsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\CollectionsController Test Case
 */
class CollectionsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.collections',
        'app.users',
        'app.api_tokens',
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
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
