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
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">

</head>
<body class="<?php echo $this->action ; ?>"><div class="container-liquid">
	<?php
		echo $this->Session->flash('auth') ;
		echo $this->Session->flash(); 
		?>
	<?php echo $this->fetch('content'); ?>

</div>
	<!-- javascript loading area -->
	<script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="//code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
	<script type="text/javascript" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	
	<?php echo $this->Html->script('modernizr'); ?>
	
	
	<!-- extend javascript -->
	<?php echo $this->fetch('script'); ?>
</body>
</html>
