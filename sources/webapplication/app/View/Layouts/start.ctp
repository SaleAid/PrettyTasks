<?php
echo $this->Html->docType('html5');
?>
<html>

<head>
<?php  echo $this->Html->charset();?>
    
<title><?php  echo $title_for_layout;  ?></title>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1"/>
<meta name="description" content="<?php echo $description_for_layout; ?>" />
<meta name="keywords" content="<?php echo $keywords_for_layout; ?>" />
<meta name="author" content=""/>
   
<?php
echo $this->Html->meta('icon');
echo $this->Html->css('bootstrap.min');
echo $this->Html->css($this->Loginza->getCssUrl());  
echo $this->fetch('toHead');
echo $scripts_for_layout;
//echo $this->Html->css('bootstrap-responsive.min');

?>      
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->	
</head>

<body data-spy="scroll" data-target=".subnav" data-offset="50">
<div id="wrapper-all">
    
    <?php
    if (!$currentUser):
        echo $this->element('main_menu', array(), array(
        "cache" => array('config' => 'elements', 'key' => Configure::read('Config.language'))
    ));
    else:
        echo $this->element('main_menu');
    endif;
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
echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');
echo $this->Html->script('bootstrap.min');
echo $this->fetch('toFooter');
echo $this->element('js_lang', array(), array('cache' => array('key' => 'js_lang', 'config' => 'elements')));
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
