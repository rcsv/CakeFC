<?php
App::uses('AppController', 'Controller');
App::uses('Profile', 'Model');

/**
 * Users Controller
 */
class UsersController extends AppController {
	// methods
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('register', 'activate', 'reactivate');
	}

	public function isAuthorized($user) {
		if(in_array($this->action, array())) {
		}
		return parent::isAuthorized($user);  
	}
}
