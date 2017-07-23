<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TeamAvailablity Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Teams
 *
 * @method \App\Model\Entity\TeamAvailablity get($primaryKey, $options = [])
 * @method \App\Model\Entity\TeamAvailablity newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TeamAvailablity[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TeamAvailablity|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TeamAvailablity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TeamAvailablity[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TeamAvailablity findOrCreate($search, callable $callback = null)
 */
class TeamAvailablityTable extends Table
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

        $this->table('team_availablity');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Teams', [
            'foreignKey' => 'team_id',
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
            ->integer('match_type')
            ->requirePresence('match_type', 'create')
            ->notEmpty('match_type');

        $validator
            ->integer('locations')
            ->requirePresence('locations', 'create')
            ->notEmpty('locations');

        $validator
            ->requirePresence('date_range', 'create')
            ->notEmpty('date_range');

        $validator
            ->requirePresence('venue', 'create')
            ->notEmpty('venue');

        $validator
            ->integer('venue_capacity')
            ->requirePresence('venue_capacity', 'create')
            ->notEmpty('venue_capacity');

        $validator
            ->integer('venue_surface')
            ->requirePresence('venue_surface', 'create')
            ->notEmpty('venue_surface');

        $validator
            ->numeric('cost')
            ->requirePresence('cost', 'create')
            ->notEmpty('cost');

        $validator
            ->integer('refree_level')
            ->requirePresence('refree_level', 'create')
            ->notEmpty('refree_level');

        $validator
            ->integer('refree_from')
            ->requirePresence('refree_from', 'create')
            ->notEmpty('refree_from');

        $validator
            ->integer('brodcast')
            ->requirePresence('brodcast', 'create')
            ->notEmpty('brodcast');

        $validator
            ->integer('marketing_rights')
            ->requirePresence('marketing_rights', 'create')
            ->notEmpty('marketing_rights');

        $validator
            ->integer('gate_receipts')
            ->requirePresence('gate_receipts', 'create')
            ->notEmpty('gate_receipts');

        $validator
            ->dateTime('created_on')
            ->requirePresence('created_on', 'create')
            ->notEmpty('created_on');

        $validator
            ->dateTime('updated_on')
            ->requirePresence('updated_on', 'create')
            ->notEmpty('updated_on');

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
        $rules->add($rules->existsIn(['team_id'], 'Teams'));

        return $rules;
    }
}
