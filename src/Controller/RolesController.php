<?php
namespace App\Controller;

use Cake\I18n\I18n;
use ModuleConstants;
use PagesConstants;
use SubModuleConstants;
use Cake\ORM\TableRegistry;
use Cake\ORM\Query;
/**
 * Roles Controller
 *
 * @property \App\Model\Table\RolesTable $Roles
 */
class RolesController extends AppController
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
        ];
        $search = '';
        if (isset($this->request->query['search'])) {
            $search = $this->request->query('search');
        }

        if ($this->Auth->user('id') == SUPER_SUPER_ADMIN_ID) {
            $roles = $this->Roles->find('all')->where([
                'title LIKE' => '%' . $search . '%',
            ]);
        } else {
            $roles = $this->Roles->find('all')->where([
                'title LIKE' => '%' . $search . '%',
                'company_id' => $this->Auth->user('company_id')
            ]);
        }

        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('user_permission', $user_permissions);
        $this->set('searchText', $search);
        $this->set('bulk_actions', [BULK_ACTION_DELETE => "Move to trash"]);
        $this->set('roles', $this->paginate($roles));
        $this->set('_serialize', ['roles']);
        //$this->viewBuilder()->layout('role_management');
        $this->set('current_module', $this->getModules());
        $this->set('module_pages', $this->getPages());
        $this->set('page_list', $this->getPages());
        $nav_arr[0] = array('action'=>'add','page_id'=>'3056','icon'=>'<i class="fa fa-plus-circle"></i>','label'=>'Add');
        $this->set('nav_arr', $nav_arr);
        $this->set('page_limit', $page_limit);
        $this->viewBuilder()->layout('custom_layout');
    }

    /**
     * View method
     *
     * @param string|null $id Role id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => ['Companies', 'RolePages']
        ]);
        $this->set('role', $role);
        $this->set('_serialize', ['role']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $role = $this->Roles->newEntity();
        if ($this->request->is('post')) {
            $role = $this->Roles->patchEntity($role, $this->request->data);
            $role->status = STATUS_ACTIVE;
            $role->created_on = date('Y-m-d H:i:s');
            $role->modified_on = date('Y-m-d H:i:s');
            $role->company_id = $this->Auth->user('company_id');

            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $errors = $role->errors();
                if ($errors['title']) {
                    $this->Flash->error(__('The role title is not unique'));
                } else {
                    $this->Flash->error(__('The role could not be saved. Please, try again.'));
                }
            }
        }
        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('user_permission', $user_permissions);
        $this->set(compact('role'));
        $this->set('_serialize', ['role']);
        $this->set('current_module', $this->getModules());
        $nav_arr[0] = array('action'=>'index','page_id'=>'3055','icon'=>'<i class="fa fa-list"></i>','label'=>'List');
        $this->set('nav_arr', $nav_arr);
        $this->viewBuilder()->layout('custom_layout');
    }

    /**
     * Edit method
     *
     * @param string|null $id Role id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $role = $this->Roles->patchEntity($role, $this->request->data);
//            $role->title = $this->request->data('role_name');
            $query = $this->Roles->query();
            $update = $query->update()
            ->set(['title' => $this->request->data['title']])
            		->where(['id' => $this->request->data['id']])
            		->execute();
            if ($update) {
            //if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been updated.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The role could not be saved. Please, try again.'));
            }
        }
        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('user_permission', $user_permissions);
        $this->set(compact('role'));
        $this->set('_serialize', ['role']);
        $this->set('current_module', $this->getModules());
        $nav_arr[0] = array('action'=>'index','page_id'=>'3055','icon'=>'<i class="fa fa-list"></i>','label'=>'List');
        $this->set('nav_arr', $nav_arr);
        $this->viewBuilder()->layout('custom_layout');
    }

    /**
     * Delete method
     *
     * @param string|null $id Role id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $role = $this->Roles->get($id, [
            'contain' => ['RolePages']
        ]);

        if (empty($role->role_pages)) {
            if ($this->Roles->delete($role)) {
                $this->Flash->success(__('The role has been deleted.'));
            } else {
                $this->Flash->error(__('The role could not be deleted. Please, try again.'));
            }
        } else {
            $this->Flash->error(__('The role contains Pages so could not be deleted.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function bulkAction()
    {
        $this->request->allowMethod(['post', 'delete']);
        $selectedRoles = $this->request->data('selected_content');
        $bulkAction = $this->request->data('bulk_action');

        if ($bulkAction == BULK_ACTION_DELETE) {
            if ($selectedRoles == "") return $this->redirect(['action' => 'index']);
            $rolesToDelete = explode(',', $selectedRoles);
            $error = $this->deleteAll($rolesToDelete);
            if (!$error) {
                $this->Flash->success(__('All the selected roles has been deleted.'));
            } else {
                $this->Flash->error($error);
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    private function deleteAll($roles)
    {
        foreach ($roles as &$roleID) {
            $roleID = str_replace('content_', '', $roleID);

            $role = $this->Roles->get($roleID, [
                'contain' => ['RolePages']
            ]);

            if (empty($role->role_pages)) {
                if (!$this->Roles->delete($role)) {
                    return (__('The role ' . $role->title . ' could not be deleted. Please, try again.'));
                }
            } else {
                return (__('The role ' . $role->title . ' contains Pages so could not be deleted.'));
            }
        }
    }

    
}
