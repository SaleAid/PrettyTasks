<div id="box">
    <div id="invite">
        <?php echo $this->Html->image("invite.". Configure::read('App.version') .".png", array("alt" => "Invite friends", 'width' => 30, 'height' => 84, 'url' => array('controller' => 'invitations', 'action' => 'add'))); ?>
    </div>
    <div id="feedback">
        <?php echo $this->Html->image("feedback.". Configure::read('App.version') .".png", array("alt" => "Feedback", 'width' => 30, 'height' => 84, 'url' => array('controller' => 'feedbacks', 'action' => 'add'))); ?>
    </div>
</div>
