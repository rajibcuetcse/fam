<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\I18n;
use Cake\ORM\TableRegistry;
use DateTime;
use Cake\ORM\Query;
/**
 * SubModules Controller
 *
 * @property \App\Model\Table\SubModulesTable $SubModules
 */
class SubModulesController extends AppController
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
    	$page_limit=10;
    	if (isset($this->request->query['page_limit'])) {
    		$page_limit= $this->request->query('page_limit');
    	}
        $this->paginate = [
            'limit' => $page_limit,
            'contain' => ['Modules'],
            'sortWhitelist' => [
                'Modules.name', 'SubModules.created_on', 'SubModules.name', 'SubModules.modified_on', 'SubModules.id'
            ],
            'order' => [
                'SubModules.created_on' => 'desc'
            ]
        ];

        $search = '';
        if (isset($this->request->query['search'])) {
            $search = $this->request->query('search');
        }

        $sub_modules = $this->SubModules->find('all')->where([
            'SubModules.name LIKE' => '%' . $search . '%'
        ]);

        $this->set('subModules', $this->paginate($sub_modules));
        $this->set('_serialize', ['subModules']);
        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('module_pages', $this->getPages());
        $this->set('bulk_actions', [BULK_ACTION_DELETE => "Move to trash"]);
        $this->set('current_module', $this->getModules());
        $this->set('sub_modules', $this->getSubModules());
        $this->set('searchText', $search);
        $this->set('user_permission', $user_permissions);
        $this->set('page_limit', $page_limit);
        //$this->viewBuilder()->layout("master_data");
        $this->viewBuilder()->layout("custom_layout");
    }

    public function bulkAction()
    {
        $this->request->allowMethod(['post', 'delete']);
        $selectedSubModules = $this->request->data('selected_content');
        $bulkAction = $this->request->data('bulk_action');
        if ($bulkAction == BULK_ACTION_DELETE) {
            if ($selectedSubModules == "") return $this->redirect(['action' => 'index']);
            $subModulesToDelete = explode(',', $selectedSubModules);
            $error = $this->deleteAll($subModulesToDelete);
            if (!$error) {
                $this->Flash->success(__('All the selected Submodules have been deleted.'));
            } else {
                $this->Flash->error($error);
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    private function deleteAll($subModules)
    {
        foreach ($subModules as &$subModulesWithId) {
            $subModuleId = str_replace('content_', '', $subModulesWithId);
            $subModule = $this->SubModules->get($subModuleId);
            if ($this->canSubModuleBeDeleted($subModuleId)) {
                $this->SubModules->delete($subModule);
            } else {
                return (__('The Submodule ' . $subModule->name . ' cannot be deleted as it contains pages'));
            }
        }
    }

    /**
     * View method
     *
     * @param string|null $id Sub Module id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $subModule = $this->SubModules->get($id, [
            'contain' => ['Modules', 'Pages']
        ]);
        $this->set('subModule', $subModule);
        $this->set('_serialize', ['subModule']);
        $this->viewBuilder()->layout("master_data");
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $subModule = $this->SubModules->newEntity();
        if ($this->request->is('post')) {
            $subModule = $this->SubModules->patchEntity($subModule, $this->request->data);
            $subModuleErrors = $this->checkAndDisplayEntityErrors($subModule);
            if (!$subModuleErrors) {
            if ($this->SubModules->save($subModule)) {
                $this->Flash->success(__('The sub module has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                    $this->Flash->error(__('The sub module could not be saved. Please, try again.'));
                }
            }
        }
        $modules = $this->SubModules->Modules->find('list', ['limit' => 200]);
        $this->set(compact('subModule', 'modules'));
        $this->set('_serialize', ['subModule']);
        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('module_pages', $this->getPages());
        $this->set('current_module', $this->getModules());
        $this->set('sub_modules', $this->getSubModules());
        $this->set('user_permission', $user_permissions);
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

    /**
     * Edit method
     *
     * @param string|null $id Sub Module id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $subModule = $this->SubModules->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
        	//pr($this->request->data);exit;
        	$id = $this->request->params['pass'][0];
            $subModule = $this->SubModules->patchEntity($subModule, $this->request->data);
            $subModule['modified_on'] = new DateTime();
            $query = $this->SubModules->query();
            $update = $query->update()
            ->set(['id' => $this->request->data['id'],'module_id'=>$this->request->data['module_id'],
            		'name' => $this->request->data['name'],'icon'=>$this->request->data['icon'],
            		'sequence'=>$this->request->data['sequence'],'controller_name'=>$this->request->data['controller_name'],
            		'modified_on'=>$this->request->data['modified_on']])
            		->where(['id' => $id])
            		->execute();
            if ($update) {
                $this->Flash->success(__('The sub module has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The sub module could not be saved. Please, try again.'));
            }
        }
        $modules = $this->SubModules->Modules->find('list', ['limit' => 200]);
        $this->set(compact('subModule', 'modules'));
        $this->set('_serialize', ['subModule']);
        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('module_pages', $this->getPages());
        $this->set('current_module', $this->getModules());
        $this->set('sub_modules', $this->getSubModules());
        $this->set('user_permission', $user_permissions);
        //$this->viewBuilder()->layout("master_data");
        $this->viewBuilder()->layout("custom_layout");
    }

    /**
     * Delete method
     *
     * @param string|null $id Sub Module id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $subModule = $this->SubModules->get($id);
        if ($this->canSubModuleBeDeleted($id)) {
            if ($this->SubModules->delete($subModule)) {
                $this->Flash->success(__('The sub module has been deleted.'));
            } else {
                $this->Flash->error(__('The sub module could not be deleted. Please, try again.'));
            }
        } else {
            $this->Flash->error(__('The Submodule cannot be deleted as it contains related pages.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    private function canSubModuleBeDeleted($subModuleId)
    {
        if ($subModuleId) {
            $PagesTable = TableRegistry::get('pages');
            $pages = $PagesTable->find('all')
                ->where(['sub_module_id' => $subModuleId]);
            if (sizeof($pages->toArray()) > 0) return false;
        }
        return true;
    }

  
}
