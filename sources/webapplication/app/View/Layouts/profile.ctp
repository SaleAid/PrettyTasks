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
   
    <?php
        
        echo $this->Html->css('bootstrap.min');
        
        echo $this->Html->script('jquery-1.7.1.min.js');
        
        echo $this->Html->script('bootstrap.min.js');
        
        echo $this->Html->script('main.js');

		echo $scripts_for_layout;
    ?>
    
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Project name</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul>
          <?php echo $this->element('current_user'); ?>  
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

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
    
      <hr>
      <footer>
        <p>&copy; Company 2012</p>
      </footer>
   <?php echo $this->Js->writeBuffer(); ?>
  </body>
</html>
