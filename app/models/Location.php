<?php
class Location extends AppModel {
	public $belongsTo = array(
			'LocationCategory' => array(
					'className' => 'LocationCategory',
					'foreignKey' => 'location_category_id'
			),
			'User' => array(
					'className' => 'User',
					'foreignKey' => 'user_id'
			)
	);
	
	public $hasMany = 'Distribution';
	public $actsAs = array('Acl' => array('type' => 'controlled'),
			'Search.Searchable');
	
	public $filterArgs = array(
			'search_user_id' => array('type'=>'value','field'=>'User.id'),
			'search_category' => array('type'=>'value','field'=>'LocationCategory.id'),
			'search_name' => array('type'=>'like','field'=>'Location.name'),
			'search_latitude' => array('type'=>'value','field'=>'Location.latitude'),
			'search_longitude' => array('type'=>'value','field'=>'Location.longitude'),
			'search_all' => array('type'=>'query','method'=>'searchDefault')
	);
	
	public function searchDefault($data = array()) {
		$filter = $data['search_all'];
		$cond = array(
				'OR' => array(
						'User.first_name LIKE' => '%' . $filter . '%',
						'User.last_name LIKE' => '%' . $filter . '%',
						'LocationCategory.name LIKE' => '%' . $filter . '%',
						$this->alias . '.name LIKE' => '%' . $filter . '%',
						$this->alias . '.latitude LIKE' => '%' . $filter . '%',
						$this->alias . '.longitude LIKE' => '%' . $filter . '%'
				));
		return $cond;
	}
	
	public $validate = array(
			'name' => array(
					'length' => array(
							'rule' => array('maxLength',250),
							'message' => 'Maximum length 250 Character'
					)
			),
			'latitude' => array(
					'rule' => array('numeric'),
					'required' => true,
					'message' => 'Please check latitude'
			),
			'longitude' => array(
					'rule' => array('numeric'),
					'required' => true,
					'message' => 'Please check latitude'
			)
	);
	
	public function parentNode() {
		return null;
	}
}