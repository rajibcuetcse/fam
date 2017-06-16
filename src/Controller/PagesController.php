<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\I18n;
use Cake\ORM\TableRegistry;
use DateTime;
use Cake\ORM\Query;
/**
 * Pages Controller
 *
 * @property \App\Model\Table\PagesTable $Pages
 */
class PagesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        I18n::locale('en_US');
    }

    public function isAuthorized($user)
    {
        $request_action = $this->request->params['action'];
        if ($request_action == "getSubModulesByModule" && $this->Auth->user() || $request_action == "bulkAction") {
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
            'contain' => ['SubModules.Modules'],
            'sortWhitelist' => [
                'Modules.name', 'Pages.created_on', 'SubModules.name', 'Pages.id', 'Pages.name', 'Pages.modified_on'
            ],
            'order' => [
                'Pages.created_on' => 'desc'
            ]
        ];
        $search = '';
        if (isset($this->request->query['search'])) {
            $search = $this->request->query('search');
        }

        $pages = $this->Pages->find('all')->where([
            'Pages.name LIKE' => '%' . $search . '%'
        ]);

        $this->set('pages', $this->paginate($pages));
        $this->set('_serialize', ['pages']);
        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('module_pages', $this->getPages());
        $this->set('bulk_actions', [BULK_ACTION_DELETE => "Move to trash"]);
        $this->set('current_module', $this->getModules());
        $this->set('sub_modules', $this->getSubModules());
        $this->set('user_permission', $user_permissions);
        $this->set('searchText', $search);
        $this->set('page_limit', $page_limit);
        $this->viewBuilder()->layout("custom_layout");
    }

    public function bulkAction()
    {
        $this->request->allowMethod(['post', 'delete']);
        $selectedPages = $this->request->data('selected_content');
        $bulkAction = $this->request->data('bulk_action');
        if ($bulkAction == BULK_ACTION_DELETE) {
            if ($selectedPages == "") return $this->redirect(['action' => 'index']);
            $pagesToBeDeleted = explode(',', $selectedPages);
            $error = $this->deleteAll($pagesToBeDeleted);
            if (!$error) {
                $this->Flash->success(__('All the selected Pages have been deleted.'));
            } else {
                $this->Flash->error($error);
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    private function deleteAll($pages)
    {
        foreach ($pages as &$pagesWithIdPrefix) {
            $pagesId = str_replace('content_', '', $pagesWithIdPrefix);
            $page = $this->Pages->get($pagesId);
            $this->Pages->delete($page);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Page id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $page = $this->Pages->get($id, [
            'contain' => ['SubModules']
        ]);
        $this->set('page', $page);
        $this->set('_serialize', ['page']);
        $this->viewBuilder()->layout("master_data");
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $page = $this->Pages->newEntity();
        if ($this->request->is('post')) {
            $page = $this->Pages->patchEntity($page, $this->request->data);
            $pageErrors = $this->checkAndDisplayEntityErrors($page);
            if (!$pageErrors) {
            if ($this->Pages->save($page)) {
                $this->Flash->success(__('The page has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The page could not be saved. Please, try again.'));
            }
            }
        }
        $user_permissions = $this->request->session()->read('user_permissions');
        $ModulesTable = TableRegistry::get('modules');
        $modules = $ModulesTable->find('list');
//        $subModules = $this->Pages->SubModules->find('list', ['limit' => 200, 'contain' => ['Modules']]);
        $this->set(compact('page', 'modules'));
        $this->set('_serialize', ['page']);
        $this->set('module_pages', $this->getPages());
        $this->set('current_module', $this->getModules());
        $this->set('sub_modules', $this->getSubModules());
        $this->set('user_permission', $user_permissions);
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

    public function getSubModulesByModule($moduleId)
    {
        $this->viewBuilder()->layout(false);

        $SubModulesTable = TableRegistry::get('sub_modules');
        $subModules = $SubModulesTable->find('list')
            ->where(['module_id' => $moduleId]);

        $this->log($subModules->toArray());
//        debug($subModules);
        $jsonObject = [
            'filtered_sub_modules' => $subModules
        ];

        echo json_encode($jsonObject);
        die();
    }

    /**
     * Edit method
     *
     * @param string|null $id Page id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $page = $this->Pages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
        	//pr($this->request->data);exit;
            $page = $this->Pages->patchEntity($page, $this->request->data);
            if (!array_key_exists('available_to_company', $this->request->data)) {
                $page['available_to_company'] = false;
            }
            $page['modified_on'] = new DateTime();
            $id = $this->request->params['pass'][0];
            $query = $this->Pages->query();
            $update = $query->update()
            ->set(['id' => $this->request->data['id'],'module_id'=>$this->request->data['module_id'],
            		'sub_module_id'=>$this->request->data['sub_module_id'],'name'=>$this->request->data['name'],
            		'method_name'=>$this->request->data['method_name']])
            		->where(['id' => $id])
            		->execute();
            if ($update) {
                $this->Flash->success(__('The page has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The page could not be saved. Please, try again.'));
            }
        }
        $ModulesTable = TableRegistry::get('modules');
        $modules = $ModulesTable->find('list');
        $subModules = $this->Pages->SubModules->find('list', ['limit' => 200]);
        $this->set(compact('page', 'subModules','modules'));
        $this->set('_serialize', ['page']);
        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('module_pages', $this->getPages());
        $this->set('current_module', $this->getModules());
        $this->set('sub_modules', $this->getSubModules());
        $this->set('user_permission', $user_permissions);
        $this->viewBuilder()->layout("custom_layout");
    }

    /**
     * Delete method
     *
     * @param string|null $id Page id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $page = $this->Pages->get($id);
        if ($this->Pages->delete($page)) {
            $this->Flash->success(__('The page has been deleted.'));
        } else {
            $this->Flash->error(__('The page could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }


}
