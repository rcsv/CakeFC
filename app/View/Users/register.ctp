<?php

	// insert CSS for register screen
	echo $this->Html->css('cakefc-fullwidth',array('inline' => false));
?>
<div class="row">
	<div class="col-md-8"><div class="container">
		<h1 id="cakefclogo"><i class="glyphicon glyphicon-leaf"></i> CAKE_FC </h1>
		<p>A <a href="#">fullCalendar</a> implementation with <a href="#">CakePHP</a>.</p>
	</div></div>
	<div class="col-md-4">
	
	<?php
		// call register form
		echo $this->element('register');

	?>
	</div>
	</div>
</div>
<div class="footer">
	CakeFC <small>&copy;</small>
</div>
