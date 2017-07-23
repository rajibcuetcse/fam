<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Team Entity
 *
 * @property int $id
 * @property string $name
 * @property int $age_category
 * @property int $type
 * @property int $gender
 * @property int $cms_user_id
 * @property string $administrator_designation
 * @property string $first_color
 * @property string $second_color
 * @property string $thrid_color
 * @property int $no_of_players_in_squad
 * @property int $no_of_officials_in_squad
 * @property string $head_coach_name
 * @property string $head_coach_nationality
 * @property string $team_manager_name
 * @property string $team_manager_nationality
 * @property \Cake\I18n\Time $created_on
 * @property \Cake\I18n\Time $modified_on
 * @property int $status
 *
 * @property \App\Model\Entity\Cmsuser $cms_user
 */
class Team extends Entity
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
        'id' => false
    ];
}
