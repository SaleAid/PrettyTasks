
function getTaskForEdit(id){
    return getTaskFromPage(id);
}

function getTaskFromPage(id){
    var data = {
        title:   $('#'+id).children('.editable').text(),
        done:    $('#'+id).children('.done').is(":checked"),
        date:    $('#'+id).parent().attr('date'),
        time:    $('#'+id).children('.time').text(),
        comment: 'comment',   
    }
    return data;
}

function mesg (message){
    $.jGrowl.defaults.pool = 2;
    $.jGrowl(message.message, { 
                    glue: 'before',
                    position: 'custom',
                    theme: message.type,
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

function superAjax(url, data){
     var result = null;
     $.ajax({
            url:url,
            type:'POST',
            async: false,
            data: data,
            success: function(data) {
                result = data;
            },
            error: function (xhr, ajaxOptions, thrownError) {
                if(xhr.status != '200'){
                    redirect();
                }
            }
     });
     return result;
}
function AddTask(data){
    task = $('<li></li>').addClass('ui-state-default').attr('id',data.Task.id)
        .append($('<span></span>').append($('<i></i>').addClass('icon-move')))
        .append($('<span></span>').addClass('time').append($('<i></i>').addClass('icon-time')))
        .append($('<input></input>').addClass('done').attr('type','checkbox'))
        .append($('<span></span>').addClass('editable input-xxlarge').text(data.Task.title))
        .append($('<span></span>').addClass('editTask').append($('<i></i>').addClass('icon-pencil')))
        .append($('<span></span>').addClass('deleteTask').append($('<i></i>').addClass('icon-ban-circle')))
        ;	
    return task;
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
            var ul = $(this).parent().siblings("ul");
            var day = $(this).parent().siblings("ul").attr('date');
            var code = (e.keyCode ? e.keyCode : e.which);
            if(code == 13) {
                var data = superAjax('/tasks/addNewTask.json',{title: $(this).val(), date: day });
                if (data.result.success){
                    ul.append(AddTask(data.result.data));  
                }
                mesg(data.result.message);
                $(this).val(null);
            }
        });
        
        $("#future input").bind('keypress', function(e) {
            var ul = $(this).parent().siblings("ul");
            var code = (e.keyCode ? e.keyCode : e.which);
            if(code == 13) {
                var data = superAjax('/tasks/addNewTask.json',{title: $(this).val()});
                if (data.result.success){
                    ul.append(AddTask(data.result.data));  
                }
                mesg(data.result.message);
            $(this).val(null);
            }
        });
        
        $("ul").delegate(".editable", "click", function(){
             $(".editable").editable(function(value, settings) { 
                    var editable = this;
                    var task_id = $(editable).parent().attr('id');
                    var data = superAjax('/tasks/setTitle.json',{title: value, id: task_id });
                    if (data.result.success){
                       if(data.result.data.Task.priority){
                            $(editable).addClass('important');
                       }else{
                            $(editable).removeClass('important');
                       }
                       result = value
                    }else{
                        result = data.result.data.Task.title;
                    }
                    mesg(data.result.message);
                    return result;    
             }
             ,{
                cssclass : 'inlineform',
                width: 520,
                height: 20,
                indicator : "<img src='img/indicator.gif'>",
                placeholder : "",
                tooltip : "Щелкните чтоб отредактировать этот текст",
                style  : "inherit"
            });
        });
        
       $("ul").delegate(".done", "click", function(){
                var status = $(this).is(":checked");
                var editable = $(this).siblings(".editable");
                var data = superAjax('/tasks/setDone.json',{id: $(this).parent().attr('id'), checked: status ? '1': '0' });
                if (data.result.success){
                    if(data.result.data.Task.done == 1){
                        editable.addClass('complete');
                    }else{
                        editable.removeClass('complete');
                    }
                    mesg(data.result.message);
                }
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
                 var data = superAjax('/tasks/deleteTask.json',{id: el.parent().attr('id')});
                 if (data.result.success){
                        el.parent().remove();
                 }
                 mesg(data.result.message);
              },
              cancelCallback: function(el) {
                 //mesg('Отмена удаления .');
              },
        });
    });
    
    //drag &drop
    
            var $tabs = $( "#main" ).tab();
            var $tab_items = $( "ul:first li", $tabs ).droppable({
                         tolerance:'pointer', 
                         accept: ".connectedSortable li",
                         hoverClass: "hover", 
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
                                    var data = superAjax('/tasks/dragOnDay.json',{id: $(this).attr('id'),date: $(this).parent().attr('date')});
                                    if (data.result.success){
                                        mesg(data.result.message);
                                    } 
                            });
                         } 
                });
                                                     
    $( ".sortable" ).sortable({
			cancel: ".ui-state-disabled",
            opacity: 0.9, 
            cursor: 'move', 
            placeholder: ".ui-state-highlight",
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
                var data = superAjax('/tasks/changeOrders.json',{id: ui.item.attr('id'), new_pos: ui.item.index()+1});
                if (data.result.success){
                    mesg(data.result.message);
                }
            }
        }).disableSelection();
        
        $("ul").delegate(".editTask", "click", function(){
            var task = getTaskForEdit($(this).parent().attr('id'));
            $('#editTask').find('#eTitle').val(task.title);
            if(task.done){
                $('#editTask').find('#eDone').attr('checked','checked');
            }else {
                $('#editTask').find('#eDone').removeAttr('checked');
            }
            $( "#eDate" ).datepicker({ 
                    dateFormat: 'yy-mm-dd',
                    showAnim: 'clip',
                    minDate: 0,
            }).val(task.date);
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
        $("#eSave").click(function(){
            var $title = $('#editTask').find('#eTitle').val();
            var $done = $('#editTask').find('#eDone').is(":checked");
            var $date = $( "#eDate" ).val();
            var $time = $('#eTime').val();
            var $comment = $('#eComment').val();
            $.ajax({
                        url:'/tasks/editTask.json',
                        type:'POST',
                        data: { title: $('#editTask').find('#eTitle').val(),
                                done: $('#editTask').find('#eDone').is(":checked"),
                                date: $( "#eDate" ).val(),
                                time: $('#eTime').val(),
                                comment: $('#eComment').val(),
                              },
                        success: function(data) {
                            if (data.result.success){
                                 mesg('Задача успешно отредактирована.');
                                 $('#editTask').modal('hide');
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            if(xhr.status != '200'){
                                redirect();
                            }
                        }
                });
            
            
        });

                           
}); 	
  

  //end 
