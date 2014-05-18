<?php
App::uses('AppModel', 'Model');

/**
 * Calendar Model - The User can create calendars and set access privileges.
 *
 */
class Calendar extends AppModel {

	public $displayField = 'title';

	public $validate = array(

		// Calendar.title validation
		// ------------------------------

		// Calendar.title required varchar(30).
		'title' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 30),
				'message' => 'Title must be shorter than 30.',
				'required' => true, 'allowEmpty' => false)),

		// Calendar.public validation
		// -------------------------------

		// Calendar.public must be boolean. thus TINYINT(1) in MySQL.
		'public' => array(
			'numeric' => array(
				'rule' => 'numeric')),

		// Calendar.color validation
		// ------------------------------

		// color must be # plus 6 digits numbers. e.g.) #999999
		// default: #F5F5F5 by Table Definition
		'color' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 7),
				'message' => 'Color format is invalid.',
				'allowEmpty' => true)));

	// Associations -----------------------------------------------------

	/*
	 * A Calendar belongs to User.
	 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'));

	/*
	 * A Calendar has many events
	 */
	public $hasMany = array(
		'Event' => array(
			'className' => 'Event',
			'foreignKey' => 'calendar_id',
			'dependent' => false));


	// Utility Function getCalendarList
	public function getCalendarList($id = null) {
		if(empty($id)) throw new NotFoundException();

		$this->unbindModel(array(
			'hasMany' => array(
				'Event')));
		$conditions = array(
			'conditions' => array(
				'OR' => array(
					$this->alias . '.user_id' => $id,
					$this->alias . '.public' => 1)),
			'fields' => array(
				$this->alias . '.id',
				$this->alias . '.user_id',
				$this->alias . '.title',
				$this->alias . '.public',
				$this->alias . '.color'),

			'order' => array(
				$this->alias . '.created',
				$this->alias . '.title DESC'));

		return $this->find('all', $conditions);
	}
}
