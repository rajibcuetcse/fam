<?php
namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cmsusers Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Companies
 */
class CmsusersTable extends Table
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
        $this->addBehavior('SoftDeletable');
        $this->table('cmsusers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('CmsuserUsergroups', [
            'foreignKey' => 'cms_user_id'
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
            ->requirePresence('language', 'create')
            ->notEmpty('language');

        $validator
            ->add('username', 'valid', ['rule' => [$this, 'isUserNameValid'], 'message' => 'The  user name is not unique'])
            ->requirePresence('username', 'create')
            ->notEmpty('username', 'The User name cannot be empty');

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');


        $validator
            ->add('email', 'validemail', ['rule' => [$this, 'isEmailValid'], 'message' => 'The  user email address is not unique'])
            ->add('email', 'valid', ['rule' => [$this, 'isEmailWellFormed'], 'message' => 'The  user email address is not well formed'])
            ->requirePresence('email')
            ->notEmpty('email');

        $validator
            ->add('retype_password', 'compareWith', [
                    'rule' => ['compareWith', 'password'],
                    'message' => 'Passwords not equal.'
                ]
            )
            ->requirePresence('retype_password', 'create')
            ->notEmpty('retype_password');

        $validator
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

        $validator
            ->requirePresence('updated_on', 'create')
            ->notEmpty('updated_on');

        $validator
            ->add('status', 'valid', ['rule' => 'numeric'])
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }

    public function isUserNameValid($value, $context)
    {
        $cmsUser = $context['data'];
        $condition = ['username' => $value];
        if (isset($cmsUser['id'])) {
            $condition['Cmsusers.id <>'] = $cmsUser['id'];
        }
        $result = $this->find('all', ['conditions' => $condition])->count();
        return ($result == 0);
    }

    public function isEmailValid($value, $context)
    {
        $cmsUser = $context['data'];
        $condition = ['email' => $value];
        if (isset($cmsUser['id'])) {
            $condition['Cmsusers.id <>'] = $cmsUser['id'];
        }
        $result = $this->find('all', ['conditions' => $condition])->count();

        return ($result == 0);
    }

    public function isEmailWellFormed($value, $context)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
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

        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['company_id'], 'Companies'));
        return $rules;
    }
}
