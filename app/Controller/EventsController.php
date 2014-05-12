<?php
App::uses('AppController', 'Controller');

class EventsController extends AppController {

	// action methods
	/**
	 * index method
	 * 
	 * インデックスでは、fullCalendar を二つ表示する。
	 * GET メソッドでは HTML を戻し、ajax では json を戻す。
	 */
	public function index() {
		if($this->request->is('ajax')) {
			$this->set('events', $this->Event->fcfeed($this->request->query));
			$this->layout = 'ajax';
			$this->render('jsonlist');
		} else {
			$this->layout = 'default';
			
			// send Calendars list
			App::uses('Calendar', 'Model');
			$calendars = $this->Calendar = (new Calendar)->getCalendarList($this->Auth->user('id'));
			$this->set(compact('calendars'));
		}
	}
	
	public function add() {
		if($this->request->is('post', 'ajax')) {
			$this->request->data['Event']['user_id'] = $this->Auth->user('id');
			$this->Event->parseTitle($this->request->data);
			if($this->Event->save()) {
				$event = $this->Event->find('first', array(
					'conditions' => array(
						'Event.' . $this->Event->primaryKey => $this->Event->id)));

				$this->set(compact('event'));
				$this->layout = 'ajax';
				$this->render('json');
			}
		}
		
		// send calendar list
		if($this->request->is('get')) {
			$calendars = $this->Event->Calendar->find('list');
			$this->set(compact('calendars'));
			$this->request->data = $this->Event->prepareAddForm($this->request->query);
		}
		
		// display add form
		if($this->request->is('ajax')) {
			$this->layout = 'ajax';
			$this->render('ajax_add');
		}
	}
	
	/**
	 * change method
	 * 
	 * このメソッドをつつくのは AJAX 経由のみ。
	 */
	public function change($id = null, $start, $end, $allDay = 'false') {
		$this->Event->id = $id;
		if(!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid %s', __('Event')));
		}
		
		// Event.id = $id
		$options = array(
			'conditions' => array(
				'Event.' . $this->Event->primaryKey => $id));
		
		$this->Event->unbindModel(array('belongsTo' => array('User')));
		$event = $this->Event->find('first', $options);
		
		$event['Event']['start'] = date('Y-m-d H:i:s', $start);
		$event['Event']['end'] = date('Y-m-d H:i:s', $end);
		$event['Event']['allday'] = (strcmp($allDay, 'true') == 0) ? 1 : 0 ;
		$event['Event']['modified'] = null;
		
		$this->autoLayout = false;
		$this->autoRender = false;
		if($this->Event->save($event)) {
			return true;
		}
		return false;
	}

	// TODO implement edit method
	public function edit($id = null) {
		$this->layout = false;
		if(!$this->Event->exists($id)) throw new NotFoundException(__('Invalid %s', __('Event')));
	}
	
	// TODO implement delete method
	public function delete($id = null) {
		$this->layout = false;
		if(!$this->Event->exists($id)) throw new NotFoundException(__('Invalid %s', __('Event')));
		
		// AJAX で POST, DELETE するので、
		// 戻りは適当にする予定。
		// $this->request->onlyAllow('post', 'delete');
		if($this->Event->delete()) {
			return true;
		}
		return false;
	}
	
	
	// methods override
	// ---------------------------

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
