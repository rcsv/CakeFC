<?php

		// insert CSS for register screen
		echo $this->Html->css('cakefc-fullwidth', array('inline' => false));
	?>
	<div class="row">
		<div class="col-md-10"><div class="container">
			<h1 id="cakefclogo"><i class="glyphicon glyphicon-leaf"></i> Cake FC</h1>
			<p>A <a href="#">fullCalendar</a> implementation with <a href="#">CakePHP</a>.</p>
		</div></div>
		<div class="col-md-2">
			<?php

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

?>
		</div>
	</div>
	<div class="footer"> CakeFC <small>&copy;</small></div>
