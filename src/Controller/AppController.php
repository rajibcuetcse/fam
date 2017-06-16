<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use Exception;
use Mandrill;
use stdClass;
use Cake\I18n\I18n;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
abstract class AppController extends Controller
{

	
	var $languages = array('en' => 'English', 'ko' => 'Korean','chi'=>'Chinese');
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
		$this->loadModel('Settings');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Cookie', ['expiry' => '1 day']);
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authorize' => ['Controller'],
            'authenticate' => [
                'Form' => [
                    'userModel' => 'Cmsusers',
                    'passwordHasher' => [
                        'className' => 'Cms'
                    ],
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Cmsusers',
                'action' => 'login'
            ],
            'loginRedirect' => [
                'controller' => 'Dashboard',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Cmsusers',
                'action' => 'login'
            ]
        ]);
        $this->Auth->allow(['display']);
        $this->setCompanyID();
        $setting = $this->Settings->get(1, [
        		'contain' => []
        ]);
        $this->set('setting',$setting);
    }
    
    public function beforeFilter(Event $event) {    	
    	if ($this->request->session()->read('Config.language')) {
    		$language =$this->request->session()->read('Config.language');
    		if($language != I18n::defaultLocale()){
    			I18n::locale($language);
    			$this->set("current_lang",$language);
    		}
    		else{
    			$this->set("current_lang",I18n::defaultLocale());
    		}
    	}  else if($this->Cookie->read('Config.expcount.language')){
    		$language = $this->Cookie->read('Config.expcount.language');
    		$this->request->session()->write("Config.language",$language);
    		I18n::locale($language);
    		$this->set("current_lang",$language);
    	}
    	else{  
    		$this->set("current_lang",I18n::defaultLocale());
    	}
       if($this->request->session()->read('Auth.User.id')){ 	   	    	
    	$this->set('current_module', $this->getModules());
    	$this->set('sub_modules', $this->getSubModules());
    	$this->set('module_pages', $this->getPages());
    }
    }

    public function setCompanyID()
    {
        $this->set('company_id', $this->Auth->user('company_id'));
    }

    protected function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    public function sendEmail($templateName, $templateContent, $to)
    {
        try {

            $mandrill = new Mandrill(MANDRILL_API_KEY);

            $message = new stdClass();
            $message->to = $to;
            $message->track_opens = true;
            $message->merge_language = 'handlebars';
            $message->global_merge_vars = $templateContent;
            //pr($message);exit;
            $response = $mandrill->messages->sendTemplate($templateName, $templateContent, $message);
        } catch (Exception $ex) {
            $this->log($ex);
        }
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    public function isAuthorized($user)
    {
        $session = $this->request->session();
        //TODO - Change the logic of saving the user permissions
        $previous_permission_version= $session->read('permission_version');
        $current_permission_version=TableRegistry::get('cmsusers')->get($user['id'])->permission_version;
        if($current_permission_version!==$previous_permission_version){
        $this->addPermissionsAndVersionToSession($session, $user,$current_permission_version);
        }

        $user_permissions = $session->read('user_permissions');
        $request_action = strtolower($this->request->params['action']);
        $pages = $this->getPages();
        if (array_key_exists($request_action, $pages)) {
            $action_page_id = $pages[$request_action];
            foreach ($user_permissions as $permission) {
                if ($permission['page_id'] == $action_page_id) {
                    return true;
                }
            }
        }

        if (!array_key_exists("Dashboard", $this->getModules())) {
            $this->Flash->error(__('You do not have permission to access this page'));
        }
        return false;
    }

    protected function addPermissionsAndVersionToSession($session, $user,$current_permission_version)
    {
        $connection = ConnectionManager::get('default');
        $user_permissions = $connection->execute('SELECT  cmsusers.id AS user_id,pages.id AS page_id, pages.name AS page_name, modules.id AS module_id, sub_modules.name AS submodule_name, sub_modules.id AS submodule_id
FROM            cmsusers
					INNER JOIN cmsuser_usergroups ON cmsusers.id = cmsuser_usergroups.cms_user_id
					INNER JOIN usergroups ON cmsuser_usergroups.usergroup_id = usergroups.id
					INNER JOIN usergroup_roles ON usergroups.id = usergroup_roles.usergroup_id
					INNER JOIN roles ON usergroup_roles.role_id = roles.id
					INNER JOIN role_pages ON roles.id = role_pages.role_id
					INNER JOIN pages ON role_pages.page_id = pages.id
					INNER JOIN sub_modules ON pages.sub_module_id = sub_modules.id
					INNER JOIN modules ON sub_modules.module_id = modules.id
					WHERE        cmsusers.id =' . $user['id'])->fetchAll('assoc');
        
        
        $session->write('user_permissions', $user_permissions);
        $session->write('permission_version', $current_permission_version);
        
        
        if ($this->Auth->user('id') == SUPER_SUPER_ADMIN_ID) {
        	$modules =TableRegistry::get('modules')->find('all')->contain([
        			'SubModules' => [
       					 'sort' => ['SubModules.sequence' => 'ASC']
   					 ],
    			'SubModules.Pages' => [
        			'sort' => ['Pages.method_name' => 'ASC']
   			 ]
        	])
        	->order(['sequence' => 'ASC'])
        	->toArray();
        } else {
        	$modules =TableRegistry::get('modules')->find('all')->contain([
        			'SubModules' => [
        					'sort' => ['SubModules.sequence' => 'ASC']
        			],
        			'SubModules.Pages' => [
        					'sort' => ['Pages.method_name' => 'ASC']
            ]				
        	])->where([
        			'id NOT IN' => [1001, 1002, 1007]
        	])
        	->order(['sequence' => 'ASC'])
        	->toArray();
        }
      
       $modules = serialize($modules);
       $session->write('modules',$modules);
       //debug($modules);
//        $session->write('permission_version_db', $user['permission_version']);
//
//        $this->log($session->read('user_permissions'));
//        $this->log($session->read('permission_version'));
//        $this->log($session->read('permission_version_db'));
    }

    public function getModules()
    {
    	$request_controller=strtolower($this->request->params['controller']);
    	if ($request_controller=="dashboard"){
    		return array('Dashboard' => 'Dashboard');
    	}
    	$current_module_arr=array();
    	$current_submodule_arr=$this->getSubModules();
    	$modules = unserialize($this->request->session()->read('modules'));
    	foreach($modules as $module){
    		foreach($module['sub_modules'] as $submodule ){
    			if(current($current_submodule_arr)==$submodule['id']){
    				$current_module_arr=array($module['name']=>$module['id']);
    				break 2;
    			}
    		}
    	}
    
    	return $current_module_arr;
    	//return  ['Master Data' =>'1002'];
    }
    
    public function getSubModules()
    {
    	
    	$request_controller=strtolower($this->request->params['controller']);
    	if ($request_controller=="dashboard"){
    		 return array();
    	}
    	$current_submodule_arr=array();
    	$modules = unserialize($this->request->session()->read('modules'));
    	foreach($modules as $module){
    		foreach($module['sub_modules'] as $submodule ){
    			if($request_controller==strtolower($submodule['controller_name'])){
    				$current_submodule_arr=array($submodule['name']=>$submodule['id']);
    				break 2;
    			}
    		}
    	}
    	return $current_submodule_arr; // return ['Page Management' => '2022'];
    }

    public function getPages()
    {
    	$request_controller=strtolower($this->request->params['controller']);
    	if ($request_controller=="dashboard"){
    		return array();
    	}
    	$pages_arr=array();
    	$current_submodule_arr=$this->getSubModules();
    	$modules = unserialize($this->request->session()->read('modules'));
    	foreach($modules as $module){
    		foreach($module['sub_modules'] as $submodule ){
    			if(current($current_submodule_arr)==$submodule['id']){
    				foreach($submodule['pages'] as $page ){
    					$pages_arr[$page['method_name']]=$page['id'];
    					
    				}
    				break 2;
    			}
    		}
    	}
    	
    	return $pages_arr;
    	
    	/* 
        return ['index' =>'3035',
            'add' => '3036',
            'edit' => '3037',
            'delete' =>'3038']; */
    }

}
