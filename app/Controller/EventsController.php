App::uses('AppController', 'Controller');

class EventsController extends AppController {


	// methods override

	public function beforeFilter() {
		parent::beforeFilter();
	}

	public function isAuthorized($user) {
		if(in_array($this->action, array('index'))) {
			return true;
		}
		
		parent::isAuthorized($user);
	}
}
