<?php

	// app/View/Users/register.ctp
	// SNS の形式を取る。
	// システムの入り口であると同時に、register / signup の画面でもある。
	// login もできるといいんだけど、CakePHP でそれをやる方法をまだ知らない。
	
	echo $this->Form->create('User', array(
		'inputDefaults' => array(
			'div' => 'form-group',
			'wrapInput' => false,
			'class' => 'form-control'),
		'class' => 'well'));

	?>

	<fieldset>
		<legend><?php echo __('Sign Up'); ?></legend>


<?
		// username の入力エリア
		echo $this->Form->input('username', array(
			'label' => 'Your Name',
			'placeholder' => 'Username'));
	
		// email address の入力エリア
		echo $this->Form->input('email', array(
			'label' => 'Email',
			'placeholder' => 'Email',
			'after' => '<span class="help-block">Your Email address here.</span>'));
	
		// password 入力エリア 1
		echo $this->Form->input('password', array('placeholder' => 'Password'));
	
		// password 入力エリア 2
		echo $this->Form->input('temppassword', array(
			'type' => 'password',
			'placeholder' => 'password again',
			'label' => ''));
	
	
		// End User License Agreement のチェックボックス
		echo $this->Form->input('eula', array(
			'type' => 'checkbox',
			'wrapInput' => 'col col-md-9 col-md-offset-3',
			'label' => 'I agree with EULA.',
			'class' => false));
	
		// Sign up のボタン
	?><div class="form-group"><?php
		echo $this->Form->submit('Sign up', array(
			'div' => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-default'));
	
	?></div>
	
	<?php
	
	// Form の終了
	echo $this->Form->end();
