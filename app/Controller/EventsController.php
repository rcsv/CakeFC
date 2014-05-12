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
						'Event.id' => $this->Event->id)));

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
	
	public function change($id = null, $start, $end, $allDay = 'false') {
		
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
