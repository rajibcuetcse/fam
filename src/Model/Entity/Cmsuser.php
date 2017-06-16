<?php
namespace App\Model\Entity;

use App\Auth\CmsPasswordHasher;
use Cake\ORM\Entity;

/**
 * Cmsuser Entity.
 *
 * @property int $id
 * @property string $language
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $reset_password_token
 * @property \Cake\I18n\Time $created_on
 * @property \Cake\I18n\Time $updated_on
 * @property bool $status
 * @property int $company_id
 * @property \App\Model\Entity\Company $company
 */
class Cmsuser extends Entity
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

    protected function _setPassword($value)
    {
        $hasher = new CmsPasswordHasher();
        return $hasher->hash($value);
    }
}
