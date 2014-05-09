<?php
App::uses('Model', 'Model');
App::uses('ContainableBehavior', 'Model/Behavior');
//App::uses('TranslateBehavior', 'Model/Behavior');

class AppModel extends Model {

	public $actsAs = array(
		//'Translate',
		'Containable');
	
	public function isOwnedBy($postId,$userId) {
		return $this->field('id', array('id' => $postId, 'user_id' => $user_id)) !== false ;
	}
}
