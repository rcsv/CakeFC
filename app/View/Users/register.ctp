<?php

	// insert CSS for register screen
	echo $this->Html->css('cakefc-fullwidth',array('inline' => false));
?>
<div class="row">
	<div class="col-md-9">
	</div>
	<div class="col-md-4">
	<?php
		// call register form
		echo $this->element('register');

	?>
</div>

<div class="footer">
	CakeFC <small>&copy;</small>
</div>
