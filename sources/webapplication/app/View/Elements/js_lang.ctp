<script type="text/javascript">
    <?php 
        $routerArr = Router::parse($this->request->url);
        $named= $routerArr['named'];
        $pass= $routerArr['pass'];
        unset( $routerArr['named']);
        unset( $routerArr['pass']);
        $routerArr = array_merge($pass, $named, $routerArr);
    ?>
    var langUrls = {
        <?php foreach ( Configure::read('Config.lang.available') as $key => $value ) : ?>
        <?php echo h($value['lang']); ?>: '<?php echo $this->Html->url(array_merge($routerArr, array('lang' => $key)));?>', 
        <?php endforeach; ?>
    };
    
</script>