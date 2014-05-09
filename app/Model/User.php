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
	 * belongsTo association
	 * @ver array
	 */
}
