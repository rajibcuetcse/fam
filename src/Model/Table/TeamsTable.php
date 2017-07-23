<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Teams Model
 *
 * @property \Cake\ORM\Association\BelongsTo $CmsUsers
 *
 * @method \App\Model\Entity\Team get($primaryKey, $options = [])
 * @method \App\Model\Entity\Team newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Team[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Team|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Team patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Team[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Team findOrCreate($search, callable $callback = null)
 */
class TeamsTable extends Table
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

        $this->table('teams');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('CmsUsers', [
            'foreignKey' => 'cms_user_id',
            'joinType' => 'INNER'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->integer('age_category')
            ->requirePresence('age_category', 'create')
            ->notEmpty('age_category');

        $validator
            ->integer('type')
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->integer('gender')
            ->requirePresence('gender', 'create')
            ->notEmpty('gender');

        $validator
            ->requirePresence('administrator_designation', 'create')
            ->notEmpty('administrator_designation');

        $validator
            ->requirePresence('first_color', 'create')
            ->notEmpty('first_color');

        $validator
            ->requirePresence('second_color', 'create')
            ->notEmpty('second_color');

        $validator
            ->requirePresence('thrid_color', 'create')
            ->notEmpty('thrid_color');

        $validator
            ->integer('no_of_players_in_squad')
            ->requirePresence('no_of_players_in_squad', 'create')
            ->notEmpty('no_of_players_in_squad');

        $validator
            ->integer('no_of_officials_in_squad')
            ->requirePresence('no_of_officials_in_squad', 'create')
            ->notEmpty('no_of_officials_in_squad');

        $validator
            ->requirePresence('head_coach_name', 'create')
            ->notEmpty('head_coach_name');

        $validator
            ->requirePresence('head_coach_nationality', 'create')
            ->notEmpty('head_coach_nationality');

        $validator
            ->requirePresence('team_manager_name', 'create')
            ->notEmpty('team_manager_name');

        $validator
            ->requirePresence('team_manager_nationality', 'create')
            ->notEmpty('team_manager_nationality');

        $validator
            ->dateTime('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

        $validator
            ->dateTime('modified_on')
            ->requirePresence('modified_on', 'create')
            ->notEmpty('modified_on');

        $validator
            ->integer('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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
        $rules->add($rules->existsIn(['cms_user_id'], 'CmsUsers'));

        return $rules;
    }
}
