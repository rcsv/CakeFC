<?php

	// app/View/Users/register.ctp
	// SNS の形式を取る。
	// システムの入り口であると同時に、register / signup の画面でもある。
	// login もできるといいんだけど、CakePHP でそれをやる方法をまだ知らない。
	
	echo $this->Form->create('User', array());
	
	// username の入力エリア
	
	// email address の入力エリア
	
	// password 入力エリア 1
	
	// password 入力エリア 2
	
	// End User License Agreement のチェックボックス
	
	// Sign up のボタン
	
	
	echo $this->Form->end();
