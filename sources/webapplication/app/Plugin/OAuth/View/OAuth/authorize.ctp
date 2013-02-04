
<script type="text/javascript">
	if (top =! self) {
		window.document.write("<div style='background:black; opacity:0.5; filter: alpha (opacity = 50); position: absolute; top:0px; left: 0px;"
		+ "width: 9999px; height: 9999px; zindex: 1000001' onClick='top.location.href=window.location.href'></div>");
	}
</script>

<div class="span6 offset3">
<?php
	echo $this->Form->create('Authorize');

	foreach ($OAuthParams as $key => $value) {
		echo $this->Form->hidden(h($key), array('value' => h($value)));
	}
?>
<p class="lead">Do you authorize the app to do its thing?</p>

<div class="span3 offset1">
	<?php
		echo $this->Form->submit('Deny', array('name' => 'accept', 'class' => 'btn', 'div' => false));
		echo '&nbsp;';
		echo $this->Form->submit('Allow', array('name' => 'accept', 'class' => 'btn btn-primary', 'div' => false));
		echo $this->Form->end();
	?>
</div>
</div>