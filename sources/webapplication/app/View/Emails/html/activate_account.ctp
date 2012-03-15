<body>
    Здравствуйте, <?php echo $fullname; ?>! <br />

    Ваш код активации на сайте: 
    
    <?php echo Router::url(array('controller' => 'users', 'action' => 'activate', $activate_token), true); ?>
    
    
</body>
