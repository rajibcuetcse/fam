<?php
namespace App\Model\Table;

use App\Model\Entity\Module;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Modules Model
 *
 */
class ModulesTable extends Table
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

        $this->table('modules');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('SubModules', [
            'foreignKey' => 'module_id'
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
            ->allowEmpty('id', 'create');*/
    	$validator
    		->requirePresence('id', 'create')
    		->notEmpty('id')
    		->add('id', 'valid', ['rule' => 'numeric','message' => 'The  Module Id must be Numeric'])
    		->add('id', 'validid', ['rule' => [$this, 'isModuleIdValid'], 'message' => 'The Module ID is not unique']);
        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');
        $validator
            ->requirePresence('icon', 'create')
            ->notEmpty('icon');
        $validator
            ->requirePresence('sequence', 'create')
            ->notEmpty('sequence')
            ->add('sequence', 'validsequence', ['rule' => 'numeric','message' => 'Sequence must be Numeric']);
        $validator
            ->add('name', 'valid', ['rule' => [$this, 'isModuleNameValid'], 'message' => 'The  Module name is not unique'])
            ->requirePresence('name', 'create')
            ->notEmpty('name', 'The Module name cannot be empty');

        return $validator;
    }

    public function isModuleNameValid($value, $context) {
        $module = $context['data'];
        $condition = ['name' => $value];
        if (isset($module['id'])) {
            $condition['Modules.id <>'] = $module['id'];
        }
        $result = $this->find('all', ['conditions' => $condition])->count();
        return ($result == 0);
    }
    
    public function isModuleIdValid($value, $context) {
    	$module = $context['data'];
    	$condition = ['id' => $value];
    	if (isset($module['id'])) {
    		$condition['Modules.id'] = $module['id'];
    	}
    	$result = $this->find('all', ['conditions' => $condition])->count();
    	//return $result;
    	return ($result == 0);
    }
}
