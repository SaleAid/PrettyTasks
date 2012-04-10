<!DOCTYPE html>
<html>
	<head> 
	<title>My Page</title> 
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.css" />
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.js"></script>
	<?php echo $this->fetch('scriptTop'); ?>
</head> 
<body >
<?php echo $content_for_layout; ?>
</body>
</html>
<?php //echo $this->element('sql_dump'); ?>