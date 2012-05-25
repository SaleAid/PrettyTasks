<?php echo $this->Html->docType('html5'); ?>

  <head>
    <?php echo $this->Html->charset(); ?>
    
    <title><?php echo $title_for_layout; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <?php echo $this->Html->meta('icon');?>
    
     
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    

   
    <?php echo $this->Html->css('main'); ?>
   
    <?php
        
        echo $this->Html->css('bootstrap.min');
        
        echo $this->fetch('toHead'); 
        
        echo $scripts_for_layout;

    ?>
    
  </head>

  <body>
 <div id="wrapper-all">
<?php echo $this->element('main_menu'); ?> 
    <div id="wrapper-content">
    <div id="wrapper">
    <div class="container-fluid">
      <div class="row-fluid">
        <?php echo $this->element('user_menu'); ?> 
        
        <div class="span8 offset2">
            <?php echo $this->Session->flash('auth'); ?>

            <?php echo $this->Session->flash(); ?>
            
            <?php echo $content_for_layout; ?>
        
        </div>
      </div><!--/row-->
        
    <div class="push"><!--//--></div>
    </div>
 </div>
 </div>   
</div>
      <footer>
            <div class="container">
        <p>&copy; Company 2012</p>
    </div> 
      </footer>
   <?php
        echo $this->Js->writeBuffer(); 
   
        echo $this->Html->script('jquery-1.7.1.min.js');
        
        echo $this->Html->script('bootstrap.min.js');
        
        echo $this->Html->script('main.js');

		
		
		echo $this->fetch('toFooter'); 
   
   
   ?>
  </body>
</html>
