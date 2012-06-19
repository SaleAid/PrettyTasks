<?php if(!empty($currentUser)):  ?>    
    
    <?php //echo $this->Html->link(__('Invite friends'), array('controller' => 'invitations', 'action' => 'add'),array('class'=> 'btn btn-danger')); ?>

<div id="box">
    <div id="feedback">
        <?php echo $this->Html->image("feedback.". Configure::read('App.version') .".png", array(    "alt" => "Feedback",    'url' => array('controller' => 'feedbacks', 'action' => 'add'))); ?>
    </div>
    <div id="invite">
        <?php echo $this->Html->image("invite.". Configure::read('App.version') .".png", array(    "alt" => "Invite friends",    'url' => array('controller' => 'invitations', 'action' => 'add'))); ?>
    </div>
</div>
<?php endif; ?>