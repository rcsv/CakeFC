<?php
App::uses('AppModel', 'Model') ;


/**
 * Event Model -
 *
 * @property User $User
 * @property Calendar $Calendar
 *
 */
class Event extends AppModel {

	const SQL_FORMAT = 'Y-m-d H:i:s' ;

	/**
	 * fcfeed method
	 * 
	 * fetch events from database.
	 * @param array $data
	 */
	public function fcfeed($data) {
		$sql_start = date(self::SQL_FORMAT, $data['start']);
		$sql_end = date(self::SQL_FORMAT, $data['end']);

		$conditions = array('conditions' => array(
			'OR' => array(
				$this->alias . '.start BETWEEN ? AND ?' => array($sql_start, $sql_end),
				$this->alias . '.end BETWEEN ? AND ?' => array($sql_start, $sql_end))));

		return $this->find('all', $conditions);
	}

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		// Event.user_id validation
		// ------------------------
		'user_id' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'user_id sets a illegal format.',
				'required' => true, 'allowEmpty' => false)),

		// Event.calendar_id validation
		// ------------------------
		'calendar_id' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'calendar_id sets a illegal format.',
				'required' => true, 'allowEmpty' => false)),

		// Event.title validation
		// ------------------------
		'title' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'title is a required field.',
				'required' => true, 'allowEmpty' => false)),

		// Event.start validation
		// ------------------------
		'start' => array(
			'datetime' => array(
				'rule' => 'datetime')),

		// Event.end validation
		// ------------------------
		'end' => array(
			'datetime' => array(
				'rule' => 'datetime',
				'required' => false, 'allowEmpty' => true)));

	/**
	 * Add form において、Ajax から送られてくるデータをセットして整えます。
	 *
	 * @param unknown $data
	 */
	public function prepareAddForm($data) {

		$this->data['Event']['start'] = !empty($data['start']) ? date('Y-m-d H:i:s', $data['start']) : '' ;
		$this->data['Event']['end'] = !empty($data['end']) ? date('Y-m-d H:i:s', $data['end']) : '' ;
		$this->data['Event']['allday'] = $data['allDay'] == 'true' ? 1 : 0 ;

		return $this->data ;
	}


	/**
	 * parseTitle
	 *
	 * 10:00 meeting at Meeting room #3
	 * -> 10:00
	 * -> meeting
	 * -> Meeting room #3
	 *
	 * @param unknown $data
	 */
	public function parseTitle($data) {

		// 最初に、解析対象にしないデータも含めて、全て戻す対象とする。解析対象がなければ
		// このまま。
		$this->data = $data ;

		// あとでもう一度比較するが、開始と終了の日付・時刻が全く同じ場合は、1 時間の差を
		// つけることで、fullCalendar の不具合を避けることができる。
		$rule1 = false ;
		if (strcmp($data[$this->alias]['start'], $data[$this->alias]['end']) == 0) {
			$this->data[$this->alias]['end'] = date('Y-m-d H:i:s', 3600 + strtotime($this->data[$this->alias]['start'])) ;
			$rule1 = true ;
		}

		// タイトル文字列を分解。トークンの数が 2 以上あれば、時刻があるかもしれない。
		$qadd = explode(' ', trim($data[$this->alias]['title']), 2) ;

		if (count($qadd) == 1) {			// 解析対象が無いため、戻る。
			return $this->data ;
		}

		// ここからは、解析対象が何らかの形で残っているもの。開始時刻があれば、その時刻を
		// 示す文字列を削除する。開始時刻の解析対象になるのは、allday = true だけ。
		// allday には get method から文字列でやってきます。このため、=== "true" で
		// 比較する必要がありそうです。
		if ($data[$this->alias]['allday'] === '1') {

			// start を基点とした unix time を作り直します。エラーの場合、-1 が戻ります。
			$start = strtotime($qadd[0], strtotime($data[$this->alias]['start'])) ;

			if ($start != -1) {
				// $start には日付が入った。これで終日イベントではなくなった。
				$this->data[$this->alias]['allday'] = 0 ; // 終日イベントではない。
				$this->data[$this->alias]['start'] = date('Y-m-d H:i:s', $start) ;

				// 完了時刻の底上げ。
				$this->data[$this->alias]['end'] = date('Y-m-d H:i:s', $start + 3600) ;

				// title の文字列には、開始時刻を削ったものを改めて保存しなおす。
				$this->data[$this->alias]['title'] = $qadd[1] ;

				//
				// ここから、今度は終了時刻が存在しているかどうかを確認する。残りの文字列
				// は全てトークン分解。最初の２つのトークンが to <時刻> であれば、終了時
				// 刻変も変更する。ただし、既に保存済みの終了時刻のデータは 1 時間後に設定
				// しているため、１時間後を示していれば何の意味も無いロジックとなる。
				//
				// 残っているトークンが 3 つ以上なければ、ただの時刻だけを記載したものとな
				// ってしまうため、残りトークン数に制限をかける。
				//
				$qadd = explode(' ', $qadd[1]) ;
				if (count($qadd) > 2 && in_array($qadd[0], array('to','~','-'))) {

					// 終了時刻の可能性がある $qadd[1] が時刻変換できるか試してみる。
					// $this->data['Event']['end'] は既に改変済みのため、基底時間は
					// $data['Event']['end'] を使用する。
					$end = strtotime($qadd[1], strtotime($data[$this->alias]['end'])) ;
					if ($end != -1) {

						// 終了時刻に相当するデータと、残りのタイトルに相当する部分が
						// つかったので、終了時刻を更新する。同じ値が既に入っている可
						// 性もある。
						$this->data[$this->alias]['end'] = date('Y-m-d H:i:s', $end) ;

						// 元の文字列をまた解析対象にするため、title 文字列から終了     時
						// 刻を削ったものをに更新しておく。
						array_shift($qadd) ; // to,~,- etc.
						array_shift($qadd) ; // 16:30, for example.
						$this->data[$this->alias]['title'] = implode(' ', $qadd) ;
					}
				}
				// 最後に、開始と終了の差分をチェックし、やっぱり同じ時刻、時刻の逆転が
				// 発生していた場合は、改めて、「end = start + 1 時間」というルールに
				// 戻す。かなり冗長だが仕方ない。
				if (strtotime($this->data[$this->alias]['start'] >= strtotime($this->data[$this->alias]['end']))) {
					$this->data[$this->alias]['end'] = date('Y-m-d H:i:s', 3600 + strtotime($this->data[$this->alias]['start'])) ;
				}
			}
		}

		// 開始時刻と終了時刻の解析とは別に、文字列の後尾に at ~~~~ となっていた場合、~~~~
		// の文字列を「場所」として保存する。この文字列は、かならず
		// $this->data['Event']['title'] を使用して分析。
		$magicAt = ' at ' ;
		$pos = strpos($this->data['Event']['title'], $magicAt) ;

		if ($pos !== false) {
			// ' at ' という文字列が見つかった。これより後ろに続くのは、場所と見做す領域。
			$this->data[$this->alias]['place'] = substr($this->data[$this->alias]['title'], $pos + strlen($magicAt)) ;

			// ' at ' 以下を削った substr が、最後のタイトルとなる。
			$this->data[$this->alias]['title'] = substr($this->data[$this->alias]['title'], 0, $pos) ;
		}

		return $this->data ;
	}

	// The Associations below have been created with all possible keys, those that are not needed can be removed


	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''),

		'Calendar' => array(
			'className' => 'Calendar',
			'foreignKey' => 'calendar_id',
			'conditions' => '',
			'fields' => '',
			'order' => '')) ;
}
