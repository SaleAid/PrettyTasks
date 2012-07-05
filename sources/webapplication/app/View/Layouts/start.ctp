<?php
echo $this->Html->docType('html5');
?>
<html>
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<head>
<?php  echo $this->Html->charset();?>
    
<title><?php  echo $title_for_layout;  ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="<?php echo $description_for_layout; ?>" />
<meta name="keywords" content="<?php echo $keywords_for_layout; ?>" />
<meta name="author" content=""/>
   
<?php
echo $this->Html->meta('icon');
echo $this->Html->css('bootstrap');
echo $this->Html->css('ui-lightness/jquery-ui-1.8.18.custom');
echo $this->Html->css('print.' . Configure::read('App.version'), null, array(
    'media' => 'print'
));
echo $this->fetch('toHead');
echo $this->Html->css('start.' . Configure::read('App.version'));
echo $scripts_for_layout;
?>      
	
</head>

<body data-spy="scroll" data-target=".subnav" data-offset="50">
<div id="wrapper-all">
    <?php
    echo $this->element('main_menu');
    ?> 
    <div id="wrapper-content">
        <div id="wrapper">
            <div class="container">
            <?php
            echo $this->Session->flash();
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
}
echo $this->Html->script('jquery-1.7.1.min');
echo $this->Html->script('jquery-ui-1.8.18.custom.min');
echo $this->Html->script('bootstrap');
//echo $this->Html->script('main.' . Configure::read('App.version'));
echo $this->fetch('toFooter');
echo $this->element('ga', array(), array(
    'cache' => array(
        'key' => 'ga', 
        'config' => 'elements'
    )
));
?> 
 </body>
</html>

<?php
//TODO Remove it on release version
if (Configure::read('debug') == 2) {
    echo $this->element('sql_dump');
}
?>
