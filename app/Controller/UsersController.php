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
		if($this->User->exists() && $in_hash === $this->User->getActivationHash()) {
			$this->User->saveField('active',1); // default 0
			$this->Session->setFlash('Your account has been activated.');
			
			// add profile record.
			App::uses('Profile', 'Model');
			$this->Profile = (new Profile)->set('user_id', $this->User->id);
			$this->Profile->save();
			
			// TODO Activity->save();
		} else {
			$this->Session->setFlash('This URL has already expired.');
		}
		$this->render('register_finished');
	}
	
	/**
	 * login method
	 */
	public function login() {
		if(!empty($this->data)) {
			if($this->Auth->login()) {
				if($this->data['User']['rememberMe']) {
					unset($this->request->data['User']['rememberMe']);
					$this->Cookie->write('Auth', $this->request->data, true, '+2 weeks');
				}
				return $this->redirect($this->Auth->redirectUrl());
			}
			
			// login failed.
			$state = $this->User->field('active', array('username' => $this->data['User']['username']));
			
			$str = $state == 0 ? 'Login error, wrong id or passwoth, or both.' : 'Your account is not active yet';
			$this->Session->setFlash($str, 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-error'));
		} else {
			
			// cookie login
			if($this->Cookie->check('Auth')) {
				$this->data = $this->Cookie->read('Auth');
				if($this->Auth->login()) {
					return $this->redirect($this->Auth->redirectUrl());
				}
				
				// cookie login failed.
				$this->Cookie->delete('Auth');
			}
		}
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
