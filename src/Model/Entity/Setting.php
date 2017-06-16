<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Setting Entity.
 *
 * @property int $id
 * @property int $device_type
 * @property string $latest_version
 * @property string $terms_of_use_url
 * @property string $yg_youtube_url
 * @property string $yg_facebook_url
 * @property string $yg_twitter_url
 * @property \Cake\I18n\Time $released_date
 * @property \Cake\I18n\Time $modified_on
 * @property int $faq_latest_version
 */
class Setting extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
