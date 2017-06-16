<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PaymentReceiptsFixture
 *
 */
class PaymentReceiptsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'transaction_id' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'product_id' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'status' => ['type' => 'integer', 'length' => 2, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '0=pending,1=verified,2=rejected', 'precision' => null, 'autoIncrement' => null],
        'amount' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => ''],
        'currency' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null, 'fixed' => null],
        'platform' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null],
        'type' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '1=stars,2=tickets', 'precision' => null],
        'created_on' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'updated_on' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
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
            'transaction_id' => 'Lorem ipsum dolor sit amet',
            'user_id' => 1,
            'product_id' => 'Lorem ipsum dolor sit amet',
            'status' => 1,
            'amount' => 1,
            'currency' => 'Lorem ip',
            'platform' => 1,
            'type' => 1,
            'created_on' => 1451404970,
            'updated_on' => 1451404970
        ],
    ];
}
