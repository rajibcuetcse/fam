<?php
namespace App\Model\Table;

use App\Model\Entity\SubModule;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SubModules Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Modules
 * @property \Cake\ORM\Association\HasMany $Pages
 */
class SubModulesTable extends Table
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

        $this->table('sub_modules');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Modules', [
            'foreignKey' => 'module_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Pages', [
            'foreignKey' => 'sub_module_id'
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
    	->add('id', 'valid', ['rule' => 'numeric','message' => 'The  Submodule Id must be Numeric'])
    	->add('id', 'validid', ['rule' => [$this, 'isSubModuleIdValid'], 'message' => 'The Submodule ID is not unique']);

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
            ->requirePresence('controller_name', 'create')
            ->notEmpty('controller_name');

        $validator
            ->add('name', 'valid', ['rule' => [$this, 'isSubModuleNameValid'], 'message' => 'The  Sub-Module name is not unique'])
            ->requirePresence('name', 'create')
            ->notEmpty('name', 'The Sub-Module name cannot be empty');

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
        $rules->add($rules->existsIn(['module_id'], 'Modules'));
        return $rules;
    }

    public function isSubModuleNameValid($value, $context) {
        $module = $context['data'];
        $condition = ['name' => $value];
        if (isset($module['id'])) {
            $condition['SubModules.id <>'] = $module['id'];
        }
        $result = $this->find('all', ['conditions' => $condition])->count();
        return ($result == 0);
    }
    
    public function isSubModuleIdValid($value, $context) {
    	$submodule = $context['data'];
    	$condition = ['id' => $value];
    	if (isset($submodule['id'])) {
    		$condition['SubModules.id'] = $submodule['id'];
    	}
    	$result = $this->find('all', ['conditions' => $condition])->count();
    	return ($result == 0);
    }
}
