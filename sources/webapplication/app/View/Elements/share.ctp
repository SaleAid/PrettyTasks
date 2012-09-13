<?php 
    $text =  urlencode(Configure::read('Site.description'));
    $url = urlencode(Configure::read('Site.url'));
?>
<ul class="share-entry">
    <li><a class="share share-twitter" title="Share on Twitter" href="http://twitter.com/share?text=<?php echo $text; ?>&url=<?php echo $url; ?>">Share on Twitter</a></li>
	<li><a class="share share-facebook" title="Share on Facebook"  href="http://www.facebook.com/share.php?u=<?php echo $url; ?>&t=<?php echo $text; ?>">Share on Facebook</a></li>
	<li><a class="share share-vk" title="Share on VK"  href="http://vk.com/share.php?url=<?php echo $url; ?>&title=<?php echo $text; ?>">Share on VK</a></li>
	<li><a class="share share-googleplus" title="Share on Google+"  href="https://plus.google.com/share?url=<?php echo $url; ?>">Share on Google+</a></li>
</ul>'

