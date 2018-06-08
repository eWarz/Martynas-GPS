<?php
class OptionsController extends AppController {

	public function index(){
		$this->set('options',$this->Option->find('all'));
	}
	
	public function edit(){
		if($this->request->is('post')){
		
			$option_title = $this->Option->findByName('gmap_key');
			if(!empty($option_title)){
			$this->Option->id = $option_title['Option']['id'];
			$this->Option->saveField('value',$this->request->data['Option']['gmap_key']);
				
			}
			else {
			$option_data['Option']['name'] = 'gmap_key';
			$option_data['Option']['value'] = $this->request->data['Option']['gmap_key'];
			$this->Option->create();
			$this->Option->save($option_data);
			}
				
			$option_title = $this->Option->findByName('center_latitude');
			if(!empty($option_title)){
			$this->Option->id = $option_title['Option']['id'];
			$this->Option->saveField('value',$this->request->data['Option']['center_latitude']);
				
			}
			else {
			$option_data['Option']['name'] = 'center_latitude';
			$option_data['Option']['value'] = $this->request->data['Option']['center_latitude'];
			$this->Option->create();
			$this->Option->save($option_data);
			}
				
			$option_title = $this->Option->findByName('center_longitude');
			if(!empty($option_title)){
			$this->Option->id = $option_title['Option']['id'];
			$this->Option->saveField('value',$this->request->data['Option']['center_longitude']);
				
			}
			else {
			$option_data['Option']['name'] = 'center_longitude';
			$option_data['Option']['value'] = $this->request->data['Option']['center_longitude'];
			$this->Option->create();
			$this->Option->save($option_data);
			}
				
			$option_title = $this->Option->findByName('gmap_scale');
			if(!empty($option_title)){
			$this->Option->id = $option_title['Option']['id'];
			$this->Option->saveField('value',$this->request->data['Option']['gmap_scale']);
				
			}
			else {
			$option_data['Option']['name'] = 'gmap_scale';
			$option_data['Option']['value'] = $this->request->data['Option']['gmap_scale'];
			$this->Option->create();
			$this->Option->save($option_data);
			}
			
			$option_title = $this->Option->findByName('row_location');
			if(!empty($option_title)){
				$this->Option->id = $option_title['Option']['id'];
				$this->Option->saveField('value',$this->request->data['Option']['row_location']);
					
			}
			else {
				$option_data['Option']['name'] = 'row_location';
				$option_data['Option']['value'] = $this->request->data['Option']['row_location'];
				$this->Option->create();
				$this->Option->save($option_data);
			}
			
			$option_title = $this->Option->findByName('row_distribution');
			if(!empty($option_title)){
				$this->Option->id = $option_title['Option']['id'];
				$this->Option->saveField('value',$this->request->data['Option']['row_distribution']);
					
			}
			else {
				$option_data['Option']['name'] = 'row_distribution';
				$option_data['Option']['value'] = $this->request->data['Option']['row_distribution'];
				$this->Option->create();
				$this->Option->save($option_data);
			}
		
		$option_gmap_key = $this->Option->find('first',array('conditions'=>array('name'=>'gmap_key')));
		if(!empty($option_gmap_key)){
			$this->request->data['Option']['gmap_key'] = $option_gmap_key['Option']['value'];
		}
		else {
			$this->request->data['Option']['gmap_key'] = '';
		}
		
		$option_center_latitude = $this->Option->find('first',array('conditions'=>array('name'=>'center_latitude')));
		if(!empty($option_center_latitude)){
			$this->request->data['Option']['center_latitude'] = $option_center_latitude['Option']['value'];
		}
		else {
			$this->request->data['Option']['center_latitude'] = '0.0';
		}
		
		$option_center_longitude = $this->Option->find('first',array('conditions'=>array('name'=>'center_longitude')));
		if(!empty($option_center_longitude)){
			$this->request->data['Option']['center_longitude'] = $option_center_longitude['Option']['value'];
		}
		else {
			$this->request->data['Option']['center_longitude'] = '0.0';
		}
		
		$option_gmap_scale = $this->Option->find('first',array('conditions'=>array('name'=>'gmap_scale')));
		if(!empty($option_gmap_scale)){
			$this->request->data['Option']['gmap_scale'] = $option_gmap_scale['Option']['value'];
		}
		else {
			$this->request->data['Option']['gmap_scale'] = '';
		}		
	}
}