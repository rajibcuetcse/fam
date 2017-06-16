<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StarActivitiesFixture
 *
 */
class StarActivitiesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'artist_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'number_of_stars' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'date' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => '0000-00-00 00:00:00', 'comment' => '', 'precision' => null],
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
            'artist_id' => 1,
            'number_of_stars' => 1,
            'date' => 1452022934
        ],
    ];
}
