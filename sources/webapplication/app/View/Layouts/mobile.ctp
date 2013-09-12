<!DOCTYPE html>
<html>
<head>
<title>Prettytasks Mobile page</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" 	href="//code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
    <script src="//code.jquery.com/jquery-1.9.1.min.js"></script>
    <script	src="//code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
    <link rel="stylesheet" 	href="/css/custom_m2.css" />
<?php if(isset($csrfToken)): ?>
    <meta name="csrf-token" content="<?php echo $csrfToken; ?>"/>
<?php endif; ?> 

</head>
<body>
<?php echo $content_for_layout;?>

<?php echo $this->Html->script('m2/tasks'); ?> 
</body>
</html>
