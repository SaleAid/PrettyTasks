function loadtab(e){
    var nowtab = e.target // activated tab
    var divid = $(nowtab).attr('href').substr(1);
    var date = $(nowtab).attr('name');
    console.log(nowtab);
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
    
        
         
        
        $('a[data-toggle="tab"]').on('shown', function (e) {
             loadtab(e);
        });
        
       //$('#Today').load('/tasks/getAllForDate',{ strDate: '#Today', date:null },function(data){
//            
//            $("#Today div.list").empty();
//            var items = [];
//            $.each(data, function(key, val) {
//                console.log(val);
//            items.push('<li  class="ui-state-default" id="' + val.Task.id + '"><div class="editable">' + val.Task.title 
//            + '</div>'
//            + '<span> <i class="icon-move"> </i></span>'
//            + '<span> <i class="icon-refresh divider"> </i></span>'
//            + '<a href="#"> <i class="icon-remove"> </i></a>'
//            +'</li>');
//            });
//            $('<ul/>', {
//            'class': 'sortable connectedSortable ui-helper-reset',
//            html: items.join('')
//            }).appendTo("#Today div.list");
//            
//            //sortable 
//            
//            $( ".sortable" ).sortable({
//    			cancel: ".ui-state-disabled",
//                opacity: 0.9, 
//                cursor: 'move', 
//                placeholder: "ui-state-highlight",
//                connectWith:".connectedSortable",
//                handle: 'span',
//           });
//           
//            $(".editable").editable("/tasks/editTitle",
//            {
//                tooltip : "Щелкните чтоб отредактировать этот текст",
//                style  : "inherit"
//           });
//       });
//
          
          //$('.sortable').sortable({handle: 'span'}).disableSelection();
          $('.sortable').on('sortable',function(){
                $('.sortable').sortable({handle: 'span'}).disableSelection();
                
          });

            $( "#datepicker" ).datepicker();
        	$( "#datepicker" ).datepicker( "option", "showAnim", "bounce" );
            
        $(".newTask").editable("/tasks/addNewTask",
               {
                       id:'data[id]',
                       name:'data[title]',
                       tooltip : "добавить задание",
                       style  : "inherit",
                       placeholder: "+добавить задание",
                       callback : function(value, settings) {
                            $('#Today ul').append(value);
                            console.log(value);
                            console.log(settings);
                            $(".newTask").text('');
                            
                         }
               }
        );

		
        
  }); 	
  

  
     $(document).keypress(function(event){
    	var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
		  	$(".newTask:text").focus();
            	
}
 
    });
