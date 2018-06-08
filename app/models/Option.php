<?php
class Option extends AppModel {
	public $actsAs = array(
			'Upload.Upload' => array(
					'logo' => array(
							'fields' => array(
									'dir' => 'logo_dir'
							),
							'thumbnailSizes' => array(
									'l' => '50h'
							),
							'thumbnailMethod' => 'php', 
							'thumbnailQuality' => '100'
					)
			)
	);
	
	
	public $validate = array(
			'gmap_key' => array(
					'rule1' => array(
							'rule'=> 'numeric',
							'allowEmpty' => true
					)
			),
			'row_location' => array(
					'rule1' => array(
							'rule'=> 'numeric',
							'allowEmpty' => false
					)
			)

	);
	
	public function parentNode() {
		return null;
	}
}