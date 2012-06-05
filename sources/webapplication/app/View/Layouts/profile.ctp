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
    
    <?php echo $this->Html->css('bootstrap'); ?>
   
    <?php $this->Combinator->add_libs('css', array('main'))?>
   
    <?php
        
        echo $this->fetch('toHead'); 
        
        echo $scripts_for_layout;

    ?>
    
    <?php echo $this->Combinator->scripts('css'); ?> 
    
  </head>

  <body>
 <div id="wrapper-all">
<?php echo $this->element('main_menu'); ?> 
    <div id="wrapper-content">
    <div id="wrapper">
    <div class="container">
      <div class="row-fluid">
        <?php echo $this->element('user_menu'); ?> 
        
        <div class="span9 ">
            <?php echo $this->Session->flash('auth'); ?>

            <?php echo $this->Session->flash(); ?>
            
            <?php echo $content_for_layout; ?>
        
        </div>
      </div><!--/row-->
    </div>
 </div>
 </div>   
</div>

<?php echo $this->element('footer'); ?>
<?php
    echo $this->Js->writeBuffer(); 

    echo $this->Html->script('jquery-1.7.1.min.js');
    
    echo $this->Html->script('bootstrap.js');
    
    echo $this->Html->script('main.js');

	echo $this->fetch('toFooter'); 
?>
   
<?php echo $this->Combinator->scripts('js');?>
<?php echo $this->element('ga', array(), array('cache' => array('key' => 'ga', 'config' => 'elements'))); ?>
   
  </body>
</html>
