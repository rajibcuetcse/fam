<?php
namespace App\Model\Table;

use App\Model\Entity\Page;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pages Model
 *
 * @property \Cake\ORM\Association\BelongsTo $SubModules
 */
class PagesTable extends Table
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

        $this->table('pages');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('SubModules', [
            'foreignKey' => 'sub_module_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Modules', [
            'foreignKey' => 'SubModule.id',
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
        /*$validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->notEmpty('id', 'create');*/
    	
    	$validator
    	->requirePresence('id', 'create')
    	->notEmpty('id')
    	->add('id', 'valid', ['rule' => 'numeric','message' => 'The Page Id must be Numeric'])
    	->add('id', 'validid', ['rule' => [$this, 'isPageIdValid'], 'message' => 'The Page ID is not unique']);
        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');
        
       $validator
            ->requirePresence('method_name', 'create')
            ->notEmpty('method_name');

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
        $rules->add($rules->existsIn(['sub_module_id'], 'SubModules'));
        return $rules;
    }
    
    public function isPageIdValid($value, $context) {
    	$page = $context['data'];
    	$condition = ['id' => $value];
    	if (isset($page['id'])) {
    		$condition['Pages.id'] = $page['id'];
    	}
    	$result = $this->find('all', ['conditions' => $condition])->count();
    	//return $result;
    	return ($result == 0);
    }
}
