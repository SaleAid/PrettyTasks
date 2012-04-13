
function getTaskForEdit(id){
    return getTaskFromPage(id);
}

function getTaskFromPage(id){
    var data = {
        title: $('#'+id).children('.editable').text(),
        done:  $('#'+id).children('.done').is(":checked"),   
    }
    return data;
}

function mesg (text){
    $.jGrowl.defaults.pool = 2;
    $.jGrowl(text, { 
                    glue: 'before',
                    position: 'custom',
                    theme: 'green_theme',
                    speed: 'slow',
                    life: '1000',
					animateOpen: { 
						height: "show"
					},
					animateClose: { 
						height: "hide"
					},
                    
				});
}

function checkLogin(){
    $.ajax({
        type: "POST",
        url: "/users/checkLogin",
        success: function (status) {
                if(!status){
                   redirect();
                }
        },
        error: function (xhr, ajaxOptions, thrownError) {
                if(xhr.status != '200'){
                    redirect();
                }
       }
    });
}
var dropped = false;
function redirect(){
    window.location.href = "/";
}

$(document).ready(function()  {

//-------------------------------- work tesk

         $.datepicker.setDefaults(
            $.extend($.datepicker.regional["ru"])
         );

        
        setInterval(function() {
            checkLogin();
        }, 120000);
        
                 
         $(".createTask").bind('keypress', function(e) {
            var ul = $(this).siblings("ul");
            var tabDay = $(this).siblings(".tabDay").text();
            var code = (e.keyCode ? e.keyCode : e.which);
            if(code == 13) {
                $.ajax({
                    url:'/tasks/addNewTask',
                    type:'POST',
                    data: {title: $(this).val(), date: tabDay },
                    success: function(data) {
                        if(data){
                            mesg('Задача успешно создана.');
                            ul.append(data);  
                        }
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
                $.ajax({
                    url:'/tasks/addFutureTask',
                    type:'POST',
                    data: { title: $(this).val()},
                    success: function(data) {
                      if(data){
                        mesg('Задача успешно создана.');
                        ul.append(data);  
                      }
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
                $.ajax({
                        url:'/tasks/setTitle',
                        type:'POST',
                        data: {title: value, id: task_id },
                        success: function(data) {
                            data = $.parseJSON(data);
                            if (data !== false){
                               mesg('Задача  успешно изменена.');
                               if(data.Task.priority){
                                    $(editable).addClass('important');
                               }else{
                                    $(editable).removeClass('important');
                               }
                            }else{
                                mesg('Задача  не изменена.');
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
        
     $("ul").delegate(".deleteTask", "hover", function(e){   
        $('.deleteTask').attr('title','Click to delete').tooltip();
     });
        
    $("ul").delegate(".deleteTask", "click", function(e){
        $("ul").undelegate(".deleteTask", "click");
        $(".deleteTask").inlineConfirmation({
              reverse: true,
              confirm: "<a href='#'><i class='icon-ok-sign'></i></a>",
              cancel: "<a href='#'><i class='icon-remove-sign '></i></a>",
              separator: "  ",
              expiresIn: 3,
              bindsOnEvent: "click",
              confirmCallback: function(el) {
                     $.ajax({
                            url:'/tasks/deleteTask',
                            type:'POST',
                            data: { id: el.parent().attr('id'),},
                            success: function(data) {
                                if (data){
                                        el.parent().remove();
                                        mesg('Задача успешно удалена.');    
                                    }else{
                                       mesg('Ошибка при удалении .');
                                 }
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                if(xhr.status != '200'){
                                    redirect();
                                }
                            }
                    }); 
              },
              cancelCallback: function(el) {
                 mesg('Отмена удаления .');
              },
        });
    });
    
    //drag &drop
    
            var $tabs = $( "#main" ).tab();
            var $tab_items = $( "ul:first li", $tabs ).droppable({
                         tolerance:'pointer', 
                         accept: ".connectedSortable li",
                         hoverClass: "ui-state-hover", 
                         drop: function( event, ui ) { 
                            dropped = true;
                            var $item = $(this);
                            var $list = $( $item.find( "a" ).attr( "href" ) ).find( "ul:first" );
                            ui.draggable.hide( "slow", function() {
                                    $(this).css("color","");
                                    if($list.children().length){
                                        $(this).prependTo($list).show( "slow" );    
                                    }else{
                                        $(this).appendTo($list).show('slow');
                                    }
                                $.ajax({
                                        url:'/tasks/dragOnDay',
                                        type:'POST',
                                        data: { id: $(this).attr('id'),
                                                date: $(this).parent().attr('date')
                                              },
                                        success: function(data) {
                                            if (data){
                                                    mesg('Задача успешно перемещена (moveTo).');    
                                                }else{
                                                   mesg('Ошибка при перемещении (moveTo).');
                                             }
                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                            if(xhr.status != '200'){
                                               // redirect();
                                            }
                                        }
                                }); 
                            });
                           }
                          });
                          
    $( ".sortable" ).sortable({
			cancel: ".ui-state-disabled",
            opacity: 0.9, 
            cursor: 'move', 
            placeholder: "ui-state-highlight",
            handle: 'span .icon-move',
            //containment: '.row',
            change: function(event, ui) {
                ui.helper.css("color","#f00");
            },
            start: function(event, ui) {
                $(ui.item).data("startindex", ui.item.index());
            },
            update : function(e,ui){
                ui.item.css("color","");
                if(dropped){
                    dropped = false;
                    return true;
                }
                $.ajax({
                        url:'/tasks/changeOrders',
                        type:'POST',
                        data: {  id: ui.item.attr('id'),
                                 new_pos: ui.item.index()+1,
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
        }).disableSelection();
        
        $("ul").delegate(".editTask", "click", function(){
            var task = getTaskForEdit($(this).parent().attr('id'));
            console.log(task);
            $('#editTask').find('#eTitle').val(task.title);
            if(task.done){
                $('#editTask').find('#eDone').attr('checked','checked');
            }else {
                $('#editTask').find('#eDone').removeAttr('checked');
            }
            $( "#eDate" ).datepicker({ 
                    dateFormat: 'yy-mm-dd',
                    showAnim: 'clip',
            });
		    $('#eTime').timepicker({
                    timeFormat: 'HH:mm',
                    minHour: null,
                    minMinutes: null,
                    minTime: null,
                    maxHour: null,
                    maxMinutes: null,
                    maxTime: null,
                    startHour: 7,
                    startMinutes: 0,
                    startTime: null,
                    interval: 15,
                    change: function(time) {}
        });
            $('#editTask').modal('show');
        });

                           
}); 	
  

  //end 
