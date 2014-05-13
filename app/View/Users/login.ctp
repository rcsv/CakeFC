<?php
	// app/View/Users/login.ctp
	
	// form
	echo $this->Form->create('User', array());
	
	// inputs
	echo $this->Form->input('username',array(
		'placeholder' => 'Username'));
	
	echo $this->Form->input('password', array(
		'placeholder' => 'Password'));
	
	echo $this->Form->input('rememberMe', array(
		'type' => 'checkbox'));
	
	echo $this->Form->end('Login');
