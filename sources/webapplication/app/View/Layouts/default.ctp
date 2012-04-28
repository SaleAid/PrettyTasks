<?php

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<?php echo $this->Html->docType('html5'); ?>

<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
    <meta name="google-site-verification" content="eaAqHVdKZqG9JWK-q64SVmGnr8CAJdhWYBzdWI0sHQM" />
	<?php
		
		echo $scripts_for_layout;
	?>
    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-29304740-1']);
      _gaq.push(['_trackPageview']);
        
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>

<?php //echo $this->Js->writeBuffer(array('cache'=>TRUE));?>

</head>
<body>
	<div id="container">
		<div id="content">
		<?php echo $content_for_layout; ?>
        </div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>