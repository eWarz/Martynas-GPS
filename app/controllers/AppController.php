<?php

App::uses('Controller', 'Controller');

App::uses('Laraveliuksas', 'Utility');
class AppController extends Controller {
	public $theme = 'New';
	
	public $option_row_other;
	public $timezone = 'UTC';
	public $date_format;
	public $datetime_format;
	
	public $components = array(
			'Session',
			'Acl',
			'Email',
			'Auth' => array(
					'loginRedirect' => array('controller' => 'dashboards', 'action' => 'index'),
					'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
					'authorize' => array(
							'Actions' => array('actionPath' => 'controllers')
							)
			),
			'Search.Prg',
			'Cookie',
	);
	
	public $helpers = array(
			'Session',
			'Time',
			'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
			'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
			'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator')
			
    );
	
	public $uses = array('Option','User');
	
	public function beforeFilter(){
		$this->Auth->authError = "Prašome prisijungti";
		
		$this->Cookie->key = 'qSI232qs*&sXOw!adre@34SAv!SL#$%)asGb$@11~_+!@#HKis~#^';
		$this->Cookie->httpOnly = true;
		
		if (!$this->Auth->loggedIn() && $this->Cookie->read('remember_me_cookie')) {
			$cookie = $this->Cookie->read('remember_me_cookie');
			
			$user = $this->User->find('first', array(
					'conditions' => array(
							'User.username' => $cookie['username'],
							'User.password' => $cookie['password']
					)
			));
		
			if ($user && !$this->Auth->login($user)) {
				$this->redirect('/users/logout'); 
			}
		}
		
		$option_row_other = $this->Option->find('first',array('conditions'=>array('name'=>'row_other')));
		if(!empty($option_row_other)){
			$this->option_row_other = $option_row_other['Option']['value'];
		}
		else {
			$this->option_row_other = 30;
		}
		$option_date_format = $this->Option->find('first',array('conditions'=>array('name'=>'date_format')));
		if(!empty($option_date_format)){
			$this->date_format = $option_date_format['Option']['value'];
		}
		else {
			$this->date_format = 'M j, Y';
		}
		
		$option_datetime_format = $this->Option->find('first',array('conditions'=>array('name'=>'datetime_format')));
		if(!empty($option_datetime_format)){
			$this->datetime_format = $option_datetime_format['Option']['value'];
		}
		else {
			$this->datetime_format = 'M j, Y g:i A';
		}
		
		$this->timezone = date_default_timezone_get();

		$option_gmap_key = $this->Option->find('first',array('conditions'=>array('name'=>'gmap_key')));
		if(!empty($option_gmap_key)){
			$this->set('gmap_key',$option_gmap_key['Option']['value']);
		}
		else {
			$this->set('gmap_key','');
		}
		
		$option_center_latitude = $this->Option->find('first',array('conditions'=>array('name'=>'center_latitude')));
		if(!empty($option_center_latitude)){
			$this->set('center_latitude',$option_center_latitude['Option']['value']);
		}
		else {
			$this->set('center_latitude','0.0');
		}
		
		$option_center_longitude = $this->Option->find('first',array('conditions'=>array('name'=>'center_longitude')));
		if(!empty($option_center_longitude)){
			$this->set('center_longitude',$option_center_longitude['Option']['value']);
		}
		else {
			$this->set('center_longitude','0.0');
		}
		
		$option_gmap_scale = $this->Option->find('first',array('conditions'=>array('name'=>'gmap_scale')));
		if(!empty($option_gmap_scale)){
			$this->set('gmap_scale',$option_gmap_scale['Option']['value']);
		}
		else {
			$this->set('gmap_scale','1');
		}

	}
	


}
