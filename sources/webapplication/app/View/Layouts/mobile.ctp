<?php echo $this->Html->docType('html5'); ?>
<html>
	<head> 
	<?php echo $this->Html->charset(); ?>
	<title>Best tasks - mobile version</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.css" />
	<?php echo $this->Html->css('m/tasks'); ?>
</head> 
<body >
<?php echo $content_for_layout; ?>
<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.js"></script>
<?php echo $this->Html->script('tasks.m.js'); ?>
</body>
</html>
<?php //echo $this->element('sql_dump'); ?>