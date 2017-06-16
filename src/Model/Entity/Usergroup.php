<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Usergroup Entity.
 *
 * @property int $id
 * @property string $group_name
 * @property \Cake\I18n\Time $created_on
 * @property \Cake\I18n\Time $modified_on
 * @property bool $status
 * @property int $company_id
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\UsergroupRole[] $usergroup_roles
 */
class Usergroup extends Entity
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
