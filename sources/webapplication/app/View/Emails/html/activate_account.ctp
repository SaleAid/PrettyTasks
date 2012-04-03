<body>
    Здравствуйте, <?php echo $full_name; ?>! <br />

    Ваш код активации на сайте: 
    
    <?php echo Router::url(array('controller' => strtolower($controllerName), 'action' => 'activate', $activate_token), true); ?>
    
    
</body>
