<?php
namespace App\Test\TestCase\Controller;

use App\Controller\ProductsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\ProductsController Test Case
 */
class ProductsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.products',
        'app.price_codes',
        'app.payment_receipts',
        'app.transactions',
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
        'app.star_activities',
        'app.token_transactions',
        'app.unlocking_ability_change_histories',
        'app.unlocking_activities',
        'app.payment_receipt_logs'
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
