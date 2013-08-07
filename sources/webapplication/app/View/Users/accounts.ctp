
<div class="well">
        <legend><?php echo __d('users', 'Связанные учетные записи');?>
               <div class="box-loginza-registr-top pull-right">
                <span><?php echo __d('users', 'Прикрепите аккаунт из социальной сети'); ?></span>
                    <div class="box-icons-widget">
                        <?php
                            echo $this->Html->link(
                                     $this->Loginza->ico('google'),
                                     array(
                                         'controller' => 'accounts',
                                         'action' => 'link',
                                         'google'
                                     ),
                                     array('escape' => false)
                                 );
                        ?>
                        <?php
                            echo $this->Html->link(
                                     $this->Loginza->ico('facebook'),
                                     array(
                                         'controller' => 'accounts',
                                         'action' => 'link',
                                         'facebook'
                                     ),
                                     array('escape' => false)
                                 );
                        ?>
                        <?php
                            echo $this->Html->link(
                                     $this->Loginza->ico('linkedin'),
                                     array(
                                         'controller' => 'accounts',
                                         'action' => 'link',
                                         'linkedin'
                                     ),
                                     array('escape' => false)
                                 );
                        ?>
                        <?php
                            echo $this->Html->link(
                                     $this->Loginza->ico('twitter'),
                                     array(
                                         'controller' => 'accounts',
                                         'action' => 'link',
                                         'twitter'
                                     ),
                                     array('escape' => false)
                                 );
                        ?>
                        <?php
                            echo $this->Html->link(
                                     $this->Loginza->ico('vkontakte'),
                                     array(
                                         'controller' => 'accounts',
                                         'action' => 'link',
                                         'vkontakte'
                                     ),
                                     array('escape' => false)
                                 );
                        ?>
                    </div>
               </div>
        </legend>
        <?php if (!empty($accounts)) :?>    
            <table class="table table-striped">
                <tr>
                    <th><?php echo __d('users', 'Провайдер');?></th>
                    <th><?php echo __d('users', 'Имя');?></th>
                    <th><?php echo __d('users', 'Дата связывания');?></th>
                    
                    <th class="actions"><?php echo __d('users', 'Действия');?></th>
                </tr>
                <?php foreach ($accounts as $item): ?>
                   <tr <?php if ($item['Account']['master']): ?> class="info" <?php endif; ?>>   
                        <td><?php echo $this->Loginza->logo($item['Account']['provider']); ?>&nbsp;</td>
                        <td><?php echo h($item['Account']['full_name']); ?>&nbsp;</td>
                        <td><?php echo $this->Time->niceShort($item['Account']['created'], $timezone); ?>&nbsp;</td>
                         
                            <td class="actions">
                                <?php if (!$item['Account']['master']): ?>
                                    <?php echo $this->Form->postLink(__d('users', 'Удалить'), array('controller' => 'accounts', 'action' => 'delete', $item['Account']['id']), array('class' => 'btn btn-mini'), __d('users', 'Вы уверены, что хотите удалить этот аккаунт?')); ?>
                                <?php else: ?>
                                    <?php //echo $this->Form->postLink(__d('users', 'Удалить'), array('controller' => 'accounts', 'action' => 'delete', $item['Account']['id']), array('class' => 'btn btn-mini disabled'), __d('users', 'Вы уверены, что хотите удалить этот аккаунт?')); ?>
                                <?php endif; ?>
                            </td>
                   </tr>
                <?php endforeach; ?>
            </table>
        <?php else :?>
            <?php echo $this->element('empty_lists', array('type' => 'password_change', 'hide' => false));?>
        <?php endif;?>
 </div>