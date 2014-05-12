<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title><?php echo $this->action . ' || ' . $title_for_layout; ?></title>
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="description" content="CakeFC, fullCalendar with CakePHP">
	<?php echo $this->Html->meta('icon'); ?>

	<!-- CSS -->
</head>
<body class="<?php echo $this->action ; ?>"><div class="container-liquid">
	<?php
		echo $this->Session->flash('auth') ;
		echo $this->Session->flash(); 
		?>
	<?php echo $this->fetch('content'); ?>

</div>
	<!-- javascript loading area -->
	<?php echo $this->Html->script('jquery-2.1.0.min'); ?>
	
	<?php echo $this->Html->script('bootstrap.min'); ?>
	
	<?php echo $this->Html->script('modernizr'); ?>
	
	
	<!-- extend javascript -->
	<?php echo $this->fetch('script'); ?>
</body>
</html>
