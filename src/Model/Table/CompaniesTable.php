<?php
namespace App\Model\Table;

use App\Model\Entity\Company;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Companies Model
 *
 * @property \Cake\ORM\Association\HasMany $Cmsusers
 * @property \Cake\ORM\Association\HasMany $Roles
 * @property \Cake\ORM\Association\HasMany $Usergroups
 */
class CompaniesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('companies');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('Cmsusers', [
            'foreignKey' => 'company_id'
        ]);
        $this->hasMany('Roles', [
            'foreignKey' => 'company_id'
        ]);
        $this->hasMany('Usergroups', [
            'foreignKey' => 'company_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('address1', 'create')
            ->notEmpty('address1');

        $validator
            ->requirePresence('postcode', 'create')
            ->notEmpty('postcode');

        $validator
            ->requirePresence('phone', 'create')
            ->notEmpty('phone');

//        $validator
//            ->add('email', 'valid', ['rule' => [$this, 'isEmailValid'], 'message' => 'The  Company email address is not unique'])
//            ->requirePresence('email', 'create')
//            ->allowEmpty('email');

//        $validator
//            ->requirePresence('fax', 'create')
//            ->allowEmpty('fax');

        $validator
            ->requirePresence('city', 'create')
            ->notEmpty('city');

        $validator
            ->requirePresence('state', 'create')
            ->notEmpty('state');

        $validator
            ->requirePresence('country', 'create')
            ->notEmpty('country');

//        $validator
//             ->add('registration_no', 'valid', ['rule' => 'numeric'])
//            ->requirePresence('registration_no', 'create')
//            ->allowEmpty('registration_no');
//
//        $validator
//            ->requirePresence('tax_no', 'create')
//            ->allowEmpty('tax_no');
//
//        $validator
//             ->allowEmpty('no_of_employees');
//
//        $validator
//            ->add('cmmi_level', 'valid', ['rule' => 'numeric'])
//            ->requirePresence('cmmi_level', 'create')
//            ->allowEmpty('cmmi_level');
//
//        $validator
//            ->add('yearly_revenue', 'valid', ['rule' => 'numeric'])
//            ->requirePresence('yearly_revenue', 'create')
//            ->allowEmpty('yearly_revenue');

        $validator
            ->add('status', 'valid', ['rule' => 'numeric'])
            ->requirePresence('status', 'create')
            ->allowEmpty('status');

        $validator
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

        $validator
            ->requirePresence('modified_on', 'create')
            ->notEmpty('modified_on');

        return $validator;
    }

    public function isEmailValid($value, $context) {
        $cmsUser = $context['data'];
        $condition = ['email' => $value];
        if (isset($cmsUser['id'])) {
            $condition['Companies.id <>'] = $cmsUser['id'];
        }
        $result = $this->find('all', ['conditions' => $condition])->count();
        return ($result == 0);
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        return $rules;
    }
}
