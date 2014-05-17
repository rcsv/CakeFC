<?php

	// STUB.ctp 
	// --- 何はともあれ、何も考えていない場合や現時点で実装するつもりが無い
	// VIEW に対して与えられる CTP ファイル。
	
	
	
	// $my = AuthComponent::user() となって入ってくる予定。
	
	// ユーザーアカウントの凍結リンクの検証
	if(isset($my)) {
		echo $this->Form->postLink(__('Resign'), array(
			'controller' => 'users',
			'action' => 'resign',
			$my['id']));

