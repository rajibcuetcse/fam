<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ContentsFixture
 *
 */
class ContentsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'cmsuser_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'title_en' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'title_ko' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'title_ja' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'title_zh' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'description_en' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'description_ko' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'description_ja' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'description_zh' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'latest_comment_by_creator' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'youku_iframe_url' => ['type' => 'string', 'length' => 200, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'related_content' => ['type' => 'string', 'length' => 200, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'groups' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => 'comma separated group ids from groups table', 'precision' => null, 'fixed' => null],
        'artists' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => 'comma separated artist ids from artists table', 'precision' => null, 'fixed' => null],
        'platform' => ['type' => 'string', 'length' => 200, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'meta_tags' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'featured_image_path' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'visibility' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null],
        'status' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => '-1', 'comment' => '0=draft, 1= approved, 2=rejected,3=trashed', 'precision' => null, 'autoIncrement' => null],
        'type' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '1=Fixed Price,2=Free,3=Fixed countdown 4=duration countdown', 'precision' => null],
        'countdown_end_date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'countdown_duration' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'initial_price' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'The value will be in ticket', 'precision' => null, 'autoIncrement' => null],
        'final_price' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'modified_on' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => '0000-00-00 00:00:00', 'comment' => '', 'precision' => null],
        'created_on' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'company_id' => ['type' => 'integer', 'length' => 4, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'company_id' => ['type' => 'index', 'columns' => ['company_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'contents_ibfk_1' => ['type' => 'foreign', 'columns' => ['company_id'], 'references' => ['companies', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'cmsuser_id' => 1,
            'title_en' => 'Lorem ipsum dolor sit amet',
            'title_ko' => 'Lorem ipsum dolor sit amet',
            'title_ja' => 'Lorem ipsum dolor sit amet',
            'title_zh' => 'Lorem ipsum dolor sit amet',
            'description_en' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'description_ko' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'description_ja' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'description_zh' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'latest_comment_by_creator' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'youku_iframe_url' => 'Lorem ipsum dolor sit amet',
            'related_content' => 'Lorem ipsum dolor sit amet',
            'groups' => 'Lorem ipsum dolor sit amet',
            'artists' => 'Lorem ipsum dolor sit amet',
            'platform' => 'Lorem ipsum dolor sit amet',
            'meta_tags' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'featured_image_path' => 'Lorem ipsum dolor sit amet',
            'visibility' => 1,
            'status' => 1,
            'type' => 1,
            'countdown_end_date' => '2015-11-30 14:19:13',
            'countdown_duration' => 1,
            'initial_price' => 1,
            'final_price' => 1,
            'modified_on' => 1448893153,
            'created_on' => 1448893153,
            'company_id' => 1
        ],
    ];
}
