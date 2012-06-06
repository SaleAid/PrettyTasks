<style type="text/css">
		body {color:#222; font-size:13px;font-family: sans-serif; background:#fff ;}
		h1 {font-size:300%;font-family:'Trebuchet MS', Verdana, sans-serif; color:#000}
		#page {font-size:122%;width:720px; margin:144px auto 0 auto;text-align:left;line-height:1.2;}
		#message {padding-right:400px;min-height:360px;background:transparent url(/img/404.png) right top no-repeat;}
</style>
<div id="page">
	<div id="message">
		<h1>404</h1>
        <br />
		<p>— Не то чтобы совсем не попал,— сказал Пух,— но только не попал в шарик!</p>
		<p><a href="/" title="Besttask">Начать с начала</a></p>
	</div>
</div>
<?php
if (Configure::read('debug') > 0 ):
	echo $this->element('exception_stack_trace');
endif;
?>