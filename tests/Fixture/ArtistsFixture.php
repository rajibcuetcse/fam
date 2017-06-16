<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ArtistsFixture
 *
 */
class ArtistsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'name_en' => ['type' => 'string', 'length' => 150, 'null' => true, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name_ja' => ['type' => 'string', 'length' => 150, 'null' => true, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name_ko' => ['type' => 'string', 'length' => 150, 'null' => true, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name_zh' => ['type' => 'string', 'length' => 150, 'null' => true, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'picture' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'date_of_birth' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'category' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'address' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'email' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'phone' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'country' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'status' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '1', 'comment' => '0=inactive,1=active', 'precision' => null],
        'type' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '1', 'comment' => '-1=free timeline artist,0=paid timeline artist,1=regular artist', 'precision' => null],
        'created_on' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
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
            'name_en' => 'Lorem ipsum dolor sit amet',
            'name_ja' => 'Lorem ipsum dolor sit amet',
            'name_ko' => 'Lorem ipsum dolor sit amet',
            'name_zh' => 'Lorem ipsum dolor sit amet',
            'picture' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'date_of_birth' => 1449355530,
            'category' => 'Lorem ipsum dolor sit amet',
            'address' => 'Lorem ipsum dolor sit amet',
            'email' => 'Lorem ipsum dolor sit amet',
            'phone' => 'Lorem ipsum dolor ',
            'country' => 'Lorem ipsum dolor sit amet',
            'status' => 1,
            'type' => 1,
            'created_on' => 1449355530
        ],
    ];
}
