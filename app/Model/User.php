<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 * 
 * ユーザーモデル。必要なフィールドは下記の通り。いずれ、schema.php に出てくることでしょう。
 * 
 * 1. username
 * 2. password
 * 3. active
 * 4. timezone 文字列。timezone を持ちます。DateTimezone::listAbbreviations() メソッドで出力されるタイムゾーンのリスト。
 * 5. image
 * 6. image_dir
 * 7. created
 * 8. modified
 * 
 * CakeDC::Users plugin の劣化版になってしまいますが、仕方ないです。
 * 
 * 関連テーブルに、Profile テーブルのレコードをひとつだけ持ちます。ユーザー情報の拡張情報を
 * 保存するためです。また、データを追加した、削除した等の情報を持つため、これとは別途、活動
 * を記録するためのテーブルも持ちます。
 * 
 * - Profile (hasOne)
 * - Activity (hasMany)
 */
class User extends AppModel {
	
	// Associations - 関係性を設定します。
	// ------------------------------------
	/**
	 * hasOne association
	 * @ver array
	 */
	public $hasOne = array(
		// Every User has one profile.
		'Profile' => array(
			'className' => 'Profile',
			'foreignKey' => 'user_id',
			'dependent' => true));

	/**
	 * hasMany association
	 * @ver array
	 */
	public $hasMany = array(
		// Every user has many activities.
		'Activity' => array(
			'className' => 'Activity',
			'foreignKey' => 'user_id',
			'dependent' => true,
			'order' => 'Activity.created DESC'));


	// Validation rules 
	// それぞれのデータ項目に対応する、健全性の検証を設定します。
	// ------------------------------------
	///@formatter:off
	public $validate = array(
		// User.username VARCHAR(20) NOT NULL UNIQUE
		'username' => array(
			
			// username は作成時に必須となります。
			'required' => array(
				'rule' => 'notEmpty',
				'required' => true, 'allowEmpty' => false, // notEmpty に required, !allowEmpty をつける意味があるのだろうか？
				'message' => 'Please enter a username.',
				'on' => 'create'),

			// username はアルファベット、数字で構成されている必要があります。
			'alpha' => array(
				'rule' => 'alphaNumericDashUnderscore',
				'message' => 'The username must be consist of letters, numeric, hyphen and underscore.'),

			// username は既に使用されていた場合 NG です。
			'unique_username' => array(
				'rule' => array('isUnique','username'),
				'message' => 'This username is already in use.'),
			
			// username は最低でも 3 文字必要です。
			'atleast_3' => array(
				'rule' => array('minLength', 3),
				'message' => 'The username must have at least 3 characters.'),

			// username は最長でも 20 文字に収めてください。
			'max_length' => array(
				'rule' => array('maxLength', 20),
				'message' => 'The username is too long.')),


		// User.email VARCHAR(50) NOT NULL UNIQUE
		'email' => array(
			
			// email は作成時に必須のフィールドとなります。
			'required' => array(
				'rule' => 'notEmpty',
				'required' => true, 'allowEmpty' => false,
				'message' => 'The email address is required.',
				'on' => 'create'),

			// email はメールアドレスの形式として適切なものであるとします。
			'is_valid_format' => array(
				'rule' => 'email',
				'required' => true, 'allowEmpty' => false,
				'message' => 'Please enter a valid email address.'),

			// email は既に登録されている場合、ダメです。
			'is_unique' => array(
				'rule' => array('isUnique','email'),
				'message' => 'Email address you specified is already in use.')),


		// User.password VARCHAR(128) NOT NULL
		'password' => array(
			
			// password は必須です。
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter a password.'),

			// password は短すぎる場合、弾きます。
			'too_short' => array(
				'rule' => array('minLength', 6),
				'message' => array('The password must have at least 6 characters.'))),


		// (User.)temppassword --- password との比較用フィールド
		'temppassword' => array(
			'match' => array(
				'rule' => array('confirmPassword', 'temppassword', 'password'),
				'message' => 'The passwords are not same. Please try again.')),

		// (User.)eula --- End User License agreement のチェックボックス
		'eula' => array(
			'agree_eula' => array(
				'rule' => array('comparison', 'equal to', 1),
				'required' => true, 'allowEmpty' => false,
				'message' => 'You must read and agree EULA before sign up.',
				'on' => 'create')));
	///@formatter:on
	
	/**
	 * alphaNumericDashUnderscore
	 * http://book.cakephp.org/2.0/en/models/data-validation.html
	 * 
	 * @param array $check
	 */
	public function alphaNumericDashUnderscore($check) {
		$value = array_values($check);
		$value = $value[0];
		return preg_match('|^[0-9a-zA-Z_-]*$|', $value);	
	}
	
	/**
	 * confirmPassword
	 * password と temppassword のような、二つの文字列を評価するメソッドです。
	 * CakePHP の基本検証メソッド集にありそうだけど、探していない。
	 * 
	 * @param string $check 使いません。
	 * @param string $compareTo 比較対象その１
	 * @param string $compareOf 比較対象その２
	 * @return boolean 同じなら true, otherwise returns false.
	 */
	public function confirmPassword($check, $compareTo, $compareOf) {
		$p = $this->data[$this->alias][$compareOf];
		$c = $this->data[$this->alias][$compareTo];
		if($p==$c) {
			$this->data[$this->alias]['password'] = $p;
			return true;
		}
		return false;
	}
	
	/**
	 * getActivationHash method
	 * 
	 * 本登録用の URL を作成するための、難解な文字列を、CakePHP が管理している
	 * modified フィールドから MD5 を使って生成します。
	 */
	public function getActivationHash() {
		if(!isset($this->id)) return false;
		return Security::hash($this->field('modified'), 'md5', true);
	}
	
	/**
	 * isOwnedBy method
	 * 
	 * 所有者が自分自身か否か調べるメソッドです。Controller::isAuthorized() から
	 * 呼ばれる予定です。
	 */
	public function isOwnedBy($postId, $userId) {
		return $postId === $userId ;
	}
	
	public function beforeSave($options = array()) {
		// User.password を保存前にハッシュし、AuthComponent::login() ができるようにします。
		if(isset($this->data[$this->alias]['password'])){
			App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
			$this->data[$this->alias]['password'] = (new SimplePasswordHasher)->hash($this->data[$this->alias]['password']);
		}
		parent::beforeSave($options);
	}
}
