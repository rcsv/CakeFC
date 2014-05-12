<?php
App::uses('AppController', 'Controller');
App::uses('Profile', 'Model');

/**
 * Users Controller
 */
class UsersController extends AppController {
	
	public function dashboard() {
		$this->stub();
	}
	
	public function index() {
		$this->stub();
	}
	
	/**
	 * Register method
	 * 
	 * It displays a registration form. If unregistered users submitted
	 * here, they will receive a confirmination mail sent by CakeEmail
	 * including activation URL.
	 */
	public function register() {
		// POST
		// -------------------
		
		if(!empty($this->data)) {
			if($this->User->save($this->data)) {
				$url = $this->_getActivationUrl($this->User->id);
				$this->Session->setFlash('Pre-registration is done. Please check your mail immediately.'
					// display screen right now.
					. $url, 'alert', array(
						'plugin' => 'BoostCake',
						'class' => 'alert-success'));
				$this->render('register_finished');
				
				return ;
			} else {
				$this->Session->setFlash(__('Input Error.'), 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-warning'));
			}
		}
		
		// GET
		// -------------------
		//$this->layout = 'default';
	}
	
	public function activate($user_id = null, $in_hash = null ) {
		$this->User->id = $user_id;
		if($this->User->exists())
	}
	
	public function login() {
		$this->stub();
	}
	
	public function logout() {
		$this->stub();
	}
	
	public function edit($id = null) {
		$this->stub();
	}
	
	public function quit($id =null) {
		$this->stub();
	}
	
	public function reactivate() {
		$this->stub();
	}
	
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
	
	/**
	 * trivial function stub.
	 */
	private function stub() {
		$this->layout = 'default';
		$this->render('stub');
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
