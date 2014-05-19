<?php

	// INDEX Cakephp Template PHP SCRIPT FILE
	// ---------- ---------- ----------

	
	// jquery-ui を読み込む
	echo $this->Html->script('//code.jquery.com/ui/1.11.0-beta.1/jquery-ui.min.js', array('inline' => false));
	echo $this->Html->css('//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/css/jquery-ui.min.css', array('inline' => false));
	
	// moment.js を読み込む
	echo $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.6.0/moment.min.js', array('inline' => false));
	
	// double full calendar sources
	// ---------- ---------- ----------
	
	// fullCalendar を読み込む
	echo $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.min.js', array('inline' => false));
	echo $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/gcal.js', array('inline' => false));
	echo $this->Html->css('//cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.min.css', array('inline' => false));
	echo $this->Html->css('//cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.print.css', array('inline' => false, 'media' => 'print'));

	// 他の jQuery Plugin を読み込む
	echo $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.0/basic/jquery.qtip.min.js', array('inline' => false));
	echo $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.0/basic/imagesloaded.pkg.min.js', array('inline' => false));
	echo $this->Html->css('//cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.0/jquery.qtip.min.css', array('inline' => false));
	
	echo $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.11/jquery.mousewheel.min.js', array('inline' => false));
	
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
	<div class="fixedleft-185-remain">
	<?php
		echo $this->element('fc/hugefc');
	?>
	</div>
	<div class="fixedleft-185">
	<?php
		echo $this->element('fc/minifc');
		echo $this->element('fc/dialog');
	?>
	</div>
</div>
