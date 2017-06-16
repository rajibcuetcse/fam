<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Socials
 * @property \Cake\ORM\Association\HasMany $ApiTokens
 * @property \Cake\ORM\Association\HasMany $Collections
 * @property \Cake\ORM\Association\HasMany $ContentCommentLikes
 * @property \Cake\ORM\Association\HasMany $ContentCommentReports
 * @property \Cake\ORM\Association\HasMany $ContentComments
 * @property \Cake\ORM\Association\HasMany $ContentCommentsCopy
 * @property \Cake\ORM\Association\HasMany $ContentLikes
 * @property \Cake\ORM\Association\HasMany $FriendInvitations
 * @property \Cake\ORM\Association\HasMany $LogEvents
 * @property \Cake\ORM\Association\HasMany $PaymentReceipts
 * @property \Cake\ORM\Association\HasMany $StarActivities
 * @property \Cake\ORM\Association\HasMany $TokenTransactions
 * @property \Cake\ORM\Association\HasMany $UnlockingAbilityChangeHistories
 * @property \Cake\ORM\Association\HasMany $UnlockingActivities
 */
class UsersTable extends Table
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

        $this->table('users');
        $this->displayField('nickname');
        $this->primaryKey('id');

        $this->hasMany('ApiTokens', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Collections', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('ContentCommentLikes', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('ContentCommentReports', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('ContentComments', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('ContentCommentsCopy', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('ContentLikes', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('FriendInvitations', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('LogEvents', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('PaymentReceipts', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('StarActivities', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('TokenTransactions', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('UnlockingAbilityChangeHistories', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('UnlockingActivities', [
            'foreignKey' => 'user_id'
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
            ->requirePresence('nickname', 'create')
            ->notEmpty('nickname', 'The Nickname cannot be empty');

        $validator
            ->add('user_type', 'valid', ['rule' => 'numeric'])
            ->requirePresence('user_type', 'create')
            ->notEmpty('user_type');

        $validator
            ->add('registration_type', 'valid', ['rule' => 'numeric'])
            ->requirePresence('registration_type', 'create')
            ->notEmpty('registration_type');

        $validator
            ->add('email', 'valid', ['rule' => 'email'])
            ->requirePresence('email', 'create')
            ->notEmpty('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->add('retype_password', 'compareWith', [
                    'rule' => ['compareWith', 'password'],
                    'message' => 'Passwords not equal.'
                ]
            )
            ->requirePresence('retype_password', 'create')
            ->notEmpty('retype_password');

        $validator
            ->requirePresence('profile_pic_url', 'create')
            ->notEmpty('profile_pic_url');

        $validator
            ->requirePresence('api_token', 'create')
            ->notEmpty('api_token');

        $validator
            ->allowEmpty('api_token_expired_on');

        $validator
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');


        return $validator;
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
