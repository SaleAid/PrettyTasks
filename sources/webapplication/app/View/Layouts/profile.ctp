<?php
echo $this->Html->docType('html5');
?>

<html>
<head>
<?php
echo $this->Html->charset();
?>
<title><?php  echo $title_for_layout;  ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="<?php echo $description_for_layout; ?>" />
<meta name="keywords" content="<?php echo $keywords_for_layout; ?>" />
<meta name="author" content=""/>
<?php
echo $this->Html->meta('icon');
?>
    
     
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
<?php
echo $this->Html->css('bootstrap');
echo $this->Html->css('main.' . Configure::read('App.version'));
echo $this->fetch('toHead');
echo $scripts_for_layout;
?>
    
</head>
<body>
<div id="wrapper-all">
    <?php
    echo $this->element('main_menu');
    ?> 
    <div id="wrapper-content">
        <div id="wrapper">
            <div class="container">
            <?php echo $this->element('box', array(), array('cache' => array('key' => 'feedback', 'config' => 'elements'))); ?>
                <div class="row-fluid">
                    <?php
                    echo $this->element('user_menu');
                    ?> 
                
                    <div class="span9 ">
                        
                        <?php
                        echo $this->Session->flash('auth');
                        echo $this->Session->flash();
                        echo $content_for_layout;
                        ?>
                    </div>
                </div>
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
echo $this->Js->writeBuffer();
echo $this->Html->script('jquery-1.7.1.min');
echo $this->Html->script('bootstrap');
echo $this->Html->script('main.' . Configure::read('App.version'));
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
