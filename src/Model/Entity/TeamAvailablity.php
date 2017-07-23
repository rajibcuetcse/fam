<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TeamAvailablity Entity
 *
 * @property int $id
 * @property int $team_id
 * @property int $match_type
 * @property int $locations
 * @property string $date_range
 * @property string $venue
 * @property int $venue_capacity
 * @property int $venue_surface
 * @property float $cost
 * @property int $refree_level
 * @property int $refree_from
 * @property int $brodcast
 * @property int $marketing_rights
 * @property int $gate_receipts
 * @property \Cake\I18n\Time $created_on
 * @property \Cake\I18n\Time $updated_on
 *
 * @property \App\Model\Entity\Team $team
 */
class TeamAvailablity extends Entity
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
