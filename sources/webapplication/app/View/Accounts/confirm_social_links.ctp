<?php echo $this->Html->script('confirm_social_links.' . Configure::read('App.version'), array('block' => 'toFooter')); ?>
<div class="login">
<?php echo $this->Session->flash(); ?>
   <fieldset>
        <legend><?php echo __d('accounts', 'Связать аккаунты');?></legend>
        <table class="table table-striped socia-table" >
        <?php foreach($newAccounts as $key => $account):?>
            <tr id="<?php echo $key; ?>">
                <td style="width: 90px;">
                    <?php echo $this->Loginza->logo($account['provider']); ?>
                </td>
                <td>
                    <?php echo $account['full_name'];?> 
                </td>
                <td style="text-align: right;">
                    <div class="control-btns">
                        <button class="btn btn-success allow" type="button"><?php echo __d('accounts', 'Разрешить'); ?></button>
                        <button class="btn btn-danger deny" type="button"><?php echo __d('accounts', 'Запретить'); ?></button>
                    </div>
                </td>
           </tr> 
        <?php endforeach; ?>
        </table>
        <legend></legend>
        <?php echo $this->Form->create(false); ?>
        <?php echo $this->Form->submit(__d('accounts','Разрешить всех'), array('div' => false, 'name' => 'allowAll', 'class' => 'btn btn-success deny-all' )); ?>
        <?php echo $this->Form->submit(__d('accounts','Запретить всех'), array('div' => false, 'name' => 'denyAll', 'class' => 'btn btn-danger deny-all')); ?>
        <?php echo $this->Form->submit(__d('accounts','Пропустить'), array('div' => false, 'name' => 'denyAll', 'class' => 'btn btn-info skip pull-right' )); ?>

        <?php echo $this->Form->end(); ?>
    </fieldset>
</div>
