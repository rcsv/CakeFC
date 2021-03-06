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
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css">

	
	<?php
		// fetch CSS files
		echo $this->fetch('css');

	?>
</head>
<body class="<?php echo $this->action ; ?>"><div class="container-liquid">
	<?php
		echo $this->Session->flash('auth') ;
		echo $this->Session->flash(); 
		
		?>
	<?php echo $this->fetch('content'); ?>

</div>
	<!-- javascript loading area -->
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.1/modernizr.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.1/js/bootstrap.min.js"></script>
	
	
	<!-- extend javascript -->
	<?php echo $this->fetch('script'); ?>
</body>
</html>
