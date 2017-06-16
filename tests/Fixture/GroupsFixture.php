<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * GroupsFixture
 *
 */
class GroupsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'timeline_artist_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => '-1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'name_en' => ['type' => 'string', 'length' => 150, 'null' => true, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name_ja' => ['type' => 'string', 'length' => 150, 'null' => true, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name_zh' => ['type' => 'string', 'length' => 150, 'null' => true, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name_ko' => ['type' => 'string', 'length' => 150, 'null' => true, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'type' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => '0=free group,1=paid', 'precision' => null],
        'profile_pic_url' => ['type' => 'string', 'length' => 200, 'null' => true, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'status' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '1', 'comment' => '0=inactive,1=active', 'precision' => null],
        'created_on' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => '0000-00-00 00:00:00', 'comment' => '', 'precision' => null],
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
            'timeline_artist_id' => 1,
            'name_en' => 'Lorem ipsum dolor sit amet',
            'name_ja' => 'Lorem ipsum dolor sit amet',
            'name_zh' => 'Lorem ipsum dolor sit amet',
            'name_ko' => 'Lorem ipsum dolor sit amet',
            'type' => 1,
            'profile_pic_url' => 'Lorem ipsum dolor sit amet',
            'status' => 1,
            'created_on' => 1449355568
        ],
    ];
}
