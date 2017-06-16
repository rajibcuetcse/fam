<?php
namespace App\Model\Table;

use App\Model\Entity\Setting;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Settings Model
 *
 */
class SettingsTable extends Table
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

        $this->table('settings');
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
            ->requirePresence('yg_youtube_url', 'create')
            ->notEmpty('yg_youtube_url');

        $validator
            ->requirePresence('yg_facebook_url', 'create')
            ->notEmpty('yg_facebook_url');

        $validator
            ->requirePresence('yg_twitter_url', 'create')
            ->notEmpty('yg_twitter_url');

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
