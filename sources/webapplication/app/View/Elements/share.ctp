<?php 
    $text =  urlencode(Configure::read('Site.description'));
    $url = urlencode(Configure::read('Site.url'));
?>
<ul class="share-entry">
    <li><a class="share share-twitter" title="<?php echo __d('pages', 'Поделиться в Twitter'); ?>" href="http://twitter.com/share?text=<?php echo $text; ?>&url=<?php echo $url; ?>"><?php echo __d('pages', 'Поделиться в'); ?> <?php echo $this->Loginza->ico('twitter'); ?>&nbsp;<?php echo __d('pages', 'Twitter'); ?> </a></li>
	<li><a class="share share-facebook" title="<?php echo __d('pages', 'Поделиться в Facebook'); ?>"  href="http://www.facebook.com/share.php?u=<?php echo $url; ?>&t=<?php echo $text; ?>"><?php echo __d('pages', 'Поделиться в'); ?> <?php echo $this->Loginza->ico('facebook'); ?>&nbsp;<?php echo __d('pages', 'Facebook'); ?> </a></li>
	<li><a class="share share-vk" title="<?php echo __d('pages', 'Поделиться в ВКонтакте'); ?>"  href="http://vk.com/share.php?url=<?php echo $url; ?>&title=<?php echo $text; ?>"><?php echo __d('pages', 'Поделиться в'); ?> <?php echo $this->Loginza->ico('vkontakte'); ?>&nbsp;<?php echo __d('pages', 'ВКонтакте'); ?> </a></li>
	<li><a class="share share-googleplus" title="<?php echo __d('pages', 'Поделиться в Google+'); ?>"  href="https://plus.google.com/share?url=<?php echo $url; ?>"><?php echo __d('pages', 'Поделиться в'); ?> <?php echo $this->Loginza->ico('google'); ?>&nbsp;<?php echo __d('pages', 'Google+'); ?> </a></li>
</ul>