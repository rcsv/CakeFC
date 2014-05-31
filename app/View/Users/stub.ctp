<?php

	// STUB.ctp 
	// --- 何はともあれ、何も考えていない場合や現時点で実装するつもりが無い
	// VIEW に対して与えられる CTP ファイル。
	
	
	
	// $my = AuthComponent::user() となって入ってくる予定。
	
	// ユーザーアカウントの凍結リンクの検証
	if(isset($user)) {
		echo $this->Form->postLink(__('Resign'), array(
			'controller' => 'users',
			'action' => 'resign',
			$my['id']));
	}

	// app/Controller/AppController.php で、使用する FormHelper を、CakePHP 謹製の
	// FormHelper から、BoostCake.BoostCakeFormHelper へ。
	// 更に Picker.PickerFormHelper に使用するヘルパーを変更。上記の順序で継承しているため、
	// 動作上に違いは無いのだが。それにしても、この BoostCake のようなちょうど良いプラグインの
	// 名前無いかなー。
	// PickerCollection だと長いような気がする。それでも Picker だと他のプラグインに埋もれて
	// しまいそうな気もするし。
	
	$this->Form->create('User');
	
	$this->Form->input('username');
	
	$this->Form->end('submit');
