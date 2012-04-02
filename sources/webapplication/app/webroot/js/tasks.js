function loadtab(e){
    var nowtab = e.target // activated tab
    var divid = $(nowtab).attr('href').substr(1);
    var date = $(nowtab).attr('name');
    //console.log(nowtab);
     $.ajax({
        url:'/tasks/getAllForDate',
        type:'POST',
        dataType: 'json',
        data: { strDate: divid, date: date },
        success: function(data) {
            $("#"+divid+" div.list").empty();
            var items = [];
            $.each(data, function(key, val) {
            items.push('<li  class="ui-state-default" id="' + val.Task.id + '"><div class="editable">' + val.Task.title 
            + '</div>'
            + '<span> <i class="icon-move"> </i></span>'
            + '<span> <i class="icon-refresh divider"> </i></span>'
            + '<a href="#"> <i class="icon-remove"> </i></a>'
            +'</li>');
            });
            $('<ul/>', {
            'class': 'sortable connectedSortable ui-helper-reset',
            html: items.join('')
            }).appendTo("#"+divid+" div.list");
            
            //sortable 
            
            $( ".sortable" ).sortable({
    			cancel: ".ui-state-disabled",
                opacity: 0.9, 
                cursor: 'move', 
                placeholder: "ui-state-highlight",
                connectWith:".connectedSortable",
                handle: 'span',
           });
           
            $(".editable").editable("/tasks/editTitle",
            {
                tooltip : "Щелкните чтоб отредактировать этот текст",
                style  : "inherit"
           });
   }
   });
}

$(document).ready(function()  {
    
        
         
        
//        $('a[data-toggle="tab"]').on('shown', function (e) {
//             loadtab(e);
//        });
//        
          $('.sortable').on('sortable',function(){
                $('.sortable').sortable({handle: 'span'}).disableSelection();
                
          });

            $( "#datepicker" ).datepicker();
        	$( "#datepicker" ).datepicker( "option", "showAnim", "bounce" );
//-------------------------------- work tesk
 
        $(".createTask").editable(function(value, settings) { 
            var createTask = this;
            var tabDay = $(this).siblings(".tabDay").text();
            $.ajax({
                    url:'/tasks/addNewTask',
                    type:'POST',
                    data: {title: value, date: tabDay },
                    success: function(data) {
                        $(createTask).siblings("ul").append(data);
                        
                    }
                });
                return null;
            },    
            {
               tooltip : "добавить задание",
               style  : "inherit",
               placeholder: "+добавить задание",
           }
        );
        $("ul").delegate(".editable", "click", function(){
             $(".editable").editable(function(value, settings) { 
                var editable = this;
                var task_id = $(editable).parent().attr('id');
                console.log(task_id);
                $.ajax({
                        url:'/tasks/changeTitle',
                        type:'POST',
                        data: {title: value, id: task_id },
                        success: function(data) {
                            if (!data){
                                $(location).attr('href','/');
                            }
                        }
                    });
                    return value;
                }
             ,{
                tooltip : "Щелкните чтоб отредактировать этот текст",
                style  : "inherit"
            });
        });
        
        $( ".sortable" ).sortable({
			cancel: ".ui-state-disabled",
            opacity: 0.9, 
            cursor: 'move', 
            placeholder: "ui-state-highlight",
            connectWith:".connectedSortable",
            handle: 'span',
            containment: '.row',
            revert : true,
            change: function(event, ui) {
                
                ui.helper.css("color","#f00");
            },
            update : function(e,ui){
                var orders = $(this).sortable('toArray');
                
                console.log("After: "+orders);
                ui.item.css("color","");
                console.log('id: '+ui.item.attr('id'));
                $.ajax({
                        url:'/tasks/changeOrders',
                        type:'POST',
                        data: {orders: orders },
                        success: function(data) {
                            //$(createTask).siblings("ul").append(data);
                        }
                });
            }

        });
        


		
        
  }); 	
  

  
     $(document).keypress(function(event){
    	var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
		  	$(".newTask:text").focus();
            	
}
 
    });
