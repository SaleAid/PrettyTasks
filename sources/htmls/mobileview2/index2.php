<!DOCTYPE html>
<html>
	<head> 
	<title>My Page</title> 
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.css" />
<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.js"></script>
<script>
$(document).ready(function() {
	$("input[type='checkbox']").live( "change", function(event, ui) {
          var $el = $(this);
          if ($el.attr('checked')) {
              name = $el.attr("name");
              $("label[for='"+name+"']").addClass('complete');
          } else {
              name = $el.attr("name");
              $("label[for='"+name+"']").removeClass('complete');
          }

	});
});
</script>
<style type="text/css">
        #complete label, .complete {
            text-decoration: line-through;
color: #ccc;
        }
            
            
            
            
#primary li .ui-btn-text {
	width: 36px;
	height: 36px;
	vertical-align: middle;
	text-indent: -9999px;
	overflow: hidden;
	text-align: left;
	position: relative;
	display: inline-block;
	background-image: url(icons.png );
	background-repeat: none;
	-webkit-background-size: 308px 85px;
	   -moz-background-size: 308px 85px;
	     -o-background-size: 308px 85px;
	        background-size: 308px 85px;
}

#primary li.icon-index    .ui-btn-text { background-position: -4px -47px; }
#primary li.icon-speakers .ui-btn-text { background-position: -57px -47px; }
#primary li.icon-schedule .ui-btn-text { background-position: -107px -46px; }
#primary li.icon-twitter  .ui-btn-text { background-position: -212px -46px; width: 40px }
#primary li.icon-venue    .ui-btn-text { background-position: -263px -46px; width: 40px }
</style>
</head> 
<body >

<div data-role="header" id="primary" data-id="primary">
	<div data-role="navbar">
		<ul>
						<li id="nav-index" class="icon-index"><a  href="index.php">Home</a></li>
						<li id="nav-speakers" class="icon-speakers"><a  class="ui-btn-active ui-state-persist" href="index2.php">Tomorrow</a></li>
						<li id="nav-schedule" class="icon-schedule"><a  href="schedule.php">Calendar</a></li>
						<li id="nav-venue" class="icon-venue"><a  href="venue.php">Future</a></li>
					</ul>
	</div>
</div>
<div  data-role="fieldcontain">
 	<fieldset data-role="controlgroup" id="incomplete">
		<?php 
$array = array(
"Соцсеть Facebook подала встречный иск против Yahoo!",
"В Германии кот нашелся после 16 лет скитаний по лесам",
"Land Rover презентовал \"самую роскошную версию\" внедорожника Discovery",
"Гаишники спасли водителя, который поджег себя в машине",
"Новый Lexus оснастили гибридной силовой установкой",
);
for($i=0; $i<3; $i++): ?>
		<input type="checkbox" name="checkbox-<?=$i;?>a" id="checkbox-<?=$i;?>a" class="custom"/>
		<label for="checkbox-<?=$i;?>a"><?echo $i . ' ' . $array[$i%count($array)] ?> </label>
		<?php endfor; ?>
    </fieldset>
</div>
<br/>
<br/>
<br/>



</body>
</html>



