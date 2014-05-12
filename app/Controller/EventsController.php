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
