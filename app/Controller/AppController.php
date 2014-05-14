<?php
App::uses('Controller', 'Controller') ;
App::uses('User','Model');

class AppController extends Controller {

	//
	///@formatter:off
	public $helpers = array(
		'Session',

		// declare BoostCakes' Helpers. see the BoostCake plugin:
		// https://github.com/slywalker/cakephp-plugin-boost_cake
		'Html' => array('className' => 'BoostCake.BoostCakeHtml'),
		'Form' => array('className' => 'BoostCake.BoostCakeForm'),
		'Paginator' => array('className' => 'BoostCake.BoostCakePaginator')) ;
	///@formatter:on

	// Components -------------------------------------------------------------
	///@formatter:off
	public $components = array(
		'Session',
		'Cookie',
		'Auth' => array(
			'loginError' => 'Login Failed. Please check your username and password.',

			// Authentication error message.
			'authError' => 'Did you really think you are allowed to see that?',

			// set flash message styled bootstrap
			'flash' => array(
				'element' => 'alert',
				'key' => 'auth',
				'params' => array(
					'plugin' => 'BoostCake',
					'class '=> 'alert-error')),

			// It is magic words to control grant. 
			// AuthComponent call Controller::isAuthorized() method.
			'authorize' => array('Controller'),

			// User.active == 0 is authenticate user.
			'authenticate' => array(
				'Form' => array(

					// SimplePasswordHasher config doesn't work.
					//'passwordHasher' => array('className' => 'Simple', 'hashType' => 'sha256'),

					// use scope.
					'scope'=>array('User.active' => 1))),

			// every unlogged user can access '/users/login'.
			'loginAction' => array(
				'controller'=>'users',
				'action'=>'login'),

			// every registered user redirect dashboard after login.
			'loginRedirect' => array(
				'controller' => 'users',
				'action' => 'index'), // TODO change string index to dashboard after implemented.

			// every registered user will redirect login screen after logout action.
			'logoutRedirect' => array(
				'controller' => 'users',
				'action' => 'login'))) ;
	///@formatter:on

	// Callback methods
	// ------------------------------------------------------------------------


	/**
	 * isAuthorized method - Called from AuthComponent after beforeFilter().
	 *
	 * Write rules for common of each controller.
	 *
	 * @param array $user
	 */
	public function isAuthorized($user) {

		// ... return true has a risk of REDIRECT LOOP.
		return true ;
	}


	/**
	 * AppController::beforeFilter() decide realm of unauthorized user can access.
	 * 
	 * @see Controller::beforeFilter()
	 */
	public function beforeFilter() {
		/*
		 * TODO 1. Implement $this->set('my',$this->Auth->user()) at correct
		 * place nearby. TODO 2. Set login flag HERE. It often occured
		 * redirect-loop here when wrong implementation.
		 */
		 App::import('Vendor', 'facebook', array('file' => 'facebook'.DS.'facebook.php'));
		 $this->Facebook = new Facebook(array(
		 	'appId' => '',
		 	'secret' => ''));
		 	
		 
		 if($this->Session->check('Auth.User.offset')) {
		 	$this->Session->write('Auth.User.offset', $this->_getTimezoneOffset($this->Auth->user('timezone')));
		 }
	}
	
	public function beforeRender() {
		$this->set('fb_login_url', $this->Facebook->getLoginUrl(array(
			'redirect_uri' => Router::url(array(
				'controller' => 'users', 
				'action' => 'login'), true))));
		if($this->Auth->loggedIn()) {
		 	$this->set('user',$this->Auth->user());
		 }
	}

	public function addActivity($entity_id) {

		App::uses('Activity', 'Model') ;
		$this->Activity = new Activity() ;
		$this->Activity->saveActivityData($this->Auth->user('id'), $this, $entity_id);
	}

	/**
	 * 
	 * @return integer
	 */
	private function _getTimezoneOffset($timezone_id = null) {
		if($timezone_id == null) return false;

		$_timezones = DateTimeZone::listAbbreviations();
		foreach($_timezone as $TZ => $cities)  {
			foreach($cities as $city) {
				if(isset($city['timezone_id']) && $city['timezone_id'] == $timezone_id) {
					return round($city['offset'] / 3600, 1);
				}
			}
		}
		return false ;
	}
}
