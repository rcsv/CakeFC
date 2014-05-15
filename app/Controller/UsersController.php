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
		$this->layout = 'fullwidth';
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
	 *
	 * Handles login attempts from both facebook SDK and local
	 */
	public function login() {

    // Required Login Via Local SYSTEM
		if ($this->request->isPost()) {
			if($this->Auth->login()) {
				if($this->data['User']['rememberMe']) {
					unset($this->request->data['User']['rememberMe']);
					$this->Cookie->write('Auth', $this->request->data, true, '+2 weeks');
				}
				$this->redirect($this->Auth->redirectUrl());
			} else {
				// login failed.
				$state = $this->User->field('active', array('username' => $this->data['User']['username']));
				$str = $state == 0 ? 'Login error, wrong id or passwoth, or both.' : 'Your account is not active yet';
				$this->Session->setFlash($str, 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-error'));
			}
		}

		// When facebook login is used, facebook always returns $_GET['code'].

    //
    // Facebook LOGIN
    //
    // ## Initializing
    // You will need to have configured a Facebook App, which you can obtain
    // from the App Dashboard. Then, initialize the SDK with your app ID and
    // secret.
    // (in AppController::beforeFilter())
    // FacebookSession::setDefaultApplication('YOUR_APP_ID', 'YOUR_APP_SECRET');
    //
    // ## Authentication and authorization
    // The SDK can be used to support login your site using a Facebook account.
    // On the server-side, the SDK provides helper classes for the most common
    // senarios.
    //
    // For most websites, you'll use the FacebookRedirectLoginHelper. Generate
    // the login URL to redirect visitors to with the getLoginUrl() method,
    // redirect them, and then process the response from Facebook with the
    // getSessionFromRedirect() method, which returns a FacebookSession.
    //
		else if ($this->request->query('code')) {

			// user login successful
			$fb_user = $this->Facebook->getUser();      # Returns facebook user_id
			if ($fb_user) {
				$fb_user = $this->Facebook->api('/me'); # Returns user information.

				// We will verify if a local user exists first
				$local_user = $this->User->find('first', array(
					'conditions' => array('username' => $fb_user['email'])));

				// If exists, we will log them in
				if ($local_user) {
					$this->Auth->login($local_user['User']);
					$this->redirect($this->Auth->redirectUrl());
				} else {
					// Otherwise we will add a new user (Registration)
					$data['User'] = array(
						'username' => $fb_user['email'],
						'email' => $fb_user['email'],
						'active' => 1,
						'password' => AuthComponent::password(uniqid(md5(mt_rand())))); /// <- ...

					// You should change this part to include data validation
					$this->User->save($data, array('validate' => false));

					// After registration we will redirect them back here so they be logged in
					$this->redirect(Router::url('/users/login?code=true', true));
				}
			} else {
				// facebook login failed....
				//
			}
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

    if($this->request->is('get')) {
      $this->layout = 'fullwidth';
    }
	}

	public function logout() {
		$this->Cookie->delete('Auth');
		$this->Session->setFlash('See you again.', 'alert', array(
			'plugin' => 'BoostCake',
			'class' => 'alert-success'));
		$this->User->id = $this->Auth->user('id');
		return $this->redirect($this->Auth->logout());
	}

	public function edit($id = null) {
		$this->stub();
	}

	public function quit($id =null) {
		$this->User->id = $id;
		if(!$this->User->exists()) throw new NotFoundException(__('Invalid %s', __('User')));

		$this->request->onlyAllow('post', 'quit');

		if($this->User->saveField('active', 0)) {
			$this->Session->setFlash('We meet you again.', 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-success'));
		} else {
			$this->Session->setFlash('Target user could not be deleted. Please try again.', 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-error'));
		}
		return $this->redirect(array('action' => 'register'));

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
