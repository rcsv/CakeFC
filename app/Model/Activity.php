<?php
App::uses('AppModel', 'Model');

/**
 * Activity Model
 * 
 * 足跡を残すためのモデルです。
 * いつ、だれが、どのモデルに、何のアクションをして、結果生成されたレコードは何番なのか
 * という情報を保有します。
 * 
 * 1. id
 * 2. user_id
 * 3. model
 * 4. action
 * 5. entity
 */
class Activity extends AppModel {
	
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'));

	/**
	 * saveActivityData
	 * 
	 * AppController から呼ばれる、ざっくり活動情報を保存するメソッド。
	 * 
	 */
	public function saveActivityData($user_id, $controller, $entity_id) {
		$this->data[$this->alias]['user_id'] = $user_id;
		$this->data[$this->alias]['model'] = $controller->request->params['controller'];
		$this->data[$this->alias]['action'] = $controller->request->params['action'];
		$this->data[$this->alias]['entity'] = $entity_id;
		$this->save();
	}
}
