<?php
App::uses('Laraveliuksas', 'Utility');
class DashboardsController extends AppController {
	
	public $uses = array('Location','User');
	
	public function index(){
		
		$current_user_id = $this->Auth->User('id');
		
		$locations = $this->Location->find('all',array(
				'limit'=> 4));
		

		


}}