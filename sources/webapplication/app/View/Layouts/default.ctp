<?php echo $this->Html->docType('html5'); ?>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  <head>
    <?php echo $this->Html->charset(); ?>
    
    <title><?php echo $title_for_layout; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    
    <?php echo $this->Html->meta('icon');?>
    
    <style type="text/css">
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    

    <?php echo $this->Html->css('main'); ?>
    
    <?php echo $this->Html->css('tasks'); ?>
    
    <?php echo $this->Html->css('ui-lightness/jquery-ui-1.8.18.custom'); ?>
            
    
	<?php echo $scripts_for_layout; ?>
    
  </head>

  <body>
    
    <?php echo $this->element('main_menu'); ?> 
    
    <div class="container">
      
        <?php echo $this->Session->flash(); ?>
            
        <?php //echo $this->Session->flash('auth'); ?>

        <?php echo $content_for_layout; ?>
        
    
    </div>


   <?php //echo $this->element('sql_dump'); ?>

   <?php echo $this->Html->script('jquery-1.7.1.min.js'); ?>
    
    <?php echo $this->Html->script('jquery.jeditable.mini.js'); ?>
    
    <?php echo $this->Html->script('jquery-ui-1.8.18.custom.min.js'); ?>
        
    <?php echo $this->Html->script('bootstrap.min.js'); ?>
    
    <?php echo $this->Html->script('jquery.jgrowl.min.js'); ?>
    
    <?php echo $this->Html->script('jquery.inline-confirmation.js'); ?>
    
    <?php echo $this->Html->script('jquery.timepicker-1.2.2.js'); ?>
    
    <?php echo $this->Html->script('main.js'); ?>
    
    <?php echo $this->Html->script('tasks.js'); ?>

  </body>
</html>
