<?php
echo $this->Html->docType('html5');
?>

<html>
<head>
<?php  echo $this->Html->charset();?>
    
<title><?php  echo $title_for_layout;  ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="<?php echo $description_for_layout; ?>" />
<meta name="keywords" content="<?php echo $keywords_for_layout; ?>" />
<meta name="author" content=""/>
   
<?php
    echo $this->Html->meta('icon');
    echo $this->Html->css('bootstrap.min');
    echo $this->Html->css('jquery.jgrowl.'.Configure::read('App.version'));
    echo $this->fetch('toHead');
    echo $this->Html->css('main.' . Configure::read('App.version'));
    echo $this->Html->css('login.' . Configure::read('App.version'));
    echo $this->Html->css($this->Loginza->getCssUrl());
    echo $scripts_for_layout;
?>      
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->	
</head>

<body data-spy="scroll" data-target=".subnav" data-offset="50">

<div id="wrapper-all">

    <?php if(empty($currentUser)): ?>
        <?php echo $this->element('main_menu'); ?> 
    <?php else: ?>
        <?php echo $this->element('main_menu'); ?>
    <?php endif; ?>
    
    <div id="wrapper-content">
        <div id="wrapper">
            <div class="container">
            
            <?php
            
            echo $content_for_layout;
            ?>

            </div>
            
        </div>
    </div>
</div>

<?php
if(Configure::read('Config.language') =='eng'){
    echo $this->element('footer_eng');
}else{
    echo $this->element('footer');    
}?>

<?php echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');?>

<?php echo $this->Html->script('bootstrap.min');?>



<?php echo $this->Html->script('main.' . Configure::read('App.version'));?>

<?php echo $this->fetch('toFooter');?>

<?php echo $this->element('ga', array(), array(
    'cache' => array(
        'key' => 'ga', 
        'config' => 'elements'
    )
));
?>
<?php echo $this->element('js_lang', array(), array('cache' => array('key' => 'js_lang', 'config' => 'elements'))); ?> 

<?php echo $this->element('noscript', array(), array('cache' => array('key' => 'noscript', 'config' => 'elements'))); ?>
 
<?php echo $this->Js->writeBuffer();?>
 </body>
</html>

<?php
//TODO Remove it on release version
if (Configure::read('debug') == 2) {
    echo $this->element('sql_dump');
}
?>
