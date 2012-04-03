<?php echo $this->Html->docType('html5'); ?>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  <head>
    <?php echo $this->Html->charset(); ?>
    
    <title><?php echo $title_for_layout; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <?php echo $this->Html->meta('icon');?>
    
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    

    <?php echo $this->Html->css('main'); ?>
        
    <?php echo $this->Html->script('jquery-1.7.1.min.js'); ?>
        
    <?php echo $this->Html->script('bootstrap.min.js'); ?>
    
    <?php echo $this->Html->script('main.js'); ?>

	<?php echo $scripts_for_layout; ?>
    
  </head>

  <body>
    
    <?php echo $this->element('main_menu'); ?> 
    
    <div class="container ">
      
        <?php echo $this->Session->flash(); ?>
            
        <?php //echo $this->Session->flash('auth'); ?>

        <?php echo $content_for_layout; ?>
        
    <div class="push"><!--//--></div>
    </div>
    
      <hr>
      <footer>
        <p>&copy; Company 2012</p>
      </footer>
   <?php echo $this->Js->writeBuffer(); ?>
  </body>
</html>
