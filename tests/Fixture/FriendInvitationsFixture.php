<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FriendInvitationsFixture
 *
 */
class FriendInvitationsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'The user who sent the request', 'precision' => null, 'autoIncrement' => null],
        'date' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Date indicates when the invitation sent', 'precision' => null],
        'status' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => '0=just sent invitation,1=accepted,2=rejected', 'precision' => null],
        'invited_to' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => '0', 'comment' => 'Usually the identifier of the receiver. suppose email address', 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf16_unicode_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'user_id' => 1,
            'date' => 1452474513,
            'status' => 1,
            'invited_to' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
