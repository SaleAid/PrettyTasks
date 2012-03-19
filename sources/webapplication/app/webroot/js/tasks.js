
$(function() {
		$( "#sortable1" ).sortable({
			items: "li:not(.ui-state-disabled)"
		});

		$( "#sortable2" ).sortable({
			cancel: ".ui-state-disabled",
            receive: function(){ 
                $(this).children().children('input.ch').val('ABC');
            },
            opacity: 0.9, 
            cursor: 'move', 
		  });
          $('#sortable2').sortable({handle: 'span'}).disableSelection();
        
        

		$( "#sortable1 li, #sortable2 li" ).disableSelection();	
        
          $("#test-list").sortable({ 
    handle : '.handle', 
    update : function () { 
      $("input#test-log").val($('#test-list').sortable('serialize')); 
    } 
  }); 	
	});