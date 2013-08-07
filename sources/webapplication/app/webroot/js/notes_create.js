///////////////////////////////////////////////////////////////////////////////////////////


/*global jQuery, underscore */
jQuery(function( $ ) {
	'use strict';

	var countAJAX = 0;
    var connError = false;
    
    var Utils = {
		
        displayLoadAjax: function( count ){
            if(!+count){
                $('.ajaxLoader').addClass('hide');
            }else{
                $('.ajaxLoader').removeClass('hide');
            }
        },
        
        mesgShow: function( message, type ){
        	$.jGrowl.defaults.pool = 1;
            $.jGrowl(message, { 
                            glue: 'before',
                            position: 'custom',
                            theme: type,
                            speed: 'fast',
                            life: '3000',
        					animateOpen: { 
        						height: "show"
        					},
        					animateClose: { 
        						height: "hide"
        					}
             });
        },
        
        toListValidationErrorAll: function( errors ){
            var listError = '';
            $.each(errors, function( index, value ) {
                if( $.isArray(value )){
                    listError += '<ul>';
                    $.each( value, function(index, val) {
                        listError += '<li>' + val + '</li>';
                    });
                    listError += '</ul>';
                }
            });
            return listError;
        },
        arrErrorToList: function(errors){
            var str = '';
            if(!+errors.length){return;}
            $.each(errors, function(index, value) {
                str += value;
            });
            return str;
        },
        
        reload: function(){
            location.reload();
        },

        showErrorConnection: function( status ){
            if( !status ){
                setTimeout( this.checkStatus, +GLOBAL_CONFIG.intervalCheckStatus );
                $('.connError').addClass('hide');
                if( connError ){
                    this.reload();
                }
                
            }else{
                setTimeout( this.checkStatus, +GLOBAL_CONFIG.intervalCheckStatusError );
                $('.connError').removeClass('hide');
                connError = true;
            }
        },
        
        superAjax: function( url, data, responseHandler ){
             var that = this;
             var result = null;
             countAJAX++;
             this.displayLoadAjax( countAJAX );
             $.ajax({
                    url: '/'+GLOBAL_CONFIG.lang + url,
                    type: 'POST',
                    data: data,
                    success: function(data, textStatus, jqXHR) {
                        responseHandler(data);
                        countAJAX--;
                        that.displayLoadAjax( countAJAX ); 
                        
                        if (typeof _gaq != "undefined"){
                            _gaq.push(["_trackEvent", "Tasks", url]);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        if(xhr.status == '404' || xhr.status == 0){
                            that.showErrorConnection( true );
                        }else{
                            that.reload();
                        }
                    }
             });
        }
        
	};

	var AppNotes = {
		init: function() {
			this.cacheElements();
			this.bindEvents();
		},
		cacheElements: function() {
			this.noteEditTemplate = _.template($("#modal-edit-note").html());
		},
		bindEvents: function() {
			$('.btn-note').on('click', this.show );
            $(document).on( 'click', '#save-note', this.update );
		},
		show: function() {
		  var id;
          var title = '';
          $(document.body).append(AppNotes.noteEditTemplate({title: title, id: id}));
          //$('#edit-note').modal();
          $('#edit-note').modal({
                backdrop: true,
                keyboard: true
            }).css({
                width: '70%',
                'margin-left': function () {
                    return -($(this).width() / 2);
                },
                //height: '70%'
            });
          $('#edit-note').on('hidden', function () {
              $(this).remove();
          });  
        },
        update: function() {
			var title = $.trim( $('#edit-note').find('#text-note').val() );
            AppNotes.userEvent('create', {title: title});
        },
		
        //--------------------------------------------
        userEvent: function( action, data ){
            switch( action ){
                case 'create':
                    this.noteCreate(data.title);
                break;
            }
        },
        responseHandler: function( data ){
            switch( data.action ){
                case 'create':
                     AppNotes.onCreate(data);
                break;
            }
        },
        
        // create 
        noteCreate: function(title){
            this.srvCreate(title);
        },
        
        onCreate: function( data ){
            if( data.success ){
                Utils.mesgShow(data.message.message, data.message.type);
                $('#edit-note').modal('hide');
            }else{
                Utils.mesgShow(data.message.message+'<hr/>'+ Utils.toListValidationErrorAll(data.errors), data.message.type);
                this.showTooltipError(data.errors);      
            }
        },
        
        srvCreate: function( title ){
            Utils.superAjax('/notes/create.json', {title: title }, AppNotes.responseHandler);
        },
        
        getUpdateElement: function (name){
            var element = '';
            switch(name){
                case 'note':
                    element = $('#text-note');
                break;
            }
            return element;
        },
        showTooltipError: function( data ){
            var that = this;
            $('.errorEdit').removeClass('errorEdit')
                           .removeAttr('rel')
                           .removeAttr('title')
                           .removeAttr('data-original-title')
                           .off('tooltip');
            if(data !== undefined){
                $.each(data, function(index, value) {
                    that.getUpdateElement( index )
                                .addClass('errorEdit')
                                .attr('rel', 'tooltip')
                                .attr('data-original-title', Utils.arrErrorToList(value))
                                .tooltip({placement:'right',
                                          delay: { show: 500, hide: 100 },
                                          //trigger: 'focus',
                                          template: '<div class="tooltip errorTooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                                          });
                });
            }
            
        }
    };

	AppNotes.init();
    
    
}); 	

