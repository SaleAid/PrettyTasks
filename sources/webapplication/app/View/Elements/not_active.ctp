<?php
if (!isset($class)) {
	$class = false;
}
if (!isset($close)) {
	$close = true;
}
?>
<div class="alert fade in<?php echo ($class) ? ' ' . $class : null; ?>">
<?php if ($close): ?>
	<a class="close" data-dismiss="alert" href="#">&times;</a>
<?php endif; ?>
	<h2><?php echo __d('users', 'Осталось подтвердить регистрацию!'); ?></h2> 
    <p>
        <?php echo __d('users', 'При создании аккаунта на ваш e-mail было отправлено письмо с подтверждением, пожалуйста, перейдите по ссылке, указанной в данном письме.'); ?>
    </p> 
     <?php echo $this->Form->postLink(__d('users', ' Заказать повторное письмо с подтверждением '),
                                         array('controller' => 'users', 'action' => 'reactivate'),
                                         array('class' => 'btn btn-info', 
                                                'data' => array('email' => $email))); ?>
    
    <?php echo $message; ?>
</div>