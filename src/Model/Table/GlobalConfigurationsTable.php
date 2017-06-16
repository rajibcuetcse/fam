<?php
namespace App\Model\Table;

use App\Model\Entity\GlobalConfiguration;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GlobalConfigurations Model
 *
 */
class GlobalConfigurationsTable extends Table
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

        $this->table('global_configurations');
        $this->displayField('id');
        $this->primaryKey('id');

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
            ->add('device_type', 'valid', ['rule' => 'numeric'])
            ->requirePresence('device_type', 'create')
            ->notEmpty('device_type');

        $validator
            ->requirePresence('latest_version', 'create')
            ->notEmpty('latest_version');

        $validator
            ->requirePresence('terms_of_use_url', 'create')
            ->notEmpty('terms_of_use_url');

        $validator
            ->add('ticket_to_tokens_rate', 'valid', ['rule' => 'numeric'])
            ->requirePresence('ticket_to_tokens_rate', 'create')
            ->notEmpty('ticket_to_tokens_rate');

        $validator
            ->add('max_ability_to_save_content', 'valid', ['rule' => 'numeric'])
            ->requirePresence('max_ability_to_save_content', 'create')
            ->notEmpty('max_ability_to_save_content');

        $validator
            ->add('max_ability_to_unlock_content', 'valid', ['rule' => 'numeric'])
            ->requirePresence('max_ability_to_unlock_content', 'create')
            ->notEmpty('max_ability_to_unlock_content');

        $validator
            ->add('ticket_required_per_hour_to_unlock', 'valid', ['rule' => 'numeric'])
            ->requirePresence('ticket_required_per_hour_to_unlock', 'create')
            ->notEmpty('ticket_required_per_hour_to_unlock');

        $validator
            ->add('login_to_app_points', 'valid', ['rule' => 'numeric'])
            ->requirePresence('login_to_app_points', 'create')
            ->notEmpty('login_to_app_points');

        $validator
            ->requirePresence('released_date', 'create')
            ->notEmpty('released_date');

        $validator
            ->requirePresence('modified_on', 'create')
            ->notEmpty('modified_on');

        $validator
            ->add('faq_latest_version', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('faq_latest_version');

        return $validator;
    }
}
