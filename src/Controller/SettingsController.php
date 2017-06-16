<?php
namespace App\Controller;

use Cake\I18n\I18n;


/**
 * Settings Controller
 *
 * @property \App\Model\Table\SettingsTable $Settings
 */
class SettingsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        I18n::locale('en_US');
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $setting = $this->Settings->get(1, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
        	if(!empty($this->request->data['logo_path']['name'])){
        		if(!empty($this->request->data['previous_logo_path'])){
        			unlink(WWW_ROOT.'/'.$this->request->data['previous_logo_path']);
        		}
        		$logopath = 'images/logo/'.$this->request->data['logo_path']['name'];
        		$file = $this->request->data['logo_path']; //put the data into a var for easy use
        		$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
        		$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
        	
        		//only process if the extension is valid
        		if (in_array($ext, $arr_ext)) {
        			//do the actual uploading of the file. First arg is the tmp name, second arg is
        			//where we are putting it
        			move_uploaded_file($_FILES["logo_path"]["tmp_name"],WWW_ROOT.'images/logo/'.basename($_FILES['logo_path']['name']));
        		} else{
        			$this->Flash->error(__('Logo is not in right format.Please, try again.'));
        			return $this->redirect(['action' => 'index']);
        		}
        		$this->request->data['logo_path'] = $logopath;
        	}  else{
        		$this->request->data['logo_path'] = $this->request->data['previous_logo_path'];
        	}
        	
        	if(!empty($this->request->data['favicon_path']['name'])){
        		if(!empty($this->request->data['previous_favicon_path'])){
        			unlink(WWW_ROOT.'/'.$this->request->data['previous_favicon_path']);
        		}
        		$faviconpath = 'images/favicon/'.$this->request->data['favicon_path']['name'];
        		$file = $this->request->data['favicon_path']; //put the data into a var for easy use
        		$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
        		$arr_ext = array('jpg', 'jpeg', 'gif', 'png','ico'); //set allowed extensions
        		 
        		//only process if the extension is valid
        		if (in_array($ext, $arr_ext)) {
        			//do the actual uploading of the file. First arg is the tmp name, second arg is
        			//where we are putting it
        			move_uploaded_file($_FILES["favicon_path"]["tmp_name"],WWW_ROOT.'images/favicon/'.basename($_FILES['favicon_path']['name']));
        		} else{
        			$this->Flash->error(__('Logo is not in right format.Please, try again.'));
        			return $this->redirect(['action' => 'index']);
        		}
        		$this->request->data['favicon_path'] = $faviconpath;
        	}  else{
        		$this->request->data['favicon_path'] = $this->request->data['previous_favicon_path'];
        	}
        	
            $setting = $this->Settings->patchEntity($setting, $this->request->data);
            if ($this->Settings->save($setting)) {
                $this->Flash->success(__('The setting has been saved.'));
            } else {
                $this->Flash->error(__('The setting could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('setting'));
        //$this->set('_serialize', ['setting']);
        $this->viewBuilder()->layout("custom_layout");
    }

    public function getModules()
    {
        return [
            'Settings' => '1004'
        ];
    }

    public function getSubModules()
    {
        return [
            'Site Settings' => '2070'
        ];
    }

    public function getPages()
    {
        return [
            'index' => '3081'
        ];
    }
}
