<?php

namespace App\Controller;

use Cake\I18n\I18n;
use Cake\ORM\TableRegistry;
use DateTime;
use ModuleConstants;
use PagesConstants;
use SubModuleConstants;

/**
 * Companies Controller
 *
 * @property \App\Model\Table\CompaniesTable $Companies
 */
class FaprofilesController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadModel('Companies');
        I18n::locale('en_US');
        $this->Auth->allow(['trnsToaws']);
        //$this->loadComponent('Aws');
    }

    public function isAuthorized($user) {
        $request_action = $this->request->params['action'];
        if ($request_action == "bulkAction" || $request_action == "uploadPicture" || $request_action == "removeMedia" || $request_action == "companyActive") {
            return true;
        }
        return parent::isAuthorized($user);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function indexOrg() {
    	$page_limit=10;
    	if (isset($this->request->query['page_limit'])) {
    		$page_limit= $this->request->query('page_limit');
    	}
        $this->paginate = [
            'limit' => $page_limit,
            'order' => [
                'Companies.created_on' => 'desc'
            ]
        ];

        $search = '';
        if (isset($this->request->query['search'])) {
            $search = $this->request->query('search');
        }

        $companies = $this->Companies->find('all')
                ->where(['name LIKE' => '%' . $search . '%'])
                ->orWhere(['name LIKE' => '%' . $search . '%'])
                ->orWhere(['registration_no LIKE' => '%' . $search . '%'])
                ->orWhere(['tax_no LIKE' => '%' . $search . '%'])
                ->orWhere(['email LIKE' => '%' . $search . '%'])
                ->orWhere(['address1 LIKE' => '%' . $search . '%'])
                ->orWhere(['address2 LIKE' => '%' . $search . '%']);

        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('module_pages', $this->getPages());
        $this->set('user_permission', $user_permissions);
        $this->set('bulk_actions', [BULK_ACTION_DELETE => "Move to trash"]);
        $this->set('companies', $this->paginate($companies));
        $this->set('_serialize', ['companies']);
        $this->set('searchText', $search);
        $this->set('page_limit', $page_limit);
        $this->viewBuilder()->layout("custom_layout");
    }

    public function bulkAction() {
        $this->request->allowMethod(['post', 'delete']);
        $selectedCompanies = $this->request->data('selected_content');
        $bulkAction = $this->request->data('bulk_action');
        if ($bulkAction == BULK_ACTION_DELETE) {
            if ($selectedCompanies == "")
                return $this->redirect(['action' => 'index']);
            $companiesToDelete = explode(',', $selectedCompanies);
            $error = $this->deleteAll($companiesToDelete);
            if (!$error) {
                $this->Flash->success(__('All the selected companies have been deleted.'));
            } else {
                $this->Flash->error($error);
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    private function deleteAll($companies) {
        foreach ($companies as &$companyIdWithPrefix) {
            $companyId = str_replace('content_', '', $companyIdWithPrefix);
            $company = $this->Companies->get($companyId);
            if ($this->canCompanyBeDeleted($companyId)) {
                $CmsUserTables = TableRegistry::get('cmsusers');
                $cmsUser = $CmsUserTables->find('all')
                                ->where(['company_id' => $company['id']])->toArray()[0];
                $this->revertPermissions($company, $cmsUser);
                $this->Companies->delete($company);
            } else {
                return (__('The Company ' . $company->name . ' cannot be deleted as it contains related entities'));
            }
        }
    }

    /**
     * View method
     *
     * @param string|null $id Company id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $company = $this->Companies->get($id, [
            'contain' => ['Cmsusers', 'Roles', 'Usergroups']
        ]);

        $this->set('languages', $this->languages);// var $languages member variable of App Controler
        
        $timezone_offset = TableRegistry::get('timezones')->find('all')
                        ->select(['time_zone', 'utc_offset'])
                        ->where(['id' => $company->timezone])->toArray();


        $this->set('timezone_offset', $timezone_offset[0]->time_zone . ' ' . $timezone_offset[0]->utc_offset);

        $this->set('company', $company);
        $this->set('_serialize', ['company']);
        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('pages', $this->getPages());
        $this->set('user_permission', $user_permissions);
        $this->viewBuilder()->layout("custom_layout");
    }

    /**
     * Add method
     * @return \Cake\Network\Response|null
     */
    public function add() {
        $CmsUsersTable = TableRegistry::get('Cmsusers');
        $company = $this->Companies->newEntity();
        $companyBusinessInfo = $this->Companies->newEntity();
        $cmsUser = $CmsUsersTable->newEntity();
        if ($this->request->is('post')) {
        	//print_r($this->request->data);exit;
            $company = $this->Companies->patchEntity($company, $this->request->data('company'));
            $company = $this->fixCompanyForAdd($company);
            $company->logo = $this->request->data("uploaded_file");
            $company->added_by = $this->Auth->user('id');

            $timezone_offset = TableRegistry::get('timezones')->find('all')
                            ->select(['utc_offset'])
                            ->where(['id' => $_POST['company']['timezone']])->toArray();


            $company->timezone_value = $timezone_offset[0]->utc_offset;

            $cmsUser = $CmsUsersTable->patchEntity($cmsUser, $this->request->data('cmsuser'));
            $cmsUser = $this->fixUserForAdd($cmsUser);
            $companyErrors = $this->checkAndDisplayEntityErrors($company);
            $userErrors = $this->checkAndDisplayEntityErrors($cmsUser);


            $password = $this->request->data('cmsuser.password');

            if (!$companyErrors && !$userErrors) {
                $savedCompany = $this->Companies->save($company);
                if ($savedCompany) {
                    $this->Flash->success(__('The company has been saved.'));
                    $cmsUser['company_id'] = $savedCompany['id'];
                    if ($CmsUsersTable->save($cmsUser)) {
                        if ($this->insertSuperUserPermission($company, $cmsUser)) {
                            $this->Flash->success(__('The super admin has been saved.'));
                            //$this->trnsToaws($savedCompany['id']);
                            $template_content = array(
                                    'firstname' => $cmsUser->username,
                                    'user_email' => $cmsUser->email,
                                    'password' => $password,
                                    'loginurl' => APP_SERVER_HOST_URL."admin"                                
                                );

                            $this->sendEmail(MANDRILL_TEMPLATE_USER_CREATION, $template_content, $cmsUser->email);
                        } else {
                            $this->Flash->error(__('The super admin could not be saved. Please, try again.'));
                            $this->revertPermissions($company, $cmsUser);
                            $this->Companies->delete($company);
                            $CmsUsersTable->delete($company);
                        }
                        return $this->redirect(['action' => 'index']);
                    } else {
                        $this->Companies->delete($company);
                        $this->Flash->error(__('The super admin could not be saved. Please, try again.'));
                    }
                } else {
                    $this->Flash->error(__('The company could not be saved. Please, try again.'));
                }
            }
        }

        $timezones_array = TableRegistry::get('timezones')->find()->toArray();

        foreach ($timezones_array as $zone)
            $timezones[$zone->id] = $zone->time_zone . ' ' . $zone->utc_offset;

        $this->set('timezones', $timezones);

        $companies = $this->Companies->find('list', ['limit' => 200]);
        $this->set(compact('company'));
        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('languages', $this->languages);// var $languages member variable of App Controler
        $this->set('module_pages', $this->getPages());
        $this->set('user_permission', $user_permissions);
        $this->set(compact('companyBusinessInfo'));
        $this->set('countries', $this->getCountries());
        $this->set(compact('cmsuser', 'companies'));
        $this->set('_serialize', ['company']);
        $this->viewBuilder()->layout("custom_layout");
    }

    private function checkAndDisplayEntityErrors($entity) {
        $entityErrors = $entity->errors();
        foreach ($entityErrors as $key => $value) {
            foreach ($entityErrors[$key] as $errorKey => $errorValue) {
                $this->Flash->error($errorValue);
            }
        }
        return $entityErrors;
    }

    private function fixCompanyForAdd($company) {
        $company['status'] = 1;
        $company['country'] = $this->getCountries()[$company['country']];
        $company['created_on'] = new DateTime();
        $company['modified_on'] = new DateTime();
        return $company;
    }

    private function fixUserForAdd($cmsUser) {
        $cmsUser['created_on'] = new DateTime();
        $cmsUser['updated_on'] = new DateTime();
        $cmsUser['status'] = 1;
        return $cmsUser;
    }

    /**
     * Edit method
     *
     * @param string|null $id Company id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $CmsUserTable = TableRegistry::get('Cmsusers');
        $company = $this->Companies->get($id, ['contain' => []]);
        $cmsUser = $CmsUserTable->query()->where('company_id=' . $id)->first();

        if ($this->request->is(['patch', 'post', 'put'])) {

            $company = $this->Companies->patchEntity($company, $this->request->data('company'));
            $company = $this->fixCompanyForEdit($company);
            $company->logo = $this->request->data("uploaded_file");

            $timezone_offset = TableRegistry::get('timezones')->find('all')
                            ->select(['utc_offset'])
                            ->where(['id' => $_POST['company']['timezone']])->toArray();


            $company->timezone_value = $timezone_offset[0]->utc_offset;

            $cmsUser = $CmsUserTable->patchEntity($cmsUser, $this->request->data('cmsuser'));
            $cmsUser = $this->fixUserForEdit($cmsUser);

            $companyErrors = $this->checkAndDisplayEntityErrors($company);
            $userErrors = $this->checkAndDisplayEntityErrors($cmsUser);

            if (!$companyErrors && !$userErrors) {
                $savedCompany = $this->Companies->save($company);
                if ($savedCompany) {
                    $this->Flash->success(__('The company has been saved.'));
                    $cmsUser['company_id'] = $savedCompany['id'];

                    if ($CmsUserTable->save($cmsUser)) {
                       // $this->trnsToaws($savedCompany['id']);
                        return $this->redirect(['action' => 'index']);
                    } else {
//                        $this->Companies->delete($company);
                        $this->Flash->error(__('The super admin could not be saved. Please, try again.'));
                    }
                } else {
                    $this->Flash->error(__('The company could not be saved. Please, try again.'));
                }
            }
        }
        $this->set('languages', $this->languages);// var $languages member variable of App Controler

        $timezones_array = TableRegistry::get('timezones')->find()->toArray();

        foreach ($timezones_array as $zone)
            $timezones[$zone->id] = $zone->time_zone . ' ' . $zone->utc_offset;


        $this->set('timezones', $timezones);

        $this->set('company', $company);
        $this->set('cmsuser', $cmsUser);
        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('pages', $this->getPages());
        $this->set('user_permission', $user_permissions);
        $this->set('countries', $this->getCountries());
        $this->set('_serialize', ['company']);
        $this->viewBuilder()->layout("custom_layout");
    }

    /**
     * Edit method
     *
     * @param string|null $id Company id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function index() {
        $id = $this->Auth->user('company_id');
        $CmsUserTable = TableRegistry::get('Cmsusers');
        $company = $this->Companies->get($id, ['contain' => []]);
        $cmsUser = $CmsUserTable->query()->where('company_id=' . $id)->first();

        if ($this->request->is(['patch', 'post', 'put'])) {

            $company = $this->Companies->patchEntity($company, $this->request->data('company'));
//            $company = $this->fixCompanyForEdit($company);
            $company->logo = $this->request->data("uploaded_file");

//            $timezone_offset = TableRegistry::get('timezones')->find('all')
//                            ->select(['utc_offset'])
//                            ->where(['id' => $_POST['company']['timezone']])->toArray();
//
//
//            $company->timezone_value = $timezone_offset[0]->utc_offset;

            $cmsUser = $CmsUserTable->patchEntity($cmsUser, $this->request->data('cmsuser'));
            $cmsUser = $this->fixUserForEdit($cmsUser);

            $companyErrors = $this->checkAndDisplayEntityErrors($company);
            $userErrors = $this->checkAndDisplayEntityErrors($cmsUser);

            if (!$companyErrors && !$userErrors) {
                $savedCompany = $this->Companies->save($company);
                if ($savedCompany) {
                    $this->Flash->success(__('The company has been saved.'));
                    $cmsUser['company_id'] = $savedCompany['id'];

                    if ($CmsUserTable->save($cmsUser)) {
                       // $this->trnsToaws($savedCompany['id']);
                        return $this->redirect(['action' => 'index']);
                    } else {
//                        $this->Companies->delete($company);
                        $this->Flash->error(__('The super admin could not be saved. Please, try again.'));
                    }
                } else {
                    $this->Flash->error(__('The company could not be saved. Please, try again.'));
                }
            }
        }
        $this->set('languages', $this->languages);// var $languages member variable of App Controler

        $timezones_array = TableRegistry::get('timezones')->find()->toArray();

        foreach ($timezones_array as $zone)
            $timezones[$zone->id] = $zone->time_zone . ' ' . $zone->utc_offset;


        $this->set('timezones', $timezones);

        $this->set('company', $company);
        $this->set('cmsuser', $cmsUser);
        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('pages', $this->getPages());
        $this->set('user_permission', $user_permissions);
        $this->set('countries', $this->getCountries());
        $this->set('_serialize', ['company']);
        $this->viewBuilder()->layout("custom_layout");
    }

    public function uploadPicture($type = 'companies') {
        if ($this->Auth->user()) {
            $user_id = $this->Auth->user()['id'];

            if ($this->request->is('post')) {

                $data = $this->request->data;
                $resp = array();

                if (!empty($data['doc_file']['name'])) {
                    $file = $data['doc_file']; //put the data into a var for easy use

                    $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                    $image_ext = array('jpg', 'jpeg', 'gif', 'bmp', 'png');
                    $not_image = '';

                    //only process if the extension is valid
                    if (in_array($ext, $image_ext)) {
                        $curr_time = date('Ymdhis');
                        $new_file_name = $user_id . '_' . $curr_time . '.' . $ext;
                        $mediaPath = '/media/' . $type . '/' . $new_file_name;

                        if (move_uploaded_file($file['tmp_name'], WWW_ROOT . $mediaPath)) {
                            $resp['file_name'] = $new_file_name;
                            echo json_encode($resp);
                        } else {
                            echo 'error';
                        }
                    } else {
                        $not_image = 'yes';
                    }


                    if ($not_image == 'yes') {
                        echo 'not_allowed';
                    }
                }
            }
        }
        exit;
    }

    public function removeMedia() {
        if ($this->Auth->user()) {
            $this->glbl();
            $f_type = $this->request->data('f_type');
            $prev_name = $this->request->data('prev_name');
            $f_name = $this->request->data('f_name');
            $file_url = '';
            if ($f_type == '1') {
                $file_url = substr(WWW_ROOT, '0', '-1') . '/videos/' . $f_name;
                $prev_url = substr(WWW_ROOT, '0', '-1') . '/previews/' . $prev_name;
                unlink($prev_url);
            } else if ($f_type == '2') {
                $file_url = substr(WWW_ROOT, '0', '-1') . '/audios/' . $f_name;
            } else if ($f_type == '3') {
                $file_url = substr(WWW_ROOT, '0', '-1') . '/images/' . $f_name;
            } else if ($f_type == '4') {
                $file_url = substr(WWW_ROOT, '0', '-1') . '/media/companies/' . $f_name;
            }
            unlink($file_url);
        }
        exit;
    }

    private function fixCompanyForEdit($company) {
        $company['country'] = $this->getCountries()[$company['country']];
        return $company;
    }

    private function fixUserForEdit($cmsUser) {
        $cmsUser['updated_on'] = new DateTime();
        $cmsUser['status'] = 1;
        return $cmsUser;
    }

    /**
     * Delete method
     *
     * @param string|null $id Company id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $company = $this->Companies->get($id);
        if ($this->canCompanyBeDeleted($id)) {
            $CmsUserTables = TableRegistry::get('cmsusers');
            $cmsUser = $CmsUserTables->find('all')
                            ->where(['company_id' => $id])->toArray()[0];
            $this->revertPermissions($company, $cmsUser);
            if ($this->Companies->delete($company)) {
                $this->Flash->success(__('The company has been deleted.'));
            } else {
                $this->Flash->error(__('The company could not be deleted. Please, try again.'));
            }
        } else {
            $this->Flash->error(__('The company could not be deleted as it contains related entities'));
        }

        return $this->redirect(['action' => 'index']);
    }

    private function canCompanyBeDeleted($companyId) {
        if ($companyId) {

            //Check roles - Considering that more than 1 role means that it's just the default role.
            $RolesTable = TableRegistry::get('roles');
            $roles = $RolesTable->find('all')
                    ->where(['company_id' => $companyId]);
            if (sizeof($roles->toArray()) > 1)
                return false;

            //Check User Groups - Same logic as roles
            $UserGroupsTable = TableRegistry::get('usergroups');
            $userGroups = $UserGroupsTable->find('all')
                    ->where(['company_id' => $companyId]);
            if (sizeof($userGroups->toArray()) > 1)
                return false;

            //Check CmsUsers - Same logic as usergroups
            $CmsUsersTables = TableRegistry::get('cmsusers');
            $cmsUsers = $CmsUsersTables->find('all')
                    ->where(['company_id' => $companyId]);
            if (sizeof($cmsUsers->toArray()) > 1)
                return false;
        }
        return true;
    }

//    public function getModules() {
//        return array('Company' => '1001');
//    }
//
//    public function getSubModules() {
//        return array('Company Management' =>'2001');
//    }
//
//    public function getPages() {
//        return array('index' =>'3001','view' =>'3005', 'add' =>'3002', 'edit' =>'3003', 'delete' =>'3004');
//    }

    private function insertSuperUserPermission($company, $cmsUser) {

        $rolesTable = TableRegistry::get('roles');
        $pagesTable = TableRegistry::get('pages');
        $userGroupsTable = TableRegistry::get('usergroups');
        $userGroupRolesTable = TableRegistry::get('usergroup_roles');
        $rolePagesTable = TableRegistry::get('role_pages');
        $userUserGroupsTable = TableRegistry::get('cmsuser_usergroups');
        /**
         * 1. create a role for that company into the table "roles"
         * 2. create a usergroup for that company into the table "usergroups"
         * 3. associate newly created usergroup and role into the table "usergroup_roles"
         * 4. Associate the pages to that role into the table "role_pages"
         * 5. Provide Artists and Groups Permission
         */
        $role = $rolesTable->newEntity();
        $role['title'] = $company['name'] . '-super-admin';
        $role['create_on'] = new DateTime();
        $role['modified_on'] = new DateTime();
        $role['status'] = 1;
        $role['company_id'] = $company['id'];

        $role = $rolesTable->save($role);
        if (!$role) {
            return false;
        }

        $userGroup = $userGroupsTable->newEntity();
        $userGroup['group_name'] = $company['name'] . '-super-admin-group';
        $userGroup['created_on'] = new DateTime();
        $userGroup['modified_on'] = new DateTime();
        $userGroup['status'] = 1;
        $userGroup['company_id'] = $company['id'];

        $userGroup = $userGroupsTable->save($userGroup);
        if (!$userGroup) {
            return false;
        }

        $userGroupRole = $userGroupRolesTable->newEntity();
        $userGroupRole['role_id'] = $role['id'];
        $userGroupRole['usergroup_id'] = $userGroup['id'];

        $userGroupRole = $userGroupRolesTable->save($userGroupRole);
        if (!$userGroupRole) {
            return false;
        }

        $userUserGroup = $userUserGroupsTable->newEntity();
        $userUserGroup['usergroup_id'] = $userGroup['id'];
        $userUserGroup['cms_user_id'] = $cmsUser['id'];

        $userUserGroup = $userUserGroupsTable->save($userUserGroup);
        if (!$userUserGroup) {
            return false;
        }

        $pagesWithPermission = $pagesTable->query('SELECT pages.id, pages.sub_module_id, pages.title')
                ->innerJoin('sub_modules', 'pages.sub_module_id = sub_modules.id')
                ->innerJoin('modules', 'sub_modules.module_id = modules.id')
                ->where('modules.id IN (' . 1003 . ',1005)');

        foreach ($pagesWithPermission as $pageWithPermission) {
            $rolePage = $rolePagesTable->newEntity();

            $rolePage['role_id'] = $role['id'];
            $rolePage['page_id'] = $pageWithPermission['id'];
            if (!$rolePagesTable->save($rolePage)) {
                return false;
            }
        }

        $rolePage = $rolePagesTable->newEntity();
        $rolePage['role_id'] = $role['id'];
        //$rolePage['page_id'] = PagesConstants::BASIC_SETTINGS;
        $rolePagesTable->save($rolePage);

//        $rolePage = $rolePagesTable->newEntity();
//        $rolePage['role_id'] = $role['id'];
//        $rolePage['page_id'] = PagesConstants::LIST_PAYMENT;
//        $rolePagesTable->save($rolePage);
//
//        $rolePage = $rolePagesTable->newEntity();
//        $rolePage['role_id'] = $role['id'];
//        $rolePage['page_id'] = PagesConstants::VIEW_PAYMENT_RECORD;
//        $rolePagesTable->save($rolePage);
//
//        $rolePage = $rolePagesTable->newEntity();
//        $rolePage['role_id'] = $role['id'];
//        $rolePage['page_id'] = PagesConstants::LIST_STAR_ACTIVITIES;
//        $rolePagesTable->save($rolePage);
//
//        $rolePage = $rolePagesTable->newEntity();
//        $rolePage['role_id'] = $role['id'];
//        $rolePage['page_id'] = PagesConstants::LIST_UNLOCK_ACTIVITIES;
//        $rolePagesTable->save($rolePage);
//
//        $rolePage = $rolePagesTable->newEntity();
//        $rolePage['role_id'] = $role['id'];
//        $rolePage['page_id'] = PagesConstants::VIEW_UNLOCK_ACTIVITY;
//        $rolePagesTable->save($rolePage);

        return true;
    }

    public function trnsToaws($com_id) {


        $com_info = $this->Companies->find('all')->where(['id' => $com_id])->toArray();

        if (empty($com_info)) {
            die;
        }
        
        $currentTimeStamp = date('Ymdhis');
        
        $file_url = $com_info[0]->logo;

        $file_permission = 'private';

        $file_ext = explode('.', $file_url);
        $new_file_name = '/media/companies/' . $com_id .'_' . $currentTimeStamp . '.' . end($file_ext);

        $prev_tmp_name = substr(WWW_ROOT, '0', '-1') . '/media/companies/' . $file_url;

        if (file_exists($prev_tmp_name)) {
            $bucketName = AWS_OUTPUT_VIDEO_BUCKET_NAME;
            $this->Aws->bucket = $bucketName;

            $this->Aws->upload($prev_tmp_name, $new_file_name, $file_permission);
        }
        $query1 = $this->Companies->query();
        $query1->update()->set([
            'logo' => $com_id .'_' . $currentTimeStamp . '.' . end($file_ext),
        ])->where(['id' => $com_id])->execute();

        if (file_exists($prev_tmp_name))
            unlink($prev_tmp_name);

        return true;
    }

    private function revertPermissions($company, $cmsUser) {
        $rolesTable = TableRegistry::get('roles');
        $role = $rolesTable->find('all')->where(['company_id' => $company['id']])->toArray()[0];

        $userGroupsTable = TableRegistry::get('usergroups');
        $userGroup = $userGroupsTable->find('all')->where(['company_id' => $company['id']])->toArray()[0];

        $rolePagesTable = TableRegistry::get('role_pages');
        $rolePagesTable->deleteAll(['role_id' => $role['id']]);

        $userUserGroupsTable = TableRegistry::get('cmsuser_usergroups');
        $userUserGroup = $userUserGroupsTable->find('all')->where(['cms_user_id' => $cmsUser['id']])->toArray();
        $this->log($userUserGroup);
        if (sizeof($userUserGroup) > 0) {
            $userUserGroupsTable->delete($userUserGroup[0]);
        }

        $userGroupRolesTable = TableRegistry::get('usergroup_roles');
        $userGroupRole = $userGroupRolesTable->find('all')->where(['usergroup_id' => $userGroup['id']])->toArray();
        if (sizeof($userGroupRole) > 0) {
            $this->log($userGroupRole);
            $userGroupRolesTable->delete($userGroupRole[0]);
        }

        $userGroupsTable->delete($userGroup);
        $rolesTable->delete($role);
        $cmsUsersTable = TableRegistry::get('cmsusers');
        $cmsUsersTable->deleteAll(['company_id' => $company['id']]);
    }

    public function companyActive() {

        if ($this->Auth->user()) {

//        $user = $this->Cmsusers->find('all')->where(['fb_id' => $_POST['fb_id']])->first();        
//        $user = $this->Cmsusers->find('all')->where(['id' =>$_POST['com_id']])->toArray();


//
//            $c  = fopen('artist.txt', 'w');
//            fwrite($c, $artist_info[0]->id);            
//            fclose($c);
//
//            exit();

            $companyTable = TableRegistry::get('Companies')->query();

            $ret_val = $companyTable->update()
                    ->set(['status' => 1])
                    ->where(['id' => $_POST['com_id']])
                    ->execute();

            $this->trnsToaws($_POST['com_id']);

            $artistTable = TableRegistry::get('Artists')->query();
            $artistTable->update()
                    ->set(['status' => 1])
                    ->where(['company_id' => $_POST['com_id']])
                    ->execute();

            $artist_info = TableRegistry::get('Artists')->find('all')
                    ->where(['company_id'=>$_POST['com_id']])->toArray();

            $this->trnsToawsArt($artist_info[0]->id);

            $cmsuserTable = TableRegistry::get('Cmsusers')->query();
            $cmsuserTable->update()
                    ->set(['status' => 1])
                    ->where(['company_id' => $_POST['com_id']])
                    ->execute();

            $CmsUserTables = TableRegistry::get('cmsusers');
            $cmsUser = $CmsUserTables->find('all')
                            ->where(['company_id' => $_POST['com_id']])->toArray();

            //$cmsuserTable->find('all')->select(['email'])->where(['company_id'=>$_POST['com_id']])->toArray();
//            $template_content = array(
//                array(
//                    'name' => 'account activation',
//                    'content' => 'Congratulations!! Your account have been activated'
//                )
//            );
            //$this->sendEmail(MANDRILL_TEMPLATE_USER_CREATION, $template_content, $cmsUser[0]->email);

            if ($ret_val) {
                echo "ok";
            }
        }
        die();
    }

 

    public function getCountries() {
        return ["Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica",
            "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain",
            "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina",
            "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso",
            "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile",
            "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the",
            "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti",
            "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia",
            "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana",
            "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece",
            "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands",
            "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)",
            "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of",
            "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya",
            "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives",
            "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of",
            "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal",
            "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island",
            "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines",
            "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis",
            "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal",
            "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa",
            "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname",
            "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan",
            "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan",
            "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands",
            "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands",
            "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe"];
    }

}
