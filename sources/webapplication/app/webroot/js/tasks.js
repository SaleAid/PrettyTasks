
$(function() {
		$( "#sortable" ).sortable({
			cancel: ".ui-state-disabled",
            opacity: 0.9, 
            cursor: 'move', 
            placeholder: "ui-state-highlight"
		  });
          $('#sortable').sortable({handle: 'span'}).disableSelection();
          $( "#resizable" ).resizable({
			handles: "se",
            containment: ".ui-state-default"
            
		});
            $( "#datepicker" ).datepicker();
        	$( "#datepicker" ).datepicker( "option", "showAnim", "bounce" );
            
         $(".editable").editable("/tasks/editTitle",
               {
                       tooltip : "Щелкните чтоб отредактировать этот текст",
                      
               }
       );
		
        
  }); 	
