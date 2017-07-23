<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Teams Controller
 *
 * @property \App\Model\Table\TeamsTable $Teams
 */
class TeamsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $page_limit=10;
    	if (isset($this->request->query['page_limit'])) {
    		$page_limit= $this->request->query('page_limit');
    	}
        $this->paginate = [
            'limit' => $page_limit,
            'order' => [
                'teams.created_on' => 'desc'
            ]
        ];

        $search = '';
        if (isset($this->request->query['search'])) {
            $search = $this->request->query('search');
        }

        $teams = $this->Teams->find('all')
                ->where(['company_id' => $this->Auth->user('company_id')]);
//                ->andWhere(['name LIKE' => '%' . $search . '%'])
//                ->orWhere(['team_manager_name LIKE' => '%' . $search . '%']);
        
        
        
        
        
//        $this->paginate = [
//            'contain' => ['CmsUsers']
//        ];
//        $teams = $this->paginate($teams);

//        $this->set(compact('teams'));
//        $this->set('_serialize', ['teams']);
        
        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('module_pages', $this->getPages());
        $this->set('user_permission', $user_permissions);
        $this->set('bulk_actions', [BULK_ACTION_DELETE => "Move to trash"]);
        $this->set('teams', $this->paginate($teams));
        $this->set('_serialize', ['teams']);
        $this->set('searchText', $search);
        $this->set('page_limit', $page_limit);
        $this->viewBuilder()->layout("custom_layout");
    }

    /**
     * View method
     *
     * @param string|null $id Team id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $team = $this->Teams->get($id, [
            'contain' => ['CmsUsers']
        ]);
        
        $this->set('team', $team);
        $this->set('_serialize', ['team']);
        
        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('languages', $this->languages);// var $languages member variable of App Controler
        $this->set('module_pages', $this->getPages());
        $this->set('user_permission', $user_permissions);
        $this->set('_serialize', ['team']);
        $this->viewBuilder()->layout("custom_layout");
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $team = $this->Teams->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['team']['company_id'] = $this->Auth->user('company_id');
            $team = $this->Teams->patchEntity($team, $this->request->data['team']);
            if ($this->Teams->save($team)) {
                $this->Flash->success(__('The team has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
//                $error = $team->errors();
//                echo "<pre>";print_r($error);exit;
                $this->Flash->error(__('The team could not be saved. Please, try again.'));
            }
        }
        $cmsUsers = $this->Teams->CmsUsers->find('list')
                ->where(['company_id' => $this->Auth->user('company_id')]);
        
        $this->set(compact('team', 'cmsUsers'));
        $this->set('_serialize', ['team']);
        
        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('languages', $this->languages);// var $languages member variable of App Controler
        $this->set('module_pages', $this->getPages());
        $this->set('user_permission', $user_permissions);
        $this->viewBuilder()->layout("custom_layout");
    }

    /**
     * Edit method
     *
     * @param string|null $id Team id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $team = $this->Teams->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request->data['team']['company_id'] = $this->Auth->user('company_id');
            $team = $this->Teams->patchEntity($team, $this->request->data['team']);

            if ($this->Teams->save($team)) {
                $this->Flash->success(__('The team has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The team could not be saved. Please, try again.'));
            }
        }
        $cmsUsers = $this->Teams->CmsUsers->find('list')->where(['company_id' => $this->Auth->user('company_id')]);
        $team['team'] = $this->Teams->get($id, [
            'contain' => []
        ]);
        $this->set('team', $team);
        $this->set('cmsUsers', $cmsUsers);
        
        $user_permissions = $this->request->session()->read('user_permissions');
        $this->set('languages', $this->languages);// var $languages member variable of App Controler
        $this->set('module_pages', $this->getPages());
        $this->set('user_permission', $user_permissions);
        $this->set('_serialize', ['team']);
        $this->viewBuilder()->layout("custom_layout");
    }

    /**
     * Delete method
     *
     * @param string|null $id Team id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $team = $this->Teams->get($id);
        if ($this->Teams->delete($team)) {
            $this->Flash->success(__('The team has been deleted.'));
        } else {
            $this->Flash->error(__('The team could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
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
            $teamId = str_replace('content_', '', $companyIdWithPrefix);
            $team = $this->Teams->get($teamId);
            $this->Teams->delete($team);
            
        }
    }
}
