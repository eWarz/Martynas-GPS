<?php
class LocationCategory extends AppModel {
	
	public $hasMany = 'Location';
	
	public $actsAs = array('Search.Searchable');
		
	public $filterArgs = array('search_all' => array('type'=>'query','method'=>'searchDefault'));
	
	public function searchDefault($data = array()) {
		$filter = $data['search_all'];
		$cond = array(
				'OR' => array(
						$this->alias . '.name LIKE' => '%' . $filter . '%',
						$this->alias . '.description LIKE' => '%' . $filter . '%'
				));
		return $cond;
	}
	
	public $validate = array(
			'name' => array(
					'length' => array(
							'required' => true,
							'rule' => array('maxLength',250),
							'message' => 'Maximum length 250 Character'
					)
			),
			'description' => array(
					'rule' => 'notEmpty',
					'required' => true,
					'message' => 'Please provide description'
			)
	);
	
	public function hasLocations($category_id){
		$count = $this->Location->find('count',array('conditions'=>array('Location.location_category_id'=>$category_id)));
		return $count;
	}
	
	public function parentNode() {
		return null;
	}
}