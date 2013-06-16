$(function(){
    $(".control-btns button").on("click", function() {
        var $that = $(this);
        var action = 0;
        var uid = $(this).parent().parent().parent().attr('id');
        if ($(this).hasClass('allow')){
            action = 1;
        } 
        $.ajax({
          url: window.location.pathname + '.json',
          type: "POST",
          data: { id: uid, action: action},
          beforeSend: function ( xhr ) {
        
          }
        }).done(function ( data ) {
          if( data.status ) {
        	  $that.parent().empty().html('<span class="label label-success pull-right">'+ data.message +'</span>');
              if(data.status == 2){
                window.setTimeout('location.reload()', 3000);  
              }
          }
          else {
            //error
          }
        });    
    });

});