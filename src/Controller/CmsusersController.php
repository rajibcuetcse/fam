<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\I18n;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use DateTime;
use Mandrill;

/**
 * Cmsusers Controller
 *
 * @property \App\Model\Table\CmsusersTable $Cmsusers
 */
class CmsusersController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadModel('Cmsusers');
        $this->loadModel('Usergroups');
        I18n::locale('en_US');
        $this->Auth->allow(['forgotPassword']);
        $this->Auth->allow(['resetPassword']);
        $this->Auth->allow(['termsService']);
        $this->Auth->allow(['fbLogin']);
        $this->Auth->allow(['fbLoginRegister']);
        $this->Auth->allow(['checkArtistRegistered']);
        $this->Auth->allow(['uploadPicture']);
        $this->Auth->allow(['removeMedia']);
        $this->Auth->allow(['uploadArtistPicture']);
        $this->Auth->allow(['removeArtistMedia']);
        $this->Auth->allow(['emailSent']);
        $this->Auth->allow(['changeLanguage']);
    }

    public function isAuthorized($user) {
        $request_action = $this->request->params['action'];
        if ($request_action == "logout" || $request_action == "login" || $request_action == "bulkAction" || $request_action == "terms" || $request_action == "editProfile") {
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
        if ($this->Auth->user()) {
        	$page_limit=10;
        	if (isset($this->request->query['page_limit'])) {
        		$page_limit= $this->request->query('page_limit');
        	}
            $this->paginate = [
                'limit' => $page_limit,
                'contain' => ['Companies']
            ];

            $search = '';
            if (isset($this->request->query['search'])) {
                $search = $this->request->query('search');
            }
            if ($this->Auth->user('id') == SUPER_SUPER_ADMIN_ID) {
                $users = $this->Cmsusers->find('all')->where([
                    'username LIKE' => '%' . $search . '%',
                ]);
            } else {
                $users = $this->Cmsusers->find('all')->where([
                    'username LIKE' => '%' . $search . '%',
                    'company_id' => $this->Auth->user('company_id')
                ]);
            }


            $user_permissions = $this->request->session()->read('user_permissions');
            $this->set('user_permission', $user_permissions);
            $this->set('bulk_actions', [BULK_ACTION_DELETE => "Move to trash"]);
            $this->set('cmsusers', $this->paginate($users));
            $this->set('searchText', $search);
            $this->set('_serialize', ['cmsusers']);
            //$this->viewBuilder()->layout("user_management");
            $this->set('current_module', $this->getModules());
            $this->set('page_list', $this->getPages());
            $this->set('module_pages', $this->getPages());
            $nav_arr[0] = array('action'=>'add','page_id'=>'3046','icon'=>'<i class="fa fa-plus-circle"></i>','label'=>'Add');
            $this->set('nav_arr', $nav_arr);
            $this->set('page_limit', $page_limit);
            $this->viewBuilder()->layout("custom_layout");
        } else {
            $this->redirect($this->Auth->redirectUrl());
        }
    }

    /**
     * View method
     *
     * @param string|null $id Cmsuser id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $cmsuser = $this->Cmsusers->get($id, [
            'contain' => ['Companies', 'CmsuserUsergroups']
        ]);

        $usergroup = array();
        if (!(empty($cmsuser->cmsuser_usergroups))) {
            $usergroup = $this->Usergroups->get($cmsuser->cmsuser_usergroups[0]->usergroup_id);
        }

        $languages = [LANGUAGE_CODE_ENGLISH => 'English', LANGUAGE_CODE_KOREAN => 'Korean'];
        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('user_permission', $user_permissions);
        $this->set('languages', $languages);
        $this->set('cmsuser', $cmsuser);
        $this->set('usergroup', $usergroup);
        $this->set('_serialize', ['cmsuser']);
        $this->set('current_module', $this->getModules());
        $nav_arr[0] = array('action'=>'index','page_id'=>'3045','icon'=>'<i class="fa fa-list"></i>','label'=>'List');
        $this->set('nav_arr', $nav_arr);
        $this->viewBuilder()->layout("custom_layout");
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $cmsuser = $this->Cmsusers->newEntity();
        if ($this->request->is('post')) {
        	//pr($this->request->data);exit;
        	$result=$this->Cmsusers->find('all',['fields'=>'id'])->last();        	
        	$second_last_insert_id=$result->id;
        	$last_insert_id = $second_last_insert_id+1;
        	if (!is_dir('media/companies/'.$last_insert_id)) {
        		mkdir('media/companies/'.$last_insert_id, 0777, true);
        	}
        	$imagedes = $this->request->webroot.'webroot/media/companies/'.$last_insert_id;
        	//$imagepath = 'webroot/media/companies/'.$last_insert_id.'/'.$this->request->data['img_path']['name'];
        	$imagepath = 'media/companies/'.$last_insert_id.'/'.$this->request->data['img_path']['name'];
	        if (!empty($this->request->data['img_path']['name'])) {
				$file = $this->request->data['img_path']; //put the data into a var for easy use
				
				$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
				$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
				
				//only process if the extension is valid
				if (in_array($ext, $arr_ext)) {
				    //do the actual uploading of the file. First arg is the tmp name, second arg is 
				    //where we are putting it
				    move_uploaded_file($_FILES["img_path"]["tmp_name"],WWW_ROOT.'media/companies/'.$last_insert_id.'/'. basename($_FILES['img_path']['name']));
				    } else{
				    	$this->Flash->error(__('Profile Picture is not in right format.Please, try again.'));
				    	return $this->redirect(['action' => 'add']);
				    }
				    $this->request->data['img_path'] = $imagepath;
				}
            
        	$cmsuser = $this->createUser($cmsuser);
            $password = $this->request->data('password');
            if ($this->Cmsusers->save($cmsuser)) {
                $this->Flash->success(__('The user has been saved.'));

                $template_content = array(
                    array(
                        'name' => 'firstname',
                        'content' => $cmsuser->username
                    ),
                    array(
                        'name' => 'user_email',
                        'content' => $cmsuser->email
                    ),
                    array(
                        'name' => 'password',
                        'content' => $password
                    ),
                    array(
                        'name' => 'login_url',
                        'content' => APP_SERVER_HOST_URL
                ));

                $this->sendEmail(MANDRILL_TEMPLATE_USER_CREATION, $template_content, $cmsuser->email);


                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
                $this->log($cmsuser->errors());
            }
        }
        $languages = [LANGUAGE_CODE_ENGLISH => 'English', LANGUAGE_CODE_KOREAN => 'Korean'];
        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('user_permission', $user_permissions);
        $this->set('cmsuser', $cmsuser);
        $this->set('languages', $languages);
        $this->set('_serialize', ['cmsuser']);
        $this->set('current_module', $this->getModules());
        $nav_arr[0] = array('action'=>'index','page_id'=>'3045','icon'=>'<i class="fa fa-list"></i>','label'=>'List');
        $this->set('nav_arr', $nav_arr);
        $this->viewBuilder()->layout("custom_layout");
    }

    /**
     * Edit method
     *
     * @param string|null $id Cmsuser id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $cmsuser = $this->Cmsusers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
        	//pr($this->request->data);exit;
        	if(!empty($this->request->data['img_path']['name'])){
        		$id = $this->request->params['pass'][0];
        		if(!empty($this->request->data['previous_img_path'])){
        			unlink(WWW_ROOT.'/'.$this->request->data['previous_img_path']);
        		}
        		$imagedes = $this->request->webroot.'webroot/media/companies/'.$id;
        		//$imagepath = 'webroot/media/companies/'.$last_insert_id.'/'.$this->request->data['img_path']['name'];
        		$imagepath = 'media/companies/'.$id.'/'.$this->request->data['img_path']['name'];
        			$file = $this->request->data['img_path']; //put the data into a var for easy use
        		
        			$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
        			$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
        		
        			//only process if the extension is valid
        			if (in_array($ext, $arr_ext)) {
        				//do the actual uploading of the file. First arg is the tmp name, second arg is
        				//where we are putting it
        				move_uploaded_file($_FILES["img_path"]["tmp_name"],WWW_ROOT.'media/companies/'.$id.'/'. basename($_FILES['img_path']['name']));
        			} else{
        				$this->Flash->error(__('Profile Picture is not in right format.Please, try again.'));
        				return $this->redirect(['action' => 'edit']);
        			}
        		$this->request->data['img_path'] = $imagepath;
        	}  else{
        		$this->request->data['img_path'] = $this->request->data['previous_img_path'];
        	}
            $cmsuser = $this->Cmsusers->patchEntity($cmsuser, $this->request->data);
            if ($this->Cmsusers->save($cmsuser)) {
                $this->Flash->success(__('The cmsuser has been updated.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The cmsuser could not be saved. Please, try again.'));
            }
        }

        $languages = [LANGUAGE_CODE_ENGLISH => 'English', LANGUAGE_CODE_KOREAN => 'Korean'];
        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('user_permission', $user_permissions);
        $this->set('cmsuser', $cmsuser);
        $this->set('languages', $languages);
        $this->set('_serialize', ['cmsuser']);
        $this->set('current_module', $this->getModules());
        $nav_arr[0] = array('action'=>'index','page_id'=>'3045','icon'=>'<i class="fa fa-list"></i>','label'=>'List');
        $this->set('nav_arr', $nav_arr);
        $this->viewBuilder()->layout("custom_layout");
    }

    /**
     * Delete method
     *
     * @param string|null $id Cmsuser id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $cmsuser = $this->Cmsusers->get($id, [
            'contain' => ['Companies', 'CmsuserUsergroups']
        ]);

        if (empty($cmsuser->cmsuser_usergroups)) {
            if ($this->Cmsusers->updateAll(['status' => STATUS_NOT_ACTIVE], ['id' => $id])) {
                $this->Flash->success(__('The user has been deleted.'));
            } else {
                $this->Flash->error(__('The user could not be deleted. Please, try again.'));
            }
        } else {
            $this->Flash->error(__('The user is assigned to a usergroup so could not be deleted.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function bulkAction() {
        $this->request->allowMethod(['post', 'delete']);
        $selectedUsers = $this->request->data('selected_content');
        $bulkAction = $this->request->data('bulk_action');

        if ($bulkAction == BULK_ACTION_DELETE) {
            if ($selectedUsers == "")
                return $this->redirect(['action' => 'index']);
            $usersToDelete = explode(',', $selectedUsers);
            $error = $this->deleteAll($usersToDelete);
            if (!$error) {
                $this->Flash->success(__('All the selected users has been deleted.'));
            } else {
                $this->Flash->error($error);
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    private function deleteAll($users) {
        foreach ($users as &$user) {
            $user = str_replace('content_', '', $user);

            $cmsuser = $this->Cmsusers->get($user, [
                'contain' => ['Companies', 'CmsuserUsergroups']
            ]);

            if (empty($cmsuser->cmsuser_usergroups)) {
                if (!($this->Cmsusers->updateAll(['status' => STATUS_NOT_ACTIVE], ['id' => $user]))) {
                    return (__('The user ' . $cmsuser->username . ' could not be deleted. Please, try again.'));
                }
            } else {
                return (__('The user ' . $cmsuser->username . ' is assigned to a usergroup so could not be deleted.'));
            }
        }
    }

    public function forgotPassword() {
    	$this->viewBuilder()->layout('before_login');
        $this->set('msg', '');
        $this->set('errors', array());
        if ($this->request->is('post')) {

            $validator = new Validator();
            $validator
                    ->requirePresence('email')
                    ->notEmpty('email', 'Email field is required')
                    ->add('email', 'validFormat', [
                        'rule' => 'email',
                        'message' => 'E-mail must be valid'
            ]);

            $errors = $validator->errors($this->request->data(), false);
            if (empty($errors)) {

                $email = $this->request->data('email');
                $user = $this->Cmsusers->find('all')->where(['email' => $email])->first();

                if ($user) {
                    $token = $this->generateRandomString('20');
                    $query = $this->Cmsusers->query();
                    $query->update()->set(['reset_password_token' => $token])->where(['id' => $user->id])->execute();

                    $emailData['username'] = $user->username;
                    $emailData['pin'] = base64_encode($user->id);
                    $emailData['token'] = base64_encode($token);

                    $url = Router::url([
                                'controller' => 'Cmsusers',
                                'action' => 'resetPassword'
                                    ], true);


                    $template_content = array(
                        array(
                            'name' => 'username',
                            'content' => $emailData['username']),
                        array(
                            'name' => 'reset_url',
                            'content' => $url . '/' . $emailData['pin'] . '/' . $emailData['token'])
                    );

                    $result = $this->sendEmail(MANDRILL_TEMPLATE_FORGOT_PASSWORD, $template_content, $user->email);
                    //var_dump($result);exit;
                    $this->Flash->success(__('An email has been successfully sent to your email with instructions to reset your password.'));

                    return $this->redirect('/');
                } else {
                    $this->Flash->error(__('Email id you entered is not registered with us. Please try again.'));
                }
            } else {
                $this->set('errors', $errors);
            }
        }
    }

    // function to reset password
    public function resetPassword($uid, $token) {
        $this->viewBuilder()->layout('before_login');
        $this->set('errors', array());

        $uid = base64_decode($uid);
        $token = base64_decode($token);


        $user = $this->Cmsusers->find('all')->where(['id' => $uid, 'reset_password_token' => $token])->first();
        if ($user) {
            if ($this->request->is('post')) {
                $validator = new Validator();
                $validator
                        ->requirePresence('password')
                        ->notEmpty('password', 'Password field is required')
                        ->add('password', [
                            'length' => [
                                'rule' => ['minLength', 4],
                                'message' => 'Password need to be at least 4 characters long',
                            ]
                        ])
                        ->requirePresence('confirm_password')
                        ->notEmpty('confirm_password', 'Confirm password field is required')
                        ->add('confirm_password', [
                            'match' => [
                                'rule' => ['equalTo', $this->request->data('password')],
                                'message' => 'Password confirmation does not match password.'
                            ]
                ]);
                $errors = $validator->errors($this->request->data(), false);
                if (empty($errors)) {
                    $query = $this->Cmsusers->query();
                    $query->update()->set(['reset_password_token' => '', 'password' => md5($this->request->data('password'))])->where(['id' => $user->id])->execute();
                    $this->Flash->success(__('Password reset was successful'));
                    return $this->redirect('/');
                } else {
                    $this->set('errors', $errors);
                }
            }
        } else {
            $errors['bad_request'] = __('reset_password_error', '<a href="' . Router::url(['controller' => 'Cmsusers', 'action' => 'forgotPassword']) . '">');
            $this->set('errors', $errors);
        }
    }

    public function login() {
    	$this->viewBuilder()->layout('before_login');
        $this->set('msg', '');
        $this->set('errors', array());
        if ($this->Auth->User()) {
            return $this->redirect($this->Auth->redirectUrl());
        }

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->loginError('Your username or password is incorrect.');
        }
    }
    public function editProfile(){
    	$id = $this->Auth->user('id');
    	$cmsuser = $this->Cmsusers->get($id, [
    			'contain' => []
    	]);
    	if ($this->request->is(['patch', 'post', 'put'])) {
    		//pr($this->request->data());exit;
    		if(!empty($this->request->data['img_path']['name'])){
    			$id = $this->request->session()->read('Auth.User.id');
    			if(!empty($this->request->data['previous_img_path'])){
    				unlink(WWW_ROOT.'/'.$this->request->data['previous_img_path']);
    			}
    			if (!is_dir('media/companies/'.$id)) {
    				mkdir('media/companies/'.$id, 0777, true);
    			}
    			$imagedes = $this->request->webroot.'webroot/media/companies/'.$id;
    			//$imagepath = 'webroot/media/companies/'.$last_insert_id.'/'.$this->request->data['img_path']['name'];
    			$imagepath = 'media/companies/'.$id.'/'.$this->request->data['img_path']['name'];
    			//echo $imagepath;exit;
    			$file = $this->request->data['img_path']; //put the data into a var for easy use
    		
    			$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
    			$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
    		
    			//only process if the extension is valid
    			if (in_array($ext, $arr_ext)) {
    				//do the actual uploading of the file. First arg is the tmp name, second arg is
    				//where we are putting it
    				move_uploaded_file($_FILES["img_path"]["tmp_name"],WWW_ROOT.'media/companies/'.$id.'/'. basename($_FILES['img_path']['name']));
    			} else{
    				$this->Flash->error(__('Profile Picture is not in right format.Please, try again.'));
    				return $this->redirect(['action' => 'edit']);
    			}
    			$this->request->data['img_path'] = $imagepath;
    			$this->request->session()->write('Auth.User.img_path', $imagepath);
    		}  else{
    			$this->request->data['img_path'] = $this->request->data['previous_img_path'];
    		}
    		$this->request->session()->write('Auth.User.username', $this->request->data['username']);
    		$cmsuser = $this->Cmsusers->patchEntity($cmsuser, $this->request->data);
    		if ($this->Cmsusers->save($cmsuser)) {
    			$this->Flash->success(__('Profile has been updated.'));
    			$this->redirect('/dashboard');
    		} else {
    			$this->Flash->error(__('The Profile could not be saved. Please, try again.'));
    		}
    	}
    	
    	$languages = [LANGUAGE_CODE_ENGLISH => 'English', LANGUAGE_CODE_KOREAN => 'Korean'];
    	$user_permissions = $this->request->session()->read('user_permissions');
    	$this->set('user_permission', $user_permissions);
    	$this->set('cmsuser', $cmsuser);
    	$this->set('languages', $languages);
    	$this->set('_serialize', ['cmsuser']);
    	$this->viewBuilder()->layout("custom_layout");
    }
    public function logout() {
        $this->Flash->loginSuccess('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }

    public function checkArtistRegistered() {

        $this->viewBuilder()->layout(FALSE);
        //$user = $this->Cmsusers->find('all')->where(['fb_id' => $_POST['fb_id']])->first();        
        $user = $this->Cmsusers->find('all')->where(['fb_id' => $_POST['fb_id']])->toArray();

        //print_r($user);

        if ($user[0]->id) {
            echo "ok";
        } else
            echo "no";

        die();
    }

    public function fbLogin($fb_id) {

        if ($fb_id) {
            $user = $this->Cmsusers->find('all')->where(['fb_id' => $fb_id, 'status' => 1])->toArray();

            $user_info['id'] = $user[0]->id;
            $user_info['language'] = $user[0]->language;
            $user_info['username'] = $user[0]->username;
            $user_info['email'] = $user[0]->email;
            $user_info['eset_password_token'] = $user[0]->eset_password_token;
            $user_info['status'] = $user[0]->status;
            $user_info['company_id'] = $user[0]->company_id;
            $user_info['created_on'] = $user[0]->created_on;
            $user_info['updated_on'] = $user[0]->updated_on;


            if ($user_info) {
                $this->Auth->setUser($user_info);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->loginError('Your username or password is incorrect.');
            return $this->redirect('/');
        } else {
            $this->Flash->loginError('Your username or password is incorrect.');
            return $this->redirect('/');
        }

        $this->viewBuilder()->layout(FALSE);
        die();
    }

    public function fbLoginRegister($fb_id = NULL) {

        $companyTable = TableRegistry::get('Companies');

        $company = $companyTable->newEntity();

        $cmsUser = $this->Cmsusers->newEntity();

        $artistTable = TableRegistry::get('Artists');
        $artist = $artistTable->newEntity();
        $picture = false;

        if ($this->request->is('post')) {

            $company = $companyTable->patchEntity($company, $this->request->data('company'));
            $company = $this->fixCompanyForAdd($company);
            $company->logo = $this->request->data("uploaded_file");

            $timezone_offset = TableRegistry::get('timezones')->find('all')
                            ->select(['utc_offset'])
                            ->where(['id' => $_POST['company']['timezone']])->toArray();


            $company->timezone_value = $timezone_offset[0]->utc_offset;

            $cmsUser = $this->Cmsusers->patchEntity($cmsUser, $this->request->data('cmsuser'));
            $cmsUser = $this->fixUserForAdd($cmsUser);

            $companyErrors = $this->checkAndDisplayEntityErrors($company);
            $userErrors = $this->checkAndDisplayEntityErrors($cmsUser);

            $password = $this->request->data('cmsuser.password');

            if (!$companyErrors && !$userErrors) {

                $savedCompany = $companyTable->save($company);

                if ($savedCompany) {

                    //$this->Flash->success(__('The company has been saved.'));

                    $cmsUser['company_id'] = $savedCompany['id'];

                    if ($this->Cmsusers->save($cmsUser)) {

                        if ($this->insertSuperUserPermission($company, $cmsUser)) {

                            //$this->Flash->success(__('The super admin has been saved.'));
                            $this->Flash->success(__('Artist has been saved.'));

                            $artist = $artistTable->patchEntity($artist, $this->request->data('artist'));
//                            $picture = $this->request->data("uploaded_artist_file");
                            $artist->name_en = $savedCompany['name'];
                            $artist->picture = $savedCompany['logo'];

                            $artist = $this->createArtist($artist, $savedCompany['id']);

                            copy(WWW_ROOT . '/media/companies/' . $artist->picture, WWW_ROOT . '/media/artists/' . $artist->picture);
                            $this->createThumbnail($artist->picture, 'artists');

                            $artistErrors = $this->checkAndDisplayEntityErrors($artist);

                            $artist = $artistTable->save($artist);

                            if ($artist) {

                                $template_content = array(
                                    array(
                                        'name' => 'firstname',
                                        'content' => $cmsUser->username
                                    ),
                                    array(
                                        'name' => 'user_email',
                                        'content' => $cmsUser->email
                                    ),
                                    array(
                                        'name' => 'password',
                                        'content' => $password
                                    ),
                                    array(
                                        'name' => 'login_url',
                                        'content' => APP_SERVER_HOST_URL
                                ));

                                $this->sendEmail(MANDRILL_TEMPLATE_USER_CREATION, $template_content, $cmsUser->email);

                                $this->Flash->success(__('An email has been sent to your specified email address.'));

                                //return $this->redirect(['action' => 'fbLoginRegister']);
                                return $this->redirect(['action' => 'login']);
                                
                            } else {
                                $this->Flash->error(__('The Artist could not be saved. Please, try again'));
                            }
                            //return $this->redirect(['action' => 'fbLoginRegister']);
                        } else {
                            $this->Flash->error(__('The Artist could not be saved. Please, try again'));
                            $this->revertPermissions($company, $cmsUser);
                            $companyTable->delete($company);
                            $this->Cmsusers->delete($company);
                        }
                        return $this->redirect(['action' => 'fbLoginRegister']);
                    } else {
                        $companyTable->delete($company);
                        $this->Flash->error(__('The Artist could not be saved. Please, try again'));
                    }
                } else {
                    $this->Flash->error(__('The company could not be saved. Please, try again.'));
                }
            }
        }


        $languages = [LANGUAGE_CODE_ENGLISH => 'English', LANGUAGE_CODE_KOREAN => 'Korean'];
        $this->set('languages', $languages);

        $this->set('countries', $this->getCountries());

        $timezones_array = TableRegistry::get('timezones')->find()->toArray();

        foreach ($timezones_array as $zone)
            $timezones[$zone->id] = $zone->time_zone . ' ' . $zone->utc_offset;

        $this->set('timezones', $timezones);

        $this->set('fb_id', $fb_id);

        $this->viewBuilder()->layout('fb_login_register');
    }

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
                ->where('modules.id IN (' . ModuleConstants::ACCESS_CONTROL . ',' . ModuleConstants::CONTENT . ',' . ModuleConstants::ARTIST_AND_GROUPS . ')');

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
        $rolePage['page_id'] = PagesConstants::BASIC_SETTINGS;
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

    public function uploadPicture($type = 'companies') {

//        if ($this->Auth->user()) {
//            $user_id = $this->Auth->user()['id'];

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
                    $new_file_name = $curr_time . '.' . $ext;
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
        // }
        exit;
    }

    public function removeMedia() {

//        if ($this->Auth->user()) {
//            $this->glbl();
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
        //}
        exit;
    }

    public function uploadArtistPicture($type = 'artists', $picture = NULL) {
//        if ($this->Auth->user()) {
//            $data = $this->glbl();
//            $user_id = $data['logged_user_info']['id'];

        if ($this->request->is('post')) {

            $data = $this->request->data;
            $resp = array();

            if (!empty($data['doc_artist_file']['name'])) {
                $file = $data['doc_artist_file']; //put the data into a var for easy use

                $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                $image_ext = array('jpg', 'jpeg', 'png');
                $not_image = '';

                //only process if the extension is valid
                if (in_array($ext, $image_ext)) {
                    $curr_time = date('Ymdhis');
                    $new_file_name = $curr_time . '.' . $ext;
                    $mediaPath = '/media/' . $type . '/' . $new_file_name;

                    if (move_uploaded_file($file['tmp_name'], WWW_ROOT . $mediaPath)) {
                        $this->createThumbnail($new_file_name, $type);
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
        //}
        exit;
    }

    public function removeArtistMedia() {
//        if ($this->Auth->user()) {
//            $this->glbl();
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
            $file_url = substr(WWW_ROOT, '0', '-1') . '/media/artists/' . $f_name;
            $file_url_thumb = substr(WWW_ROOT, '0', '-1') . '/media/artists/thumbnails/' . $f_name;
        }
        unlink($file_url);
        unlink($file_url_thumb);
        //}
        exit;
    }

    function createThumbnail($filename, $type) {

        //require 'config.php';

        copy(WWW_ROOT . '/media/' . $type . '/' . $filename, WWW_ROOT . '/media/' . $type . '/' . 'thumbnails/' . $filename);

        $path_to_image_directory = WWW_ROOT . '/media/' . $type . '/' . 'thumbnails/';

        if (preg_match('/[.](jpg)$/', $filename)) {
            $im = imagecreatefromjpeg($path_to_image_directory . $filename);
        } else if (preg_match('/[.](gif)$/', $filename)) {
            $im = imagecreatefromgif($path_to_image_directory . $filename);
        } else if (preg_match('/[.](png)$/', $filename)) {
            $im = imagecreatefrompng($path_to_image_directory . $filename);
        }

        $ox = imagesx($im);
        $oy = imagesy($im);

        $nx = WIDTH_OF_IMAGE;
        $ny = floor($oy * (WIDTH_OF_IMAGE / $ox));

        $nm = imagecreatetruecolor($nx, $ny);

        imagecopyresampled($nm, $im, 0, 0, 0, 0, $nx, $ny, $ox, $oy);

        imagejpeg($nm, $path_to_image_directory . $filename);


        return true;
    }

    public function termsService() {
        $this->viewBuilder()->layout('terms_service');
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

    private function createArtist($artist, $com_id) {
        //       $artist['country'] = $this->getCountries()[$artist['country']];
        $artist['company_id'] = $com_id;
        $artist['status'] = 0;
        //$artist['date_of_birth'] = Time::parse($artist['date_of_birth']);
        return $artist;
    }

    private function fixCompanyForAdd($company) {
        $company['status'] = 0;
        $company['country'] = $this->getCountries()[$company['country']];
        $company['created_on'] = new DateTime();
        $company['modified_on'] = new DateTime();
        return $company;
    }

    private function fixUserForAdd($cmsUser) {
        $cmsUser['created_on'] = new DateTime();
        $cmsUser['updated_on'] = new DateTime();
        $cmsUser['status'] = 0;
        return $cmsUser;
    }

    /**
     * @param $cmsuser
     * @return \Cake\Datasource\EntityInterface
     */
    private function createUser($cmsuser) {
        $cmsuser = $this->Cmsusers->patchEntity($cmsuser, $this->request->data);
        $cmsuser->reset_password_token = '';
        $cmsuser->created_on = date('Y-m-d H:i:s');
        $cmsuser->updated_on = date('Y-m-d H:i:s');
        $cmsuser->status = STATUS_ACTIVE;
        $cmsuser->company_id = $this->Auth->user('company_id');
        return $cmsuser;
    }

    public function emailSent() {
        $mandrill = new Mandrill('pfkbceAO9GboPTWRl4h_mw');
//    $name = 'email template';
//    $from_email = 'yusuf_cse@yahoo.com';
//    $from_name = 'Example Name';
//    $subject = 'example subject';
//    $code = '<div>example code</div>';
//    $text = 'Example text content';
//    $publish = false;
//    $labels = array('example-label');
//    $result = $mandrill->templates->add($name, $from_email, $from_name, $subject, $code, $text, $publish, $labels);
//        $message = array(
//            'html' => '<p>Example HTML content</p>',
//            'text' => 'Example text content',
//            'subject' => 'example subject',
//            'from_email' => 'yusuf_cse@yahoo.com',
//            'from_name' => 'Example Name',
//            'to' => array(
//                array(
//                    'email' => 'samba.yusuf@gmail.com',
//                    'name' => 'Recipient Name',
//                    'type' => 'to'
//                )
//        ));
//        $async = false;
//        $ip_pool = 'Main Pool';
//        $send_at = NULL;
//        $result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
//        print_r($result);

        $template_content = array(
            array(
                'name' => 'firstname',
                'content' => 'Abu'
            ),
            array(
                'name' => 'user_email',
                'content' => 'dipcse20@gmail.com'
            ),
            array(
                'name' => 'password',
                'content' => 'dip!12345'
            ),
            array(
                'name' => 'login_url',
                'content' => APP_SERVER_HOST_URL
        ));

        $to = array(array('email' => 'dipcse20@gmail.com'));

        $this->sendEmail(MANDRILL_TEMPLATE_USER_CREATION, $template_content, $to);
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
    

    public function changeLanguage(){
    
    		
    	$language_key = $this->request->data["global_selected_language"];
    	
    	$country_value_array = array(
    	"US"=> "en_US",
    	"JP"=> "ja_JP",
    	"KP"=> "ko_KP",
    	"CN"=> "zh_CN"
    	);
    	
    	$language=$country_value_array[$language_key];
    	$url = $this->request->data["global_current_url"];
    
    	if(empty($url)){
    		$url = APP_SERVER_HOST_URL;
    	}
    
    	$language = trim($language);
    	$allowedLanguage = array("en_US","ja_JP","ko_KP","zh_CN");
    
    	if(!in_array($language,$allowedLanguage)){
    		$language = "en_US";
    	}
    
    	$this->request->session()->write("Config.language",$language);
    	$this->Cookie->write("Config.expcount.language",$language);

    	return $this->redirect($url);
    	exit;
    
    }

}
