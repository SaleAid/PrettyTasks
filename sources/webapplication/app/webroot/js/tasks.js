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

function mesg (text){
    $.jGrowl(text, { 
					//position : 'right',
                    speed: 'slow',
                    life: '1000',
					animateOpen: { 
						height: "show"
					},
					animateClose: { 
						height: "hide"
					}
				});
}

function checkLogin(){
    $.ajax({

        type: "POST",
        url: "/users/checkLogin",
        success: function (status) {
            console.log(status);
            if(!status){
               redirect();
            }
          
        },
        error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                if(xhr.status != '200'){
                    redirect();
                }
       }
        
    });
}

function redirect(){
    window.location.href = "/";
}

$(document).ready(function()  {

//-------------------------------- work tesk

        
        setInterval(function() {
            checkLogin();
        }, 120000);
        
         $(".createTask").bind('keypress', function(e) {
            var ul = $(this).siblings("ul");
            var tabDay = $(this).siblings(".tabDay").text();
            var code = (e.keyCode ? e.keyCode : e.which);
            if(code == 13) {
                console.log($(this).val());
                $.ajax({
                    url:'/tasks/addNewTask',
                    type:'POST',
                    data: {title: $(this).val(), date: tabDay },
                    success: function(data) {
                        mesg('Задача успешно создана.');
                      ul.append(data);
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
        
        $("#future input").bind('keypress', function(e) {
            var ul = $(this).siblings("ul");
            var code = (e.keyCode ? e.keyCode : e.which);
            if(code == 13) {
                console.log($(this).val());
                $.ajax({
                    url:'/tasks/addFutureTask',
                    type:'POST',
                    data: { title: $(this).val()},
                    success: function(data) {
                        mesg('Задача успешно создана.');
                      ul.append(data);
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
                            if (data){
                               mesg('Задача  успешно изменена.');
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            if(xhr.status != '200'){
                                redirect();
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
            connectWith:".conWith",
            handle: 'span .icon-move',
            containment: '.row',
            revert : true,
            change: function(event, ui) {
                ui.helper.css("color","#f00");
            },
            start:function(event, ui) {
                $(ui.item).data("startindex", ui.item.index());
            },
            update : function(e,ui){
                ui.item.css("color","");
                $.ajax({
                        url:'/tasks/changeOrders',
                        type:'POST',
                        data: {  new_order: $(this).sortable('toArray'),
                                 id: ui.item.attr('id'),
                                 old_pos: ui.item.data("startindex"),
                                 new_pos: ui.item.index(),
                              },
                        success: function(data) {
                            if (data){
                                 mesg('Задача успешно перенесена.');
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            if(xhr.status != '200'){
                                redirect();
                            }
                        }

                });
            }
        });
        
        $("ul").delegate(".done", "click", function(){
                var status = $(this).is(":checked");
                var editable = $(this).siblings(".editable");
                $.ajax({
                        url:'/tasks/setDone',
                        type:'POST',
                        data: {  id: $(this).parent().attr('id'),
                                 checked: status ? '1': '0',
                              },
                        success: function(data) {
                            if (data){
                                if(status){
                                    editable.addClass('complete');
                                    mesg('Задача успешно выполнена.');    
                                }else{
                                    editable.removeClass('complete');
                                    mesg('Задача открыта.');
                                }
                                
                                 
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            if(xhr.status != '200'){
                                redirect();
                            }
                        }
                }); 
        });
        
        //$("ul").delegate(".deleteTask", "click", function(){
//                var li = $(this).parent('li');
//                if (confirm('Are you sure to hide')) {
//                    $("#tmm1").hide("slow");
//                }
//                $.ajax({
//                        url:'/tasks/deleteTask',
//                        type:'POST',
//                        data: {  id: $(this).parent().attr('id'),
//                                order: $(this).parent("li").parent(".sortable").sortable('toArray')
//                              },
//                        success: function(data) {
//                            if (data){
//                                    li.remove();
//                                    mesg('Задача успешно удалена.');    
//                                }else{
//                                   mesg('Ошибка при удалении .');
//                             }
//                        },
//                        error: function (xhr, ajaxOptions, thrownError) {
//                            if(xhr.status != '200'){
//                                redirect();
//                            }
//                        }
//                }); 
//        });
        
       
    $(".deleteTask").live('click',function() {
      var $dialog = $('<div>Are you sure you wish to delete this record?</div>').dialog({
            buttons: [
                  {
                        text: "Ok",
                        click: function(){
                              // delete the record
                              $.post('deleteHandler.php?id=1');
                              $dialog.remove();
                        }
                  },
                  {
                        text: "Cancel",
                        click: function(){
                              $dialog.remove();
                        }
                  }
            ]
      });
});
 

        
				
        


		
        
  }); 	
  

  //end 
