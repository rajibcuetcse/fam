<?php

namespace App\Controller;

use Cake\I18n\I18n;
use Cake\ORM\TableRegistry;

/**
 * UserGroupRoleAssociation Controller
 *
 * @property \App\Model\Table\UserGroupRoleAssociationTable $UserGroupRoleAssociation
 */
class UserGroupRoleAssociationController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadModel('UsergroupRoles');
        $this->loadModel('Roles');
        $this->loadModel('Usergroups');
        I18n::locale('en_US');
    }

    public function isAuthorized($user) {
        $request_action = $this->request->params['action'];
        if ($request_action == "getRoles" && $this->Auth->user()) {
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

        if ($this->Auth->user('id') == SUPER_SUPER_ADMIN_ID) {
            $usergroups = $this->Usergroups->find('all')->where([
            ]);
        } else {
            $usergroups = $this->Usergroups->find('all')->where([
                'company_id' => $this->Auth->user('company_id')
            ]);
        }

        $userArray = [];
        foreach ($usergroups as $group) {
            $userArray[$group->id] = $group->group_name;
        }

        if ($this->request->is('post')) {
            $roles = $this->request->data('roles');
            $user_groupID = $this->request->data('user_groups');

            $this->UsergroupRoles->deleteAll(['usergroup_id' => $user_groupID]);
            if (!empty($roles)) {
                foreach ($roles as $role) {
                    $entity = $this->UsergroupRoles->newEntity();
                    $entity->usergroup_id = $user_groupID;
                    $entity->role_id = $role;
                    if (!$this->UsergroupRoles->save($entity)) {
                    	/* Update group users permission Version */
                    	$cms_users = TableRegistry::get ( 'cmsuser_usergroups' )->find ('all')->where ( [
                    			'usergroup_id' => $user_groupID
                    	] );
                    	
                    	foreach ( $cms_users as $user ) {
                    		$user_id = $user->cms_user_id;
                    		$current_permission_version = TableRegistry::get ( 'cmsusers' )->get ( $user_id )->permission_version;
                    		if ($current_permission_version == "999") {
                    			$current_permission_version = 0;
                    		}
                    			
                    		$query = TableRegistry::get ( 'cmsusers' )->query ();
                    		$query->update ()->set ( [
                    				'permission_version' => $current_permission_version + 1
                    		] )->where ( [
                    				'id' => $user_id
                    		] )->execute ();
                    	}
                    	/* end group users permission Version*/
                        $this->Flash->error(__('The roles could not be associated. Please, try again.'));
                        return;
                    }
                }
                $this->Flash->success(__('The roles has been associated to the user group.'));
            } else {
                $this->Flash->success(__('The roles has been deleted from the user group.'));
            }
        }

        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('user_permission', $user_permissions);
        $this->set('user_groups', $userArray);
        //$this->viewBuilder()->layout('usergroup_management');
        $this->set('current_module', $this->getModules());
        $this->set('page_list', $this->getPages());
        $this->viewBuilder()->layout('custom_layout');
    }

    public function getRoles($userGroupID) {

        $this->viewBuilder()->layout(false);

        if ($this->Auth->user('company_id') == SUPER_SUPER_ADMIN_ID) {

            $company_id_of_userGroupID = TableRegistry::get('usergroups')->find('all')
                            ->select(['company_id'])->where(['id' => $userGroupID])->toArray();

            $com_id = $company_id_of_userGroupID[0]->company_id;
        } else {
            $com_id = $this->Auth->user('company_id');
        }

        //exit();

        $selectedRoles = $this->UsergroupRoles->find('all')->where([
            'usergroup_id' => $userGroupID
        ]);

        $selectedRoleIDs = [];
        foreach ($selectedRoles as $role) {
            array_push($selectedRoleIDs, $role->role_id);
        }

        if (!empty($selectedRoleIDs)) {
            $selectedRoles = $this->Roles->find('all')->where([
                'id IN' => $selectedRoleIDs,
                'company_id' => $com_id
            ]);
        } else {
            $selectedRoles = array();
        }


        $roles = [];
        if (!empty($selectedRoleIDs)) {

            $roles = $this->Roles->find('all')->where([
                'company_id' => $com_id,
                'id NOT IN' => $selectedRoleIDs
            ]);
        } else {

            $roles = $this->Roles->find('all')->where([
                'company_id' => $com_id
            ]);
        }

        $this->log($roles);
        $jsonObject = [
            'selected_roles' => $selectedRoles,
            'available_roles' => $roles
        ];

        echo json_encode($jsonObject);
        die();
    }

  

}
