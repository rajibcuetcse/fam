<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductsFixture
 *
 */
class ProductsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'product_id' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'comment' => 'For example: mobi.gcu.zeerow.100stars', 'precision' => null, 'fixed' => null],
        'product_category' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'comment' => 'For example: Non-Consumable', 'precision' => null, 'fixed' => null],
        'apple_id' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'comment' => 'For example: 1065861980', 'precision' => null, 'fixed' => null],
        'price_tier' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'comment' => 'For example: Tier 5, Tier 10, Tier 25 etc', 'precision' => null, 'fixed' => null],
        'reference_name' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'comment' => 'For example: 100 Stars,100 Tickets etc', 'precision' => null, 'fixed' => null],
        'reference_value' => ['type' => 'integer', 'length' => 6, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'type' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '1=tickets,2=stars', 'precision' => null],
        'price_code_id' => ['type' => 'integer', 'length' => 6, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '1A,2B,2C etc', 'precision' => null, 'autoIncrement' => null],
        'display_name' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => '0', 'comment' => '100 Tickets, 200 Stars etc', 'precision' => null, 'fixed' => null],
        'description' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => '0', 'comment' => '100 Stars for $4.99, 500 Stars for $24.99 etc', 'precision' => null, 'fixed' => null],
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
            'product_id' => 'Lorem ipsum dolor sit amet',
            'product_category' => 'Lorem ipsum dolor sit amet',
            'apple_id' => 'Lorem ipsum dolor sit amet',
            'price_tier' => 'Lorem ipsum dolor sit amet',
            'reference_name' => 'Lorem ipsum dolor sit amet',
            'reference_value' => 1,
            'type' => 1,
            'price_code_id' => 1,
            'display_name' => 'Lorem ipsum dolor sit amet',
            'description' => 'Lorem ipsum dolor sit amet',
            'created_on' => 1451930542,
            'updated_on' => 1451930542
        ],
    ];
}
