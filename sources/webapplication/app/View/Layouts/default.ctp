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
    
    <?php echo $this->Html->css('bootstrap'); ?>
    
    <?php echo $this->Html->css('jquery.jgrowl'); ?>
    
    <?php echo $this->Html->css('ui-lightness/jquery-ui-1.8.18.custom'); ?>
    
    <?php echo $this->Html->css('print', null, array('media' => 'print')); ?>
	
    <?php echo $this->fetch('toHead'); ?> 
    
    <?php echo $this->Html->css('main.'.Configure::read('App.version'))?>
    
         
    
    <?php echo $scripts_for_layout; ?>      
	
  </head>

  <body data-spy="scroll" data-target=".subnav" data-offset="50">
   <div id="wrapper-all">
 
    <?php echo $this->element('main_menu'); ?> 
    
    <div id="wrapper-content">
        <div id="wrapper">
            <div class="container">
              
                <?php echo $this->Session->flash(); ?>
                    
                <?php //echo $this->Session->flash('auth'); ?>
        
                <?php echo $content_for_layout; ?>
                
            </div>
        </div>
    </div>
</div>
<?php echo $this->element('footer'); ?> 

<?php //echo $this->element('sql_dump'); ?>

<?php echo $this->Html->script('jquery-1.7.1.min'); ?>

<?php echo $this->Html->script('jquery-ui-1.8.18.custom.min'); ?>
    
<?php echo $this->Html->script('bootstrap'); ?>

<?php echo $this->Html->script('main.'.Configure::read('App.version')); ?>

<?php echo $this->fetch('toFooter'); ?>
 
<?php echo $this->element('ga', array(), array('cache' => array('key' => 'ga', 'config' => 'elements'))); ?> 
  </body>
</html>
