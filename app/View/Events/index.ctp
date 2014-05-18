<?php

	// INDEX Cakephp Template PHP SCRIPT FILE
	// ---------- ---------- ----------


	// double full calendar sources


?>
<?php
	// At first TOP NAVIGATION AREA ALLOCATE
?>
<div class="">
	<?php echo $this->element('fc/header'); ?>
</div>
<?php
	// LEFT : RIGHT
	//    2 : 10
?>
<div class="row">
	<div class="fixedleft-185">
	<?php
		echo $this->element('fc/minifc');
	?>
	</div>
	<div class="fixedleft-185-remain">
	<?php
		echo $this->element('fc/hugefc');
	?>
	</div>
</div>
