<?php

	// app/View/Users/register.ctp
	// SNS の形式を取る。
	// システムの入り口であると同時に、register / signup の画面でもある。
	// login もできるといいんだけど、CakePHP でそれをやる方法をまだ知らない。
	
	echo $this->Form->create('User', array());
	echo $this->Form->end();
