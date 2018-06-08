<?php
App::uses('Laraveliuksas', 'Utility');
class LocationsController extends AppController {
	
	public $uses = array('Location','LocationCategory','Distribution','Problem','User');
	
	public $components = array('RequestHandler');
	
	public $option_row_location;
	
	public function beforeFilter(){
		parent::beforeFilter();
	
		$option_row_location = $this->Option->find('first',array('conditions'=>array('name'=>'row_location')));
		if(!empty($option_row_location)){
			$this->option_row_location = $option_row_location['Option']['value'];
		}
		else {
			$this->option_row_location = 30;
		}
	
	}
	
	public function index($csvFile = null) {
		$searched = false;
		$search_user_full_name = '';
		if ($this->passedArgs) {
			$args = $this->passedArgs;
			if(isset($args['search_name'])){
				$searched = true;
			}
			if(isset($args['search_user_id'])){
				$temp = $this->User->findById($args['search_user_id']);
				if(!empty($temp)){
					$search_user_full_name = $temp['User']['full_name'];
				}
			}
		}
		
		$this->set('search_user_full_name',$search_user_full_name);
		$this->set('searched',$searched);
		
		$this->Prg->commonProcess();
		$this->Location->recursive = 1;
		
		if ($csvFile) {
			$this->paginate = array(
					'conditions' => $this->Location->parseCriteria($this->passedArgs),
					'order' => array(
							'Location.modified' => 'desc'
					)
			);
			$this->request->params['named']['page'] = null;
		}
		else {
			$this->paginate = array(
					'conditions' => $this->Location->parseCriteria($this->passedArgs),
					'limit' => $this->option_row_location,
					'order' => array(
							'Location.modified' => 'desc'
					)
			);
		}
		
		
		$locationCategoryList = $this->LocationCategory->find('list');
		$userList = $this->User->find('list');
		
		$this->set('locationCategoryList',$locationCategoryList);
		$this->set('userList',$userList);
		
		$this->set('locations', $this->Paginate());
	}
	
	public function view($id = null){
		$this->Location->id = $id;
		if(!$this->Location->exists()){
			throw new NotFoundException('Record not found');
		}
		
		$location = $this->Location->read();
		
		$this->set('location',$location);
		
		$distributions = $this->Distribution->find('all',array(
				'limit'=>5,
				'conditions'=>array(
						'Distribution.location_id'=>$id
				),
				'order' => array(
						'Distribution.date_time' => 'desc'
				)
		)
		);
		
		$this->set('distributions',$distributions);
		
		$problems = $this->Problem->find('all',array(
				'limit'=>5,
				'conditions'=>array(
						'Problem.location_id'=>$id
				),
				'order' => array(
						'Problem.start_time' => 'desc'
				)
		)
		);
		
		$this->set('problems',$problems);
	}
	
	public function add(){
		$locationcategories = $this->LocationCategory->find('list');
		$this->set(compact('locationcategories'));
		
		$userList = $this->Location->User->find('list');
		$this->set('userList',$userList);
		
		if($this->request->is('post')){
			//$this->request->data['Location']['user_id'] = $this->Auth->user('id');
			$this->Cookie->write('location_add_location_category_id',$this->request->data['Location']['location_category_id'],true,'+4 weeks');
			$this->Location->create();
			if ($this->request->data['Distribution'][0]['number']) {
				$isSaved = $this->Location->saveAssociated($this->request->data);
			}
			else {
				$isSaved = $this->Location->save($this->request->data);
			}
			if($isSaved){
				$this->Session->setFlash('Sukurta','alert');
				$this->redirect(array('action'=>'index'));
			}
			else
			{
				$this->Session->setFlash('Unable to add','alert', array('class'=>'alert-error'));
			}
		} else {
			if($this->Cookie->check('location_add_location_category_id')) {
				$lastLocationCategoryId = $this->Cookie->read('location_add_location_category_id');
				if(!empty($lastLocationCategoryId)){
					$this->request->data['Location']['location_category_id'] = $lastLocationCategoryId;
				}
			}
			unset($this->Location->Distribution->validate['number']);
			$this->request->data['Distribution'][0]['date_time'] = Laraveliuksas::format('Y-m-d H:i',time());
			$this->request->data['Location']['user_id'] = $this->Auth->user('id');
		}
	}
	
