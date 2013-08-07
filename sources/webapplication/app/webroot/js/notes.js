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
        },
        convertToHtml: function( str ){
          //Encode Entities
          return $("<div/>").text(str).html();
        },
        
        wrapTags: function( title, tags ){
            var that = this;
            title = that.convertToHtml(title);
            if(tags){
                $.each(tags, function(index, value) {
                    if( value ){
                        value = that.convertToHtml(value);
                        title = title.split('#'+value).join('<span class="tags label label-important" data-tag="'+value+'">&#x23;'+value+'</span>');    
                    }
                });
            }
            return title;
        },
                
        convertToText: function( str ){
            //Dencode Entities
            return $("<div/>").html(str).text();
        }
        
	};

	var AppNotes = {
		init: function() {
			this.cacheElements();
			this.bindEvents();
            AppNotes.$new_note.focus();
		},
		cacheElements: function() {
			this.noteTemplate = _.template($("#note-template").html());
            this.noteEditTemplate = _.template($("#modal-edit-note").html());
			this.$newNote = $('#new-note');
            this.$new_note = $('#new-note');
			this.$noteList = $('#notes');
            
		},
		bindEvents: function() {
			var list = this.$noteList;
			$('.add-note').on('click', this.create );
            $('.new-note').on('keyup', this.create );
            $('.btn-note').on('click', this.show );
            this.blurIntput();
            $('.create-new-note').on('click', this.show );
            list.on( 'click', '.note-edit', this.show );
            list.on( 'click', '.note-view', this.view );
            this.inlineConfirmation('.note-remove');
            list.on( 'click', '#save-note', this.update );
            list.on( 'click', '.tags', this.clickTags );
            
        },
		blurIntput: function(){
		  AppNotes.$new_note.blur(function(){
		      if($(this).hasClass('errorEdit')){
    		      $(this).removeClass('errorEdit');
    		  }
		  });
    	},
        show: function() {
		  var list = AppNotes.$noteList;
          var id = $(this).parents('li.note-box').data('id');
          var title = $.trim($(this).parents('li.note-box:data(id)').children('.note').text());
          list.append(AppNotes.noteEditTemplate({title: title, id: id}));
          //$('#edit-note').modal();
          $('#edit-note').modal({
                backdrop: true,
                keyboard: true
            }).css({
                width: '70%',
                'margin-left': function () {
                    return -($(this).width() / 2);
                }
            });
          $('#edit-note').on('shown', function () {
              $(this).find('#text-note').focus();
          });
          $('#edit-note').on('hidden', function () {
              $(this).remove();
              AppNotes.$new_note.focus();
          });
            
        },
        view: function() {
		  var list = AppNotes.$noteList;
          var id = $(this).parents('li.note-box').data('id');
          var title = $.trim($(this).parents('li.note-box:data(id)').children('.note').text());
          list.append(AppNotes.noteEditTemplate({title: title, id: id, view: true}));
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
              AppNotes.$new_note.focus();
          });
            
        },
        create: function(e) {
		    var $input = AppNotes.$new_note,
				val = $.trim( $input.val() );
            if(e.ctrlKey || e.type == 'click'){
                if (!val ){
                    $input.addClass('errorEdit');
                    $input.focus();
                    return;
    			}
                $input.removeClass('errorEdit');   
    			AppNotes.userEvent('create', {title: val });
    			$input.val('');
                    
            }
            $input.focus();
            
		},
		update: function() {
			var title = $.trim( $('#edit-note').find('#text-note').val() );
            var id = $.trim($('#edit-note').data('id'));
            
            if (id != "undefined"){
                AppNotes.userEvent('update', {id: id, title: title });
            }else {
                AppNotes.userEvent('create', {title: title});    
            }
            
        },
		destroy: function() {
		    var that = this;
			var id = $(this).parents('li.note-box').data('id');
            if( !id ){
                return false;
            }
            
            
        },
        inlineConfirmation: function(el){
            $(el).inlineConfirmation({
              //reverse: true,
              confirm: "<a href='#'><i class='icon-trash icon-white n-del'></i></a>",
              cancel: "",
              separator: "",
              expiresIn: 3,
              bindsOnEvent: "click",
              confirmCallback: function(el) {
                 var id = $(el).parents('li.note-box').data('id');
                 AppNotes.userEvent('delete', {id: id });
              },
              cancelCallback: function(el) {
                 //mesg('Отмена удаления .');
              },
           });
           
        },
        
        clickTags: function(){
            var tag = $(this).attr('data-tag');
            if(tag){
                window.location = '/'+GLOBAL_CONFIG.lang+'/tasks#list-'+tag;    
            }
            return false;
        },
        
        
        //--------------------------------------------
        userEvent: function( action, data ){
            switch( action ){
                case 'create':
                    this.noteCreate(data.title);
                break;
                case 'update':
                    this.noteUpdate(data.id, data.title);
                break;
                case 'delete':
                    this.noteDelete(data.id);
                break;
            }
        },
        
        responseHandler: function( data ){
            switch( data.action ){
                case 'create':
                     AppNotes.onCreate(data);
                break;
                case 'update':
                    AppNotes.onUpdate(data);
                break;
                case 'delete':
                    AppNotes.onDelete(data);
                break;
            }
        },
        
        // create 
        noteCreate: function(title){
            this.srvCreate(title);
        },
        onCreate: function( data ){
            if( data.success ){
                this.renderCreate( data.data );
                $('#edit-note').modal('hide');
                
            }else{
                Utils.mesgShow(data.message.message+'<hr/>'+ Utils.toListValidationErrorAll(data.errors), data.message.type);
                this.showTooltipError(data.errors);  
                    
            }
        },
        srvCreate: function( title ){
            Utils.superAjax('/notes/create.json', {title: title }, AppNotes.responseHandler);
        },
        renderCreate: function( data ){
            this.$noteList.prepend(this.noteTemplate({ id: data.id, title: Utils.wrapTags(data.title, data.tags), modified: data.modified }))
                          .slideDown('slow');
            this.inlineConfirmation('li[data-id='+data.id+'] .note-remove');
        },
        //delete
        noteDelete: function( id ){
            this.srvDelete( id );
            this.renderDelete( id );
        },
        onDelete: function(data){
            if(!data.success){
                Utils.mesgShow(data.message.message, data.message.type);
            }    
        },
        srvDelete: function( id ){
            Utils.superAjax('/notes/delete.json', {id: id}, AppNotes.responseHandler);
        },
        renderDelete: function( id ){
            
            $("li[data-id='"+id+"']").hide( "drop", { direction: "left" }, "slow", function(){
                $(this).remove();
            } ); 
            
        },
        //update
        noteUpdate: function( id, title ){
            this.srvUpdate( id, title );
        },
        onUpdate: function(data){
            if( data.success ){
                this.renderUpdate( data.data );
                $('#edit-note').modal('hide');
            }else{
            	Utils.mesgShow(data.message.message+'<hr/>'+Utils.toListValidationErrorAll(data.errors), data.message.type);
                this.showTooltipError(data.errors);   
            } 
        },
        srvUpdate: function( id, title ){
            Utils.superAjax('/notes/update.json', {id: id, title: title}, AppNotes.responseHandler);
        },
        renderUpdate: function( data ){
            var list = this.$noteList;
            $("li[data-id='"+data.id+"']").hide( "drop", { direction: "left" }, "slow", function(){
                list.prepend(this);
                $(this).show();
                $(this).find('.title-note').html( Utils.wrapTags(data.title, data.tags) );
            } ); 
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
    
    
    window.onbeforeunload = function(e) {
        if(+countAJAX && !connError){
            e = e || window.event;
            if (e) {
                e.returnValue = GLOBAL_CONFIG.onbeforeunloadMessage;
            }
            return GLOBAL_CONFIG.onbeforeunloadMessage;
        }
    };


}); 	

