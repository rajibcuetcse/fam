<?php

namespace App\Controller;

use Cake\I18n\I18n;
use ModuleConstants;
use Cake\ORM\TableRegistry;
use PagesConstants;
use SubModuleConstants;
use Cake\Validation\Validator;
/**
 * RolePagesAssociation Controller
 *
 * @property \App\Model\Table\RolePagesAssociationTable $RolePagesAssociation
 */
class RolePagesAssociationController extends AppController {
	public function initialize() {
		parent::initialize ();
		$this->loadModel ( 'Roles' );
		$this->loadModel ( 'Modules' );
		$this->loadModel ( 'RolePages' );
		I18n::locale ( 'en_US' );
	}
	public function isAuthorized($user) {
		$request_action = $this->request->params ['action'];
		if ($request_action == "getAssociatedPages" && $this->Auth->user ()) {
			return true;
		}
		return parent::isAuthorized ( $user );
	}
	
	/**
	 * Index method
	 *
	 * @return void
	 */
	public function index() {
		$userCompanyID = $this->Auth->user ( 'company_id' );
		
		if ($this->Auth->user ( 'id' ) == SUPER_SUPER_ADMIN_ID) {
			$selected_pages = $this->Roles->find ( 'all' )->where ( [ ] );
		} else {
			$selected_pages = $this->Roles->find ( 'all' )->where ( [ 
					'company_id' => $userCompanyID 
			] );
		}
		
		$rolesArray = [ ];
		foreach ( $selected_pages as $role ) {
			$rolesArray [$role->id] = $role->title;
		}
		
		// $companies_id = TableRegistry::get('companies')->find('all')
		// ->select(['id'])
		// ->where(['status' => 1, 'added_by' => SUPER_SUPER_ADMIN_ID])->toArray();
		//
		// foreach ($companies_id as $com_id)
		// $companies[] = $com_id->id;
		if ($this->Auth->user ( 'id' ) == SUPER_SUPER_ADMIN_ID) {
			$modules = $this->Modules->find ( 'all' )->contain ( [ 
					'SubModules',
					'SubModules.Pages' 
			] )->where ( [ 
					'id NOT IN' => [ 
							1001,
							1002 
					] 
			] );
		} else {
			$modules = $this->Modules->find ( 'all' )->contain ( [ 
					'SubModules',
					'SubModules.Pages' 
			] )->where ( [ 
					'id NOT IN' => [ 
							1001,
							1002,
							1007 
					] 
			] );
		}
		
		if ($this->request->is ( 'post' )) {
			if(empty($this->request->data ['role'])){
				$this->Flash->error ( __ ( 'The role can not be empty.' ) );
				return $this->redirect(['action' => 'index']);
			}
			$selected_pages = $this->request->data ( 'selected_pages' );
			if ($selected_pages) {
				$selected_pages = explode ( ',', $selected_pages );
			} else {
				$selected_pages = array ();
			}
			$this->log ( $selected_pages );
			
			$roleID = $this->request->data ( 'role' );
			$this->log ( $roleID );
			
			$deleteAll = $this->RolePages->deleteAll ( [ 
					'role_id' => $roleID 
			] );
			
			if (! empty ( $selected_pages )) {
				foreach ( $selected_pages as $role ) {
					$entity = $this->RolePages->newEntity ();
					$entity->role_id = $roleID;
					$entity->page_id = str_replace ( 'page_', '', $role );
					$this->log ( "inserting.." );
					if (! $this->RolePages->save ( $entity )) {
						$this->Flash->error ( __ ( 'The roles could not be associated. Please, try again.' ) );
						return;
					}
				}
				
				$cms_users = TableRegistry::get ( 'usergroup_roles' )->find ()->select ( [ 
						'usergroup_roles.id' 
				] )->select ( [ 
						'cmsuser_usergroups.cms_user_id' 
				] )->join ( [ 
						'table' => 'cmsuser_usergroups ',
						'alias' => 'cmsuser_usergroups ',
						'type' => 'INNER',
						'conditions' => 'usergroup_roles.usergroup_id =cmsuser_usergroups.usergroup_id' 
				] )->where ( [ 
						'usergroup_roles.role_id' => $roleID 
				] );
				
				foreach ( $cms_users as $user ) {
					$user_id = $user->cmsuser_usergroups ['cms_user_id'];
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
				
				$this->Flash->success ( __ ( 'The roles has been associated to the user group.' ) );
			}
			
		}
		
		$userPermissions = $this->request->session ()->read ( 'user_permissions' );
		
		$this->set ( 'roles', $rolesArray );
		$this->set ( 'modules', $modules );
		$this->set ( 'user_permission', $userPermissions );
		//$this->viewBuilder ()->layout ( "after_login" );
		$this->set('current_module', $this->getModules());
		$this->set('page_list', $this->getPages());
		$nav_arr[0] = array('action'=>'','page_id'=>'','icon'=>'','label'=>'');
		$this->set('nav_arr', $nav_arr);
		$this->viewBuilder()->layout("custom_layout");
	}
	public function getAssociatedPages($roleId) {
		$this->viewBuilder ()->layout ( false );
		
		$selectedPages = $this->RolePages->find ( 'all' )->where ( [ 
				'role_id' => $roleId 
		] )->toArray ();
		
		$selectedPagesID = [ ];
		foreach ( $selectedPages as $page ) {
			array_push ( $selectedPagesID, 'page_' . $page->page_id );
		}
		
		// if (!empty($selectedPagesID)) {
		// $selectedPages = $this->Pages->find('all')->where([
		// 'id IN' => $selectedPagesID
		// ]);
		// } else {
		// $selectedPages = array();
		// }
		
		$jsonObject = [ 
				'selected_pages' => $selectedPagesID 
		];
		
		echo json_encode ( $jsonObject );
		die ();
	}
	
	/**
	 * View method
	 *
	 * @param string|null $id
	 *        	Role Pages Association id.
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function view($id = null) {
		$rolePagesAssociation = $this->RolePagesAssociation->get ( $id, [ 
				'contain' => [ ] 
		] );
		$this->set ( 'rolePagesAssociation', $rolePagesAssociation );
		$this->set ( '_serialize', [ 
				'rolePagesAssociation' 
		] );
	}
	
	/**
	 * Add method
	 *
	 * @return void Redirects on successful add, renders view otherwise.
	 */
	public function add() {
		$rolePagesAssociation = $this->RolePagesAssociation->newEntity ();
		if ($this->request->is ( 'post' )) {
			$rolePagesAssociation = $this->RolePagesAssociation->patchEntity ( $rolePagesAssociation, $this->request->data );
			if ($this->RolePagesAssociation->save ( $rolePagesAssociation )) {
				$this->Flash->success ( __ ( 'The role pages association has been saved.' ) );
				return $this->redirect ( [ 
						'action' => 'index' 
				] );
			} else {
				$this->Flash->error ( __ ( 'The role pages association could not be saved. Please, try again.' ) );
			}
		}
		$this->set ( compact ( 'rolePagesAssociation' ) );
		$this->set ( '_serialize', [ 
				'rolePagesAssociation' 
		] );
	}
	
	/**
	 * Edit method
	 *
	 * @param string|null $id
	 *        	Role Pages Association id.
	 * @return void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null) {
		$rolePagesAssociation = $this->RolePagesAssociation->get ( $id, [ 
				'contain' => [ ] 
		] );
		if ($this->request->is ( [ 
				'patch',
				'post',
				'put' 
		] )) {
			$rolePagesAssociation = $this->RolePagesAssociation->patchEntity ( $rolePagesAssociation, $this->request->data );
			if ($this->RolePagesAssociation->save ( $rolePagesAssociation )) {
				$this->Flash->success ( __ ( 'The role pages association has been saved.' ) );
				return $this->redirect ( [ 
						'action' => 'index' 
				] );
			} else {
				$this->Flash->error ( __ ( 'The role pages association could not be saved. Please, try again.' ) );
			}
		}
		$this->set ( compact ( 'rolePagesAssociation' ) );
		$this->set ( '_serialize', [ 
				'rolePagesAssociation' 
		] );
	}
	
	/**
	 * Delete method
	 *
	 * @param string|null $id
	 *        	Role Pages Association id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function delete($id = null) {
		$this->request->allowMethod ( [ 
				'post',
				'delete' 
		] );
		$rolePagesAssociation = $this->RolePagesAssociation->get ( $id );
		if ($this->RolePagesAssociation->delete ( $rolePagesAssociation )) {
			$this->Flash->success ( __ ( 'The role pages association has been deleted.' ) );
		} else {
			$this->Flash->error ( __ ( 'The role pages association could not be deleted. Please, try again.' ) );
		}
		return $this->redirect ( [ 
				'action' => 'index' 
		] );
	}
	public function getModules() {
		return array (
				'Access Control' => '1003' 
		);
	}
	public function getSubModules() {
		return array (
				'Role & Page Association' => '2054' 
		);
	}
	public function getPages() {
		return array (
				'index' => '3078' 
		);
	}
}
