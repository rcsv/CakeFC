<?php

	// insert CSS for register screen
	echo $this->Html->css('cakefc-fullwidth',array('inline' => false));
?>
<div class="row">
	<div class="col-md-8"><div class="container">
		<h1><i class="glyphicon glyphicon-leaf"></i> c a k e f c <small>fullCalendar with CakePHP</small></h1>
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
