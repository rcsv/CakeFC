<?php
App::uses('AppModel', 'Model');

class Activity extends AppModel {
	
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'));

	public function saveActivityData($user_id, $controller, $entity_id) {
	}
}
