<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Company Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $address1
 * @property string $address2
 * @property string $postcode
 * @property string $phone
 * @property string $email
 * @property string $fax
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $logo
 * @property string $registration_no
 * @property string $tax_no
 * @property int $no_of_employees
 * @property bool $cmmi_level
 * @property float $yearly_revenue
 * @property bool $status
 * @property \Cake\I18n\Time $created_on
 * @property \Cake\I18n\Time $modified_on
 * @property \App\Model\Entity\Cmsuser[] $cmsusers
 * @property \App\Model\Entity\Role[] $roles
 * @property \App\Model\Entity\Usergroup[] $usergroups
 */
class Company extends Entity
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
