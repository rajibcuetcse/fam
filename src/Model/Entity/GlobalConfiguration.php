<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GlobalConfiguration Entity.
 *
 * @property int $id
 * @property int $device_type
 * @property string $latest_version
 * @property string $terms_of_use_url
 * @property int $ticket_to_tokens_rate
 * @property int $max_ability_to_save_content
 * @property int $max_ability_to_unlock_content
 * @property int $ticket_required_per_hour_to_unlock
 * @property int $login_to_app_points
 * @property \Cake\I18n\Time $released_date
 * @property \Cake\I18n\Time $modified_on
 * @property int $faq_latest_version
 */
class GlobalConfiguration extends Entity
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
