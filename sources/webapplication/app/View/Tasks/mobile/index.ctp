<?php
$this->start('scriptTop');
?>
<script  type="text/javascript">
$(document).ready(function() {
	$("input[type='checkbox']").live( "change", function(event, ui) {
		var $el = $(this);
		var name = $el.attr("name");
		var status = $(this).is(":checked");
		var taskId = $(this).attr('data-id');
		//console.log(taskId);
		//console.log(status);
		if ($el.attr('checked')) {
              $("label[for='"+name+"']").addClass('complete');
		} else {
              $("label[for='"+name+"']").removeClass('complete');
		}
		setDone(taskId, status);

	});
	
	//alert(111);
    $(".span3").bind('keypress', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        var Day = $(this).attr('date');
        var Container = $("#incomplete-"+Day);
        //console.log(Day);
        if(code == 13) {
            //console.log($(this).val());
            $.ajax({
                url:'/m/tasks/addNewTask/',
                type:'POST',
                data: {title: $(this).val(), date: Day },
                success: function(data) {
					Container.append(data);
					Container.trigger('create');
					
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
                        url:'/m/tasks/setDone',
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


<div data-role="page" id="today">
	
	<div data-role="header" id="primary" data-id="primary">
		<div data-role="navbar">
			<ul>
							<li id="nav-index" class="icon-index"><a class="ui-btn-active ui-state-persist" href="#today">Today</a></li>
							<li id="nav-speakers" class="icon-speakers"><a  href="#tomorrow">Tomorrow</a></li>
							<li id="nav-schedule" class="icon-schedule"><a  href="#overdue">Overdue</a></li>
							<li id="nav-venue" class="icon-venue"><a href="#overview">Overview</a></li>
						</ul>
		</div>
	</div>
	
	
	<div  data-role="fieldcontain">
		<fieldset data-role="controlgroup" id="incomplete-<?php echo $this->Time->format('Y-m-d', time(), true); ?>" >
		<input type="text" class="span3" name="newTask" id="newTask-<?php echo $this->Time->format('Y-m-d', time(), true); ?>" placeholder="Type to add new task" date="<?php echo $this->Time->format('Y-m-d', time(), true); ?>"/><br/>
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
	
	<div data-role="footer">

	</div><!-- /footer -->

</div>

<div data-role="page" id="tomorrow">
	
	<div data-role="header" id="primary" data-id="primary">
		<div data-role="navbar">
			<ul>
							<li id="nav-index" class="icon-index"><a href="#today">Today</a></li>
							<li id="nav-speakers" class="icon-speakers"><a class="ui-btn-active ui-state-persist"  href="#tomorrow">Tomorrow</a></li>
							<li id="nav-schedule" class="icon-schedule"><a href="#overdue">Overdue</a></li>
							<li id="nav-venue" class="icon-venue"><a href="#overview">Overview</a></li>
						</ul>
		</div>
	</div>
	
	
	<div  data-role="fieldcontain">
		<fieldset data-role="controlgroup" id="incomplete-<?php echo $this->Time->format('Y-m-d', '+1 days', true); ?>" >
		<input type="text" class="span3" name="newTask" id="newTask-<?php echo $this->Time->format('Y-m-d', '+1 days', true); ?>" placeholder="Type to add new task" date="<?php echo $this->Time->format('Y-m-d', '+1 days', true); ?>"/><br/>
		<?php 
			if(isset($arrTaskOnDays['Tomorrow']) && !empty($arrTaskOnDays['Tomorrow'])):
			foreach($arrTaskOnDays['Tomorrow'] as $item):
		?>
		<input type="checkbox" data-id="<?php echo $item['Task']['id']; ?>" name="checkbox-<?php echo $item['Task']['id']; ?>" id="checkbox-<?php echo $item['Task']['id']; ?>" class="custom" <?php if($item['Task']['done']):?> checked="checked" <?php endif; ?>/>
		<label for="checkbox-<?php echo $item['Task']['id']; ?>"  class="<?php if($item['Task']['done']):?>complete<?php endif; ?>"><?php echo $item['Task']['title']; ?></label>
		<?php
		endforeach;
		endif;
		?>
		</fieldset>
	</div>
	
	<div data-role="footer">

	</div><!-- /footer -->

</div>

<div data-role="page" id="overdue">
	
	<div data-role="header" id="primary" data-id="primary">
		<div data-role="navbar">
			<ul>
							<li id="nav-index" class="icon-index"><a href="#today">Today</a></li>
							<li id="nav-speakers" class="icon-speakers"><a href="#tomorrow">Tomorrow</a></li>
							<li id="nav-schedule" class="icon-schedule"><a class="ui-btn-active ui-state-persist" href="#overdue">Overdue</a></li>
							<li id="nav-venue" class="icon-venue"><a href="#overview">Overview</a></li>
						</ul>
		</div>
	</div>
	
	
	<div  data-role="fieldcontain">
		<fieldset data-role="controlgroup" id="incomplete-overdue" >
		<?php 
			if(isset($arrAllExpired) && !empty($arrAllExpired)):
			foreach($arrAllExpired as $item):

		?>
		<input type="checkbox" data-id="<?php echo $item['Task']['id']; ?>" name="checkbox-<?php echo $item['Task']['id']; ?>" id="checkbox-<?php echo $item['Task']['id']; ?>" class="custom" <?php if($item['Task']['done']):?> checked="checked" <?php endif; ?>/>
		<label for="checkbox-<?php echo $item['Task']['id']; ?>"  class="<?php if($item['Task']['done']):?>complete<?php endif; ?>"><?php echo $item['Task']['title']; ?></label>
		<?php
		endforeach;
		endif;
		?>
		</fieldset>
	</div>
	
	<div data-role="footer">

	</div><!-- /footer -->

</div>


<div data-role="page" id="overview">
	
	<div data-role="header" id="primary" data-id="primary">
		<div data-role="navbar">
			<ul>
							<li id="nav-index" class="icon-index"><a href="#today">Today</a></li>
							<li id="nav-speakers" class="icon-speakers"><a href="#tomorrow">Tomorrow</a></li>
							<li id="nav-schedule" class="icon-schedule"><a href="#overdue">Overdue</a></li>
							<li id="nav-venue" class="icon-venue"><a class="ui-btn-active ui-state-persist" href="#overview">Overview</a></li>
						</ul>
		</div>
	</div>
	
	
	<div  data-role="fieldcontain">
		<?php 
			if(isset($arrTaskOnDays) && !empty($arrTaskOnDays)):
			foreach($arrTaskOnDays as $datelabel => $day):
			if(isset($day) && !empty($day)):
		?>
		<h3><?php echo $datelabel; ?></h3>
		<fieldset data-role="controlgroup" id="incomplete-overview-<?php echo $datelabel; ?>" >
		<?
			foreach($day as $item):
		?>
		<input type="checkbox" data-id="<?php echo $item['Task']['id']; ?>" name="checkbox-<?php echo $item['Task']['id']; ?>" id="checkbox-<?php echo $item['Task']['id']; ?>" class="custom" <?php if($item['Task']['done']):?> checked="checked" <?php endif; ?>/>
		<label for="checkbox-<?php echo $item['Task']['id']; ?>"  class="<?php if($item['Task']['done']):?>complete<?php endif; ?>"><?php echo $item['Task']['title']; ?></label>
		<?php
		endforeach;
		?>
		</fieldset>
		<?php
		endif;
		endforeach;
		endif;
		?>
	</div>
	
	<div data-role="footer">

	</div><!-- /footer -->

</div>





