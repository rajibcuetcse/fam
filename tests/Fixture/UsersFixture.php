<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 *
 */
class UsersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'nickname' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'user_type' => ['type' => 'integer', 'length' => 2, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '0=normal user,1=artist,2=admin,3=super admin', 'precision' => null, 'autoIncrement' => null],
        'registration_type' => ['type' => 'integer', 'length' => 2, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '1=EMAIL,2=FACEBOOK,3=TWITTER', 'precision' => null, 'autoIncrement' => null],
        'social_id' => ['type' => 'string', 'length' => 64, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'email' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'password' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'pre_lang' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => 'en', 'comment' => '', 'precision' => null],
        'date_of_birth' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => '0000-00-00 00:00:00', 'comment' => '', 'precision' => null],
        'profile_pic_url' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'api_token' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'api_token_expired_on' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => '0000-00-00 00:00:00', 'comment' => '', 'precision' => null],
        'is_rec_marketing_email' => ['type' => 'string', 'fixed' => true, 'length' => 1, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'is_verified' => ['type' => 'string', 'fixed' => true, 'length' => 1, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null],
        'profile_pic_modify_time' => ['type' => 'integer', 'length' => 12, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'balance_stars' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'balance_tickets' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'balance_tokens' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'unlocking_ability' => ['type' => 'integer', 'length' => 2, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created_on' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => '0000-00-00 00:00:00', 'comment' => '', 'precision' => null],
        'updated_on' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => '0000-00-00 00:00:00', 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'users_email_unique' => ['type' => 'unique', 'columns' => ['email'], 'length' => []],
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
            'nickname' => 'Lorem ipsum dolor ',
            'user_type' => 1,
            'registration_type' => 1,
            'social_id' => 'Lorem ipsum dolor sit amet',
            'email' => 'Lorem ipsum dolor sit amet',
            'password' => 'Lorem ipsum dolor ',
            'pre_lang' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'date_of_birth' => 1449356619,
            'profile_pic_url' => 'Lorem ipsum dolor sit amet',
            'api_token' => 'Lorem ipsum dolor sit amet',
            'api_token_expired_on' => 1449356619,
            'is_rec_marketing_email' => 'Lorem ipsum dolor sit ame',
            'is_verified' => 'Lorem ipsum dolor sit ame',
            'profile_pic_modify_time' => 1,
            'balance_stars' => 1,
            'balance_tickets' => 1,
            'balance_tokens' => 1,
            'unlocking_ability' => 1,
            'created_on' => 1449356619,
            'updated_on' => 1449356619
        ],
    ];
}
