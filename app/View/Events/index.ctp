<?php

	// INDEX Cakephp Template PHP SCRIPT FILE
	// ---------- ---------- ----------

	
	// jquery-ui を読み込む
	echo $this->Html->script('//code.jquery.com/ui/1.11.0-beta.1/jquery-ui.min.js', array('inline' => false));

	// moment.js を読み込む
	echo $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.6.0/moment.min.js', array('inline' => false));
	
	// double full calendar sources
	// ---------- ---------- ----------
	
	// fullCalendar を読み込む
	echo $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.min.js', array('inline' => false));
	echo $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/gcal.js', array('inline' => false));
	echo $this->Html->css('//cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.min.css', array('inline' => false));
	echo $this->Html->css('//cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.print.css', array('inline' => false, 'media' => 'print'));

	// double full calendar control javascript を読み込む
	echo $this->Html->script('cakefc', array('inline' => false));

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
