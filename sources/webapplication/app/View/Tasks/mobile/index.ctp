<?php
$this->start('scriptTop');
?>
<script  type="text/javascript">
$(document).ready(function() {
	$("input[type='checkbox']").live( "change", function(event, ui) {
          var $el = $(this);
          if ($el.attr('checked')) {
              name = $el.attr("name");
              $("label[for='"+name+"']").addClass('complete');
              var status = $(this).is(":checked");
              var taskId = $(this).attr('data-id');
              console.log(taskId);
              console.log(status);
              setDone(taskId, status);
          } else {
              name = $el.attr("name");
              $("label[for='"+name+"']").removeClass('complete');
              var status = $(this).is(":checked");
              var taskId = $(this).attr('data-id');
              console.log(taskId);
              console.log(status);
              setDone(taskId, status);
          }

	});
	
	//alert(111);
    $("#newTask").bind('keypress', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        var Day = $(this).attr('date');
        console.log(Day);
        if(code == 13) {
            console.log($(this).val());
            $.ajax({
                url:'/tasks/addNewTask',
                type:'POST',
                data: {title: $(this).val(), date: Day },
                success: function(data) {
                    //alert('Задача успешно создана.');
                  //ul.append(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                        if(xhr.status != '200'){
                            redirect();
                        }
                }
            });
        $(this).val(null);
        }
    });
    
       var setDone = function(taskId, status){

                $.ajax({
                        url:'/tasks/setDone',
                        type:'POST',
                        data: {  id: taskId,
                                 checked: status ? '1': '0',
                              },
                        success: function(data) {
                            if (data){
                                if(status){
                                    //editable.addClass('complete');
                                    //alert('Задача успешно выполнена.');    
                                }else{
                                    //editable.removeClass('complete');
                                    //alert('Задача открыта.');
                                }
                                
                                 
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            if(xhr.status != '200'){
                                redirect();
                            }
                        }
                })
      }
	
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
	background-image: url(/css/m/icons.png );
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
<?
$this->end();
?>
<div data-role="header" id="primary" data-id="primary">
	<div data-role="navbar">
		<ul>
						<li id="nav-index" class="icon-index"><a class="ui-btn-active ui-state-persist" href="/m/">Home</a></li>
						<li id="nav-speakers" class="icon-speakers"><a  href="index2.php">Tomorrow</a></li>
						<li id="nav-schedule" class="icon-schedule"><a  href="schedule.php">Calendar</a></li>
						<li id="nav-venue" class="icon-venue"><a  href="venue.php">Future</a></li>
					</ul>
	</div>
</div>
<div  data-role="fieldcontain">
<fieldset data-role="controlgroup" id="incomplete" >
<input type="text" class="span3" name="newTask" id="newTask" placeholder="Type to add new task" date="<?php echo $this->Time->format('Y-m-d', time(), true); ?>"/><br/>
<?php 
	if(isset($arrTaskOnDays['Today']) && !empty($arrTaskOnDays['Today'])):
	foreach($arrTaskOnDays['Today'] as $item):
?>
<input type="checkbox" data-id="<?php echo $item['Task']['id']; ?>" name="checkbox-<?php echo $item['Task']['id']; ?>" id="checkbox-<?php echo $item['Task']['id']; ?>" class="custom" <?php if($item['Task']['done']):?> checked="checked" <?php endif; ?>/>
<label for="checkbox-<?php echo $item['Task']['id']; ?>"  class="<?php if($item['Task']['done']):?>complete<?php endif; ?>"><?php echo $item['Task']['title']; ?></label>
<?php
endforeach;
endif;
?>
</fieldset>
</div>
<br/>
<br/>
<br/>






