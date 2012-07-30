<?php $this->start ( 'toFooter' );?>
    <?php echo $this->Html->script($this->Loginza->getJs()); ?>
<?php $this->end ();?>

<div class="well">
        <legend><?php echo __('Связанные учетные записи');?>
               <div class="box-loginza-registr-top pull-right">
                <span>Прикрепите аккаунт из социальной сети</span>
                    <div class="box-icons-widget">
                        <?php echo $this->Loginza->iconsWidget(Configure::read('loginza.token_url'),'google')?>
                        <?php echo $this->Loginza->iconsWidget(Configure::read('loginza.token_url'),'facebook')?>
                        <?php echo $this->Loginza->iconsWidget(Configure::read('loginza.token_url'),'twitter')?>
                        <?php echo $this->Loginza->iconsWidget(Configure::read('loginza.token_url'),'vkontakte')?>
                    </div>
               </div>
        </legend>
        <?php if (!empty($accounts)) :?>    
            <table class="table table-striped" >
                <tr>
                    <th><?php echo __('Провайдер');?></th>
                    <th><?php echo __('Имя');?></th>
                    <th><?php echo __('Дата связывания');?></th>
                    
                    <th class="actions"><?php echo __('Действия');?></th>
                </tr>
                <?php foreach ($accounts as $item): ?>
                   <tr>   
                        <td><?php echo $this->Loginza->logo($item['Account']['provider']); ?>&nbsp;</td>
                        <td><?php echo h($item['Account']['full_name']); ?>&nbsp;</td>
                        <td><?php echo h($item['Account']['created']); ?>&nbsp;</td>
                        <td class="actions"><?php echo $this->Form->postLink(__('Удалить'), array('controller' => 'Accounts', 'action' => 'delete', $item['Account']['id']), null, __('Вы уверены, что хотите удалить этот аккаунт?')); ?></td>
                   </tr>
                <?php endforeach; ?>
            </table>
        <?php else :?>
            <div class ="alert alert-info emptyList">
                <strong>О-о-о!*</strong> <?php echo __('TEXT TEXT');?>
            </div>  
        <?php endif;?>
 </div>