	public function edit($id = null){
		$this->Location->id = $id;
		if(!$this->Location->exists()){
			throw new NotFoundException('Record not found');
		}
		
		if($this->request->is('post')){
		
			if($this->Location->save($this->request->data)){
				$this->Session->setFlash('Išsaugota ','alert');
				$this->redirect(array('action'=>'index'));
			}
			else
			{
				$this->Session->setFlash('Negalima išsaugoti','alert', array('class'=>'alert-error'));
			}
		}
		else
		{
			$locationcategories = $this->LocationCategory->find('list');
			$this->set(compact('locationcategories'));
			
			$userList = $this->Location->User->find('list');
			$this->set('userList',$userList);
			
			$this->request->data = $this->Location->read();
		}
	}
	
	public function ajax_add(){
		Configure::write('debug',0);
		if($this->request->is('post')){
			$result = array();
			if($this->request->data){
				if(!isset($this->request->data['Location']['user_id'])){
					$this->request->data['Location']['user_id'] = $this->Auth->user('id');
				}
				$this->Location->create();
				if($this->Location->save($this->request->data)){
					$result['status'] = 'ok';
					$result['id'] = $this->Location->id;
					$result['current'] = $this->Location->read();
					echo json_encode($result); die;
				} else {
					$result['status'] = 'err';
					$result['id'] = 0;
					echo json_encode($result); die;
				}
			}
				
		} elseif($this->request->is('ajax')){
			//display add form
			$this->set('listLocationCategory',$this->Location->LocationCategory->find('list'));
		}
	}
	
	public function ajax_edit($id=null){
	
		Configure::write('debug',0);
		if($this->request->is('post')){
			$result = array();
			if($this->request->data){
				if($this->Location->save($this->request->data)){
					$result['status'] = 'ok';
					$result['id'] = $this->Location->id;
					$result['current'] = $this->Location->read();
					echo json_encode($result); die;
				} else {
					$result['status'] = 'err';
					$result['id'] = 0;
					echo json_encode($result); die;
				}
			}
			
		} elseif ($this->request->is('ajax')){
			if(!is_null($id)){
				$this->Location->id = $id;
				$this->request->data = $this->Location->read();
			}
		}
		
		$this->set('listLocationCategory',$this->Location->LocationCategory->find('list'));
	}
	
	public function ajax_delete($id=null){
		if($this->request->is('ajax')){
			
		}
	}
	
	public function data_entry(){
		$this->layout='menumap';
		$locations = $this->Location->find('all');
		$this->set('listLocationCategory',$this->Location->LocationCategory->find('list'));
		$this->set('locations',$locations);
	}
	
	public function delete($id = null){
		if ($this->request->is('ajax')){
			Configure::write('debug',0);
			$this->Location->id = $id;
			if($this->Location->delete($id)){
				echo 'ok'; die;
			} else {
				echo 'err'; die;
			}
		} else {
			if (!$this->request->is('post')) {
				throw new MethodNotAllowedException();
			}
			
			$this->Location->id = $this->request->data['id']; //--
			if(!$this->Location->exists()){
				throw new NotFoundException('Nerasta');
			}
			
			if($this->Location->delete($id)){
				$this->Session->setFlash('Ištrinta','alert');
				$this->redirect(array('action'=>'index'));
			}
			else
			{
				$this->Session->setFlash('Negalima ištrinti','alert', array('class'=>'alert-error'));
				$this->redirect(array('action'=>'index'));
			}
		}
	}
}