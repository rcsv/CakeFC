<?php
App::uses('AppController', 'Controller');
App::uses('Profile', 'Model');

/**
 * Users Controller
 */
class UsersController extends AppController {
	
	
	// components
	public $components = array('Paginator');
	
	// private method
	/**
	 * _getActivationUrl
	 * 
	 * this method generates a URL string similar http://...com/users/activate/1/HOGEHOGEHOGE ... 
	 * using User::getActivationHash().
	 * @return http://....com/users/activate/1/HOGEHOGEHOGEHOGEHOGE...
	 * 
	 */
	private function _getActivationUrl($id) {
		return FULL_BASE_URL 
			. $this->request->webroot
			. $this->request->controller
			. '/activate/'
			. $id
			. '/'
			. $this->User->getActivationHash();
	}
	
	// methods override
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('register', 'activate', 'reactivate');
	}

	public function isAuthorized($user) {
		if(in_array($this->action, array(
			'add', 'edit', 'resign', 'changepw', 'changeimg'))) {
			$postId =(int)$this->request->params['pass'][0];
			if($this->User->isOwnedBy($postId, $user['id'])) {
				return true;
			}
		}
		return parent::isAuthorized($user);  
	}
}
