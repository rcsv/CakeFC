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

			// include elements
			echo $this->element('login');

?>
		</div>
	</div>
	<div id="footer"><div class="container">
	 CakeFC <small>&copy;</small>
	</div></div>
