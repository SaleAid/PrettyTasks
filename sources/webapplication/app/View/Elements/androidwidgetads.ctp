<?php if(!$banner_android_widget_hide): ?>
<div class ="alert alert-info banner-android-widget" style="background-color: #ffffff;">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
<?php
if(Configure::read('Config.language') =='eng'):
?>
<h4 style="display:inline;">Download our new Android widget!</h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="https://play.google.com/store/apps/details?id=com.prettytasks.prettytaskswidget" target="_blank">
<img alt="Get it on Google Play" src="https://developer.android.com/images/brand/en_generic_rgb_wo_45.png">
</a>

<?php else: ?>
<h4 style="display:inline;">Скачайте наш новый Android widget!</h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="https://play.google.com/store/apps/details?id=com.prettytasks.prettytaskswidget" target="_blank">
<img alt="Get it on Google Play" src="https://developer.android.com/images/brand/ru_generic_rgb_wo_45.png">
</a> 
<?php endif;?>
</div>
<?php endif ;?>