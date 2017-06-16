<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\I18n;
use Cake\ORM\TableRegistry;
use DateTime;
use ModuleConstants;
use PagesConstants;
use SubModuleConstants;
use Cake\ORM\Query;
/**
 * Modules Controller
 *
 * @property \App\Model\Table\ModulesTable $Modules
 */
class StudentsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        I18n::locale('en_US');
    }

    public function isAuthorized($user)
    {
        $request_action = $this->request->params['action'];
        if ($request_action == "bulkAction") {
            return true;
        }
        return parent::isAuthorized($user);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'limit' => 10,
            'order' => [
                'Students.created_on' => 'desc'
            ]
        ];

        $search = '';
        if (isset($this->request->query['search'])) {
            $search = $this->request->query('search');
        }

        $modules = $this->Students->find('all')->where([
            'name LIKE' => '%' . $search . '%'
        ]);
        $this->set('modules', $this->paginate($modules));
        $this->set('_serialize', ['modules']);
        $user_permissions = $this->request->session()->read('user_permissions');      
        $this->set('pages', $this->getPages());
        $this->set('bulk_actions', [BULK_ACTION_DELETE => "Move to trash"]);
        $this->set('current_module', $this->getModules());
        $this->set('sub_modules', $this->getSubModules());
        $this->set('searchText', $search);
        $this->set('user_permission', $user_permissions);
        $this->viewBuilder()->layout("custom_layout");
    }

    public function bulkAction()
    {
        $this->request->allowMethod(['post', 'delete']);
        $selectedModules = $this->request->data('selected_content');
        $bulkAction = $this->request->data('bulk_action');
        if ($bulkAction == BULK_ACTION_DELETE) {
            if ($selectedModules == "") return $this->redirect(['action' => 'index']);
            $modulesToBeDeleted = explode(',', $selectedModules);
            $error = $this->deleteAll($modulesToBeDeleted);
            if (!$error) {
                $this->Flash->success(__('All the selected Modules have been deleted.'));
            } else {
                $this->Flash->error($error);
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    private function deleteAll($modules)
    {
        foreach ($modules as &$moduleIdWithPrefix) {
            $moduleId = str_replace('content_', '', $moduleIdWithPrefix);
            $module = $this->Modules->get($moduleId);
            if ($this->canModuleBeDeleted($moduleId)) {
                $this->Modules->delete($module);
            } else {
                return (__('The Module ' . $module->name . ' cannot be deleted as it contains related Submodules'));
            }
        }
    }


    public function view($id = null)
    {
        $module = $this->Modules->get($id, [
            'contain' => []
        ]);
        $this->set('module', $module);
        $this->set('_serialize', ['module']);

    }


    public function add()
    {
        $newmodule = $this->Modules->newEntity();
        if ($this->request->is('post')) {
            $newmodule = $this->Modules->patchEntity($newmodule, $this->request->data);           
            $moduleErrors = $this->checkAndDisplayEntityErrors($newmodule);
            if (!$moduleErrors) {
            	//pr($newmodule);exit;
                if ($this->Modules->save($newmodule)) {
                    $this->Flash->success(__('The module has been saved.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The module could not be saved. Please, try again.'));
                }
            }
        }
        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('pages', $this->getPages());
        $this->set('current_module', $this->getModules());
        $this->set('sub_modules', $this->getSubModules());
        $this->set('user_permission', $user_permissions);
        $this->set(compact('newmodule'));
        $this->set('_serialize', ['module']);
        //$this->viewBuilder()->layout("master_data");
        $this->viewBuilder()->layout("custom_layout");
    }

    private function checkAndDisplayEntityErrors($entity)
    {
        $entityErrors = $entity->errors();
        foreach ($entityErrors as $key => $value) {
            foreach ($entityErrors[$key] as $errorKey => $errorValue) {
                $this->Flash->error($errorValue);
            }
        }
        return $entityErrors;
    }


    public function edit($id = null)
    {
        $newmodule = $this->Modules->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
        	$id = $this->request->params['pass'][0];
        	//pr($this->request->data);exit;
            $newmodule = $this->Modules->patchEntity($newmodule, $this->request->data);
            $newmodule['modified_on'] = new DateTime();
            $query = $this->Modules->query();
           	$update = $query->update()
            ->set(['id' => $this->request->data['id'],'name'=>$this->request->data['name'],
            		'icon'=>$this->request->data['icon'],'sequence'=>$this->request->data['sequence']])
            ->where(['id' => $id])
            ->execute();
            if ($update) {
                $this->Flash->success(__('The module has been updated.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The module could not be saved. Please, try again.'));
            }
        }
        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('pages', $this->getPages());
        $this->set('current_module', $this->getModules());
        $this->set('sub_modules', $this->getSubModules());
        $this->set('user_permission', $user_permissions);
        $this->set(compact('newmodule'));
        $this->set('_serialize', ['newmodule']);
        //$this->viewBuilder()->layout("master_data");
        $this->viewBuilder()->layout("custom_layout");
    }


    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $module = $this->Modules->get($id);
        if ($this->canModuleBeDeleted($id)) {
            if ($this->Modules->delete($module)) {
                $this->Flash->success(__('The module has been deleted.'));
            } else {
                $this->Flash->error(__('The module could not be deleted. Please, try again.'));
            }
        } else {
            $this->Flash->error(__('The Module cannot be deleted as it contains related Submodules.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    private function canModuleBeDeleted($moduleId)
    {
        if ($moduleId) {
            $SubModulesTable = TableRegistry::get('sub_modules');
            $subModules = $SubModulesTable->find('all')
                ->where(['module_id' => $moduleId]);

            if (sizeof($subModules->toArray()) > 0) return false;
        }
        return true;
    }

    public function getModules()
    {
        return ['School' =>'100'];
    }

    public function getSubModules()
    {
        return ['Student Management' => '200'];
    }

    public function getPages()
    {
        return ['index' =>'301',
            'add' => '302',
            'edit' => '303',
            'delete' =>'304'];
    }
}
