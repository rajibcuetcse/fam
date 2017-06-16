<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\I18n;
use SubModuleConstants;
/**
 * Dashboard Controller
 *
 * @property \App\Model\Table\DashboardTable $Dashboard
 */
class DashboardController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        I18n::locale('en_US');
    }

    public function isAuthorized($user)
    {
        parent::isAuthorized($user);
        return true;
    }


    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('user_permission', $user_permissions);
        if (empty($user_permissions)) {
            $this->Flash->error(__('You do not have access to any modules currently'));
        }
        $this->set('company_id', $this->Auth->user()['company_id']);
        if ($this->Auth->user()) {
            //$this->viewBuilder()->layout("after_login");
            $this->viewBuilder()->layout("custom_layout");
        } else {
            return $this->redirect($this->Auth->redirectUrl());
        }
    }
    

}
