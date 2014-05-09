<?php
App::uses('AppModel', 'Model');

/**
 * Profile Model
 * 
 * User モデルがレコードをひとつだけ使用するモデルで、付帯的なユーザー情報を保有します。
 * 1. id
 * 2. user_id
 * 3. nickname
 * 4. birthday
 * 5. phone
 * 6. company
 * 7. address
 * 8. gender
 * 9. website
 * 10. lastlogin ?
 * 11. about text
 * 12. facebook id
 * 13. linkedin id
 * 14. twitter id
 * 15. google+ id
 */
class Profile extends AppModel {

	// フィールド入力に関する制約条件は今のところありません。
	
	// Associations - 関係性を設定します。
	/**
	 * belongs to
	 * User モデルからは has one、Profile からは belongs to の関係になります。
	 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'));
}
