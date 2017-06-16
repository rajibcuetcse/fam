<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TokenTransactionsFixture
 *
 */
class TokenTransactionsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'date' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => '0000-00-00 00:00:00', 'comment' => '', 'precision' => null],
        'transaction_type' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '1=earned,2=spent', 'precision' => null],
        'activity_type' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '1=friend invitation,2=convertion from ticket,3=login,4=save', 'precision' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'content_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'description' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'fixed' => null],
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
            'date' => 1452023129,
            'transaction_type' => 1,
            'activity_type' => 1,
            'user_id' => 1,
            'content_id' => 1,
            'description' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
