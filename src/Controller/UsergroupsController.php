<?php

namespace App\Controller;

use Cake\I18n\I18n;
use Cake\ORM\TableRegistry;
use ModuleConstants;
use PagesConstants;
use SubModuleConstants;

/**
 * Usergroups Controller
 *
 * @property \App\Model\Table\UsergroupsTable $Usergroups
 */
class UsergroupsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadModel('Cmsusers');
        I18n::locale('en_US');
    }

    public function isAuthorized($user) {
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
    public function index() {
    	$page_limit=10;
    	if (isset($this->request->query['page_limit'])) {
    		$page_limit= $this->request->query('page_limit');
    	}
        $this->paginate = [
            'limit' => $page_limit
        ];

        $search = '';
        if (isset($this->request->query['search'])) {
            $search = $this->request->query('search');
        }
        if ($this->Auth->user('id') == SUPER_SUPER_ADMIN_ID) {
            $usergroups = $this->Usergroups->find('all')->where([
                'group_name LIKE' => '%' . $search . '%',
            ]);
        } else {
            $usergroups = $this->Usergroups->find('all')->where([
                'group_name LIKE' => '%' . $search . '%',
                'company_id' => $this->Auth->user('company_id')
            ]);
        }

        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('user_permission', $user_permissions);
        $this->set('searchText', $search);
        $this->set('bulk_actions', [BULK_ACTION_DELETE => "Move to trash"]);
        $this->set('usergroups', $this->paginate($usergroups));
        $this->set('_serialize', ['usergroups']);
        //$this->viewBuilder()->layout('usergroup_management');
        $this->set('current_module', $this->getModules());
        $this->set('module_pages', $this->getPages());
        $this->set('page_list', $this->getPages());
        $this->set('page_limit', $page_limit);
        $nav_arr[0] = array('action'=>'add','page_id'=>'3066','icon'=>'<i class="fa fa-plus-circle"></i>','label'=>'Add');
        $this->set('nav_arr', $nav_arr);
        $this->viewBuilder()->layout('custom_layout');
    }

    /**
     * View method
     *
     * @param string|null $id Usergroup id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $usergroup = $this->Usergroups->get($id, [
            'contain' => ['Companies', 'UsergroupRoles']
        ]);
        $this->set('usergroup', $usergroup);
        $this->set('_serialize', ['usergroup']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $user_group = $this->Usergroups->newEntity();
        $table_user_groups_user = TableRegistry::get("CmsuserUsergroups");

        if ($this->request->is('post')) {

            $user_group = $this->Usergroups->patchEntity($user_group, $this->request->data);
            $user_group->status = STATUS_ACTIVE;
            $user_group->created_on = date('Y-m-d H:i:s');
            $user_group->modified_on = date('Y-m-d H:i:s');
            $user_group->company_id = $this->Auth->user('company_id');

            if ($this->Usergroups->save($user_group)) {

                $users = $this->request->data('cmsusers');

                foreach ($users as $user) {
                    $entity = $table_user_groups_user->newEntity();
                    $entity->cms_user_id = $user;
                    $entity->usergroup_id = $user_group->id;
                    $table_user_groups_user->save($entity);
                }

                $this->Flash->success(__('The User Group has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $errors = $user_group->errors();
                if ($errors['group_name']) {
                    $this->Flash->error($errors['group_name']['valid']);
                } else {
                    $this->Flash->error(__('The User Group could not be saved. Please, try again.'));
                }
            }
        }

        $usersIDS = $table_user_groups_user->find('all')->select('cms_user_id');

        if ($this->Auth->user('company_id') == SUPER_SUPER_ADMIN_ID) {
            $users = $this->Cmsusers->find('all')->where([
                'id NOT IN' => $usersIDS
            ]);
        } else {
            $users = $this->Cmsusers->find('all')->where([
                'id NOT IN' => $usersIDS,
                'company_id' => $this->Auth->user('company_id')
            ]);
        }

//        echo "<pre>";
//        print_r($usersIDS);
//        echo "<pre>";
//        exit();

        $user_permissions = $this->request->session()->read('user_permissions');

        $this->set('user_permission', $user_permissions);
        $this->set('users', $users);
        $this->set(compact('user_group'));
        $this->set('_serialize', ['user_group']);
        $this->set('current_module', $this->getModules());
        $nav_arr[0] = array('action'=>'index','page_id'=>'3045','icon'=>'<i class="fa fa-list"></i>','label'=>'List');
        $this->set('nav_arr', $nav_arr);
        $this->viewBuilder()->layout('custom_layout');
    }

    /**
     * Edit method
     *
     * @param string|null $id Usergroup id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $usergroup = $this->Usergroups->get($id, [
            'contain' => []
        ]);

        $table_user_groups_user = TableRegistry::get("CmsuserUsergroups");

        if ($this->request->is(['patch', 'post', 'put'])) {


            if ($usergroup->group_name != trim($this->request->data['group_name'])) {
                $usergroup = $this->Usergroups->patchEntity($usergroup, $this->request->data);
            }


            if ($this->Usergroups->save($usergroup)) {

                $users = $this->request->data('cmsusers');
                $table_user_groups_user->deleteAll(['usergroup_id' => $id]);
                if (!empty($users)) {
                    foreach ($users as $user) {
                        $entity = $table_user_groups_user->newEntity();
                        $entity->cms_user_id = $user;
                        $entity->usergroup_id = $usergroup->id;
                        $table_user_groups_user->save($entity);
                    }
                }

                $this->Flash->success(__('The usergroup has been updated.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The usergroup could not be saved. Please, try again.'));
            }
        }
        $user_permissions = $this->request->session()->read('user_permissions');

        $usersIDS = $table_user_groups_user->find('all')->select('cms_user_id');

        if ($this->Auth->user('company_id') == SUPER_SUPER_ADMIN_ID) {
            $users = $this->Cmsusers->find('all')->where([
                'id NOT IN' => $usersIDS
            ]);
        } else {
            $users = $this->Cmsusers->find('all')->where([
                'id NOT IN' => $usersIDS,
                'company_id' => $this->Auth->user('company_id')
            ]);
        }

        $selectedusers = $usersIDS = $table_user_groups_user->find('all')->where(['usergroup_id' => $id])->toArray();

        $selectedUserIDs = array();
        if (!empty($selectedusers)) {
            foreach ($selectedusers as $uid) {
                array_push($selectedUserIDs, $uid->cms_user_id);
            }
        }
        if (!empty($selectedUserIDs)) {
            if ($this->Auth->user('company_id') == SUPER_SUPER_ADMIN_ID) {
                $selectedusers = $this->Cmsusers->find('all')->where([
                    'id IN' => $selectedUserIDs
                ]);
            } else {
                $selectedusers = $this->Cmsusers->find('all')->where([
                    'id IN' => $selectedUserIDs,
                    'company_id' => $this->Auth->user('company_id')
                ]);
            }
        }

        $this->set('user_permission', $user_permissions);
        $this->set('users', $users);
        $this->set('selectedusers', $selectedusers);
        $this->set(compact('usergroup', 'companies'));
        $this->set('_serialize', ['usergroup']);
        $this->set('current_module', $this->getModules());
        $nav_arr[0] = array('action'=>'index','page_id'=>'3045','icon'=>'<i class="fa fa-list"></i>','label'=>'List');
        $this->set('nav_arr', $nav_arr);
        $this->viewBuilder()->layout('custom_layout');
    }

    /**
     * Delete method
     *
     * @param string|null $id Usergroup id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $usergroup = $this->Usergroups->get($id, [
            'contain' => ['CmsuserUsergroups', 'UsergroupRoles']
        ]);

        if (empty($usergroup->cmsuser_usergroups)) {
            if (empty($usergroup->usergroup_roles)) {

                if ($this->Usergroups->delete($usergroup)) {
                    $this->Flash->success(__('The Usergroup has been deleted.'));
                } else {
                    $this->Flash->error(__('The Usergroup could not be deleted. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('The Usergroup is associated with roles, so could not be deleted.'));
            }
        } else {
            $this->Flash->error(__('The Usergroup contains users so could not be deleted.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function bulkAction() {
        $this->request->allowMethod(['post', 'delete']);
        $selectedUsergroups = $this->request->data('selected_content');
        $bulkAction = $this->request->data('bulk_action');

        if ($bulkAction == BULK_ACTION_DELETE) {
            if ($selectedUsergroups == "")
                return $this->redirect(['action' => 'index']);
            $usergroupsToDelete = explode(',', $selectedUsergroups);
            $error = $this->deleteAll($usergroupsToDelete);
            if (!$error) {
                $this->Flash->success(__('All the selected usergroups has been deleted.'));
            } else {
                $this->Flash->error($error);
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    private function deleteAll($usergroups) {
        foreach ($usergroups as &$usergroupID) {
            $usergroupID = str_replace('content_', '', $usergroupID);

            $usergroup = $this->Usergroups->get($usergroupID, [
                'contain' => ['CmsuserUsergroups', 'UsergroupRoles']
            ]);

            if (empty($usergroup->cmsuser_usergroups)) {
                if (empty($usergroup->usergroup_roles)) {

                    if (!$this->Usergroups->delete($usergroup)) {
                        return (__('The Usergroup' . $usergroup->group_name . ' could not be deleted. Please, try again.'));
                    }
                } else {
                    return (__('The Usergroup ' . $usergroup->group_name . ' is associated with roles, so could not be deleted.'));
                }
            } else {
                return (__('The Usergroup ' . $usergroup->group_name . ' contains users so could not be deleted.'));
            }
        }
    }

 
    public function getModules()
    {
    	return array('Access Control' =>'1003');
    }
    
    public function getSubModules()
    {
    	return array(
    			'User Management' => '2050',
    			'Role Management' =>'2051',
    			'User Group Management' =>'2052',
    			'User Group & Role Association' =>'2053',
    			'Role & Page Association' => '2054'
    
    	);
    }
    
    
    public function getPages() {
        return array(
            'index' => '3065',
            'add' =>'3066',
            'edit' =>'3067',
            'delete' => '3068'
        );
    }

}
