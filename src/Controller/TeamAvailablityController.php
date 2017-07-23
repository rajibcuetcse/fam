<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TeamAvailablity Controller
 *
 * @property \App\Model\Table\TeamAvailablityTable $TeamAvailablity
 */
class TeamAvailablityController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Teams']
        ];
        $teamAvailablity = $this->paginate($this->TeamAvailablity);

        $this->set(compact('teamAvailablity'));
        $this->set('_serialize', ['teamAvailablity']);
    }

    /**
     * View method
     *
     * @param string|null $id Team Availablity id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $teamAvailablity = $this->TeamAvailablity->get($id, [
            'contain' => ['Teams']
        ]);

        $this->set('teamAvailablity', $teamAvailablity);
        $this->set('_serialize', ['teamAvailablity']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $teamAvailablity = $this->TeamAvailablity->newEntity();
        if ($this->request->is('post')) {
            $teamAvailablity = $this->TeamAvailablity->patchEntity($teamAvailablity, $this->request->data);
            if ($this->TeamAvailablity->save($teamAvailablity)) {
                $this->Flash->success(__('The team availablity has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The team availablity could not be saved. Please, try again.'));
            }
        }
        $teams = $this->TeamAvailablity->Teams->find('list', ['limit' => 200]);
        $this->set(compact('teamAvailablity', 'teams'));
        $this->set('_serialize', ['teamAvailablity']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Team Availablity id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $teamAvailablity = $this->TeamAvailablity->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $teamAvailablity = $this->TeamAvailablity->patchEntity($teamAvailablity, $this->request->data);
            if ($this->TeamAvailablity->save($teamAvailablity)) {
                $this->Flash->success(__('The team availablity has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The team availablity could not be saved. Please, try again.'));
            }
        }
        $teams = $this->TeamAvailablity->Teams->find('list', ['limit' => 200]);
        $this->set(compact('teamAvailablity', 'teams'));
        $this->set('_serialize', ['teamAvailablity']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Team Availablity id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $teamAvailablity = $this->TeamAvailablity->get($id);
        if ($this->TeamAvailablity->delete($teamAvailablity)) {
            $this->Flash->success(__('The team availablity has been deleted.'));
        } else {
            $this->Flash->error(__('The team availablity could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
