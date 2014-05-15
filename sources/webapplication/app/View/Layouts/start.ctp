<?php
echo $this->Html->docType('html5');
?>
<html>

<head>
<?php  echo $this->Html->charset();?>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $description_for_layout; ?>" />
    <meta name="keywords" content="<?php echo $keywords_for_layout; ?>" />
    <meta name="author" content=""/>

    <title><?php  echo $title_for_layout;  ?></title>
       
    <?php
    echo $this->Html->meta('icon');
    echo $this->Html->css('/font-awesome/css/font-awesome.min.css');
    echo $this->Html->css('start/bootstrap.min');
    echo $this->Html->css($this->Loginza->getCssUrl());
    
    echo $this->fetch('toHead');
    echo $scripts_for_layout;
    
    ?>      
    
</head>

<body>
    <nav class="navbar navbar-default navbar-fixed-top navbar-pr" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php
                    echo $this->Html->link(
                        $this->Html->image("brand.". Configure::read('App.version') .".png", 
                                        array("alt" => "Pretty Tasks",
                                              'class' => 'brand',
                                              'width' => 156, 
                                              'height' => 30, 
                                              )
                                        ),  
                        array('controller' => 'pages', 'action' => 'index'),
                        array('escape' => false, 'class' => 'navbar-brand')
                    );
                ?>
                
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-left navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <?php echo $this->Html->link(
                            __d('pages', 'About'),
                            array('controller' => 'pages', 'action' => 'about')
                        );?>
                    </li>
                    <li>
                        <?php echo $this->Html->link(
                            __d('pages', 'Contact'),
                            array('controller' => 'pages', 'action' => 'contacts')
                        );?>
                    </li>
                </ul>
            </div>
            <div class="collapse navbar-collapse navbar-right navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <div class="btn-group btn-group-lang">
                            <button type="button" class="btn btn-link btn-link-lang dropdown-toggle" data-toggle="dropdown">
                                <?php echo Configure::read('Config.lang.available.'. Configure::read('Config.langURL') .'.name'); ?>
                                <i class="small fa fa-angle-double-down"></i>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                            <?php foreach(Configure::read('Config.lang.available') as $key => $lang) : ?>
                                <li><a href="/<?php echo h($key); ?>" data="<?php echo h($lang['lang']); ?>"><?php echo h($lang['name']); ?><?php if(Configure::read('Config.language') == $lang['lang']) : ;?>&nbsp;&nbsp;<i class="fa fa-check"></i><?php endif;?></a></li>
                            <?php endforeach; ?> 
                            </ul>
                        </div>
                    </li>
                    <li>
                        <?php echo $this->Html->link(__d('accounts', 'Регистрация') .' <i class="small fa fa-user"></i>', array('controller' => 'accounts', 'action' => 'register'), array('escape' => false)); ?>
                    </li>
                    <li>
                        <?php echo $this->Html->link(__d('accounts', 'Войти') .' <i class="small fa fa-key"></i>', array('controller' => 'accounts', 'action' => 'login'), array('escape' => false)); ?>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <?php echo $this->fetch('content'); ?>

    <?php
    if(Configure::read('Config.language') =='eng'){
        echo $this->element('start/footer_eng');
    }else{
        echo $this->element('start/footer_rus');    
    }
    ?>
    <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left">
        <span class="glyphicon glyphicon-chevron-up"></span>
    </a>

<?php

echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
echo $this->Html->script('start/bootstrap.min');
echo $this->fetch('toFooter');
//echo $this->element('js_lang', array(), array('cache' => array('key' => 'js_lang', 'config' => 'elements')));
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
