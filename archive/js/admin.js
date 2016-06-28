var tk_builder = {
	
	lb : jQuery('#layout-builder'),
	
	
	lb_editor : jQuery('#lb-layout-editor'),
	
	
	init : function(){
		
		tk_builder.events.bind();
		
		tk_builder.layout.init();
		
		tk_builder.modal.init();
		
	}, // init
	
	
	events : {
		
		bind : function(){
			
			jQuery( window ).on( 'resize' , function(){ tk_builder.layout.resize_layout()  } );
			
			tk_builder.layout.wrap.on( 'click' , '.action-remove-item' , function( event ){ event.preventDefault(); tk_builder.layout.remove_item( jQuery( this ) )});
			
			tk_builder.lb.on( 'click' , '.action-edit-item' , function( event ){ event.preventDefault(); tk_builder.layout.edit_item( jQuery( this ) ); });
			
			tk_builder.lb.on('click' , '.do-edit-item-action', function( event ){ event.preventDefault(); tk_builder.forms.close_edit( jQuery( this ) ); });
			
		}
		
	}, // end events
	
	
	layout : {
		
		wrap : jQuery('#lb-layout-editor'),
		
		resize_layout : function(){
			
			tk_builder.layout.equalize_columns();
			
		}, // end resize_layout
		
		init: function(){
			
			tk_builder.layout.apply_sort( false );
			
			tk_builder.layout.update_layout();
			
			tk_builder.layout.events.bind();
			
			//Testing
			//tk_builder.layout.enable_drop();
			
		},
		
		events: {
			
			bind:function(){
				
				tk_builder.layout.wrap.on('click' , '.tk-builder-row-options fieldset' , function(){ tk_builder.layout.add_row( jQuery( this ) , false ) });
				
			}, // end bind 
			
		},
		
		
		edit_item : function( ic ) {
			
			var id = ic.closest('.layout-item').attr('id');
			
			tk_builder.modal.open_modal( 'form-' + id );
			
		}, // end edit item
		
		
		apply_sort : function( wrapper ){
			
			if ( ! wrapper ) {
				
				wrapper = tk_builder.layout.wrap;
				
				wrapper.children('.child-items').sortable({
				stop: function( event , ui ){ 
					tk_builder.layout.update_layout(); 
					}, 
				});
				
			} // end if
			
			if ( wrapper.hasClass('row') ){
				
				row = wrapper;
				
			} else {
				
				row = wrapper.find('.row');
				
			} // end if
			
			row.children( '.child-items' ).sortable({
				stop: function( event , ui ){ 
					tk_builder.layout.update_layout();
				 }, 
			});
			
			wrapper.find( '.column > .child-items' ).sortable( {
				connectWith: '.column > .child-items',
				stop: function( event , ui ){ 
					tk_builder.layout.update_layout();
					}, 
			});
			
		}, // end apply_sort
		
		
		equalize_columns : function(){
			
			tk_builder.layout.wrap.find('.row').each( function(){
			
				var r = jQuery( this );
				
				var h = false;
				
				var colms = r.children('.child-items').children('.column').children('.child-items');
				
				colms.css( 'min-height', 100 );
				
				if ( colms.length > 1 ){
				
					colms.each( function(){
						
						var c = jQuery( this );
						
						console.log( c.height() );
							
						if ( ! h ){
							
							h = c.outerHeight();
							
						} else {
							
							var ch = c.outerHeight();
							
							if ( ch > h ){
								
								h = ch;
								
							} // end if
							
						} // end if
						
					}); // end each
				
					colms.css( 'min-height', h );
				
				} // end if
				
			}); // end each
			
		}, // end equalize_columns
		
		
		remove_item : function( ic ){
		
			var itm = ic.closest( '.layout-item');
		  
			itm.slideUp('fast' , function(){
			  
			  	jQuery( this ).remove();
			  
			  	jQuery( window ).trigger('resize');
			  
			 	 tk_builder.layout.update_chidren();
			  
		  	});
		  
	  	}, // end remove_item
		
		
		update_chidren : function(){
		
			jQuery('input.lb-child-items').each( function(){
				
				var ip = jQuery( this );
				
				var ids = new Array();
				
				ip.siblings('.child-items').children('.layout-item').each( function(){
					
					ids.push( jQuery( this ).attr('id') );
					
				}); // end each
				
				ip.val( ids.join(',') );
			
			}); // end each
		
		}, // end update_chidren
		
		
		update_content : function( container ){
			
			if ( ! container ){
				
				container = tk_builder.layout.wrap;
				
			} // end if
		
			container.find('textarea.content-textarea').each( function(){
				
				var t = jQuery( this );
				
				var frm = t.siblings('iframe');
				
				frm.contents().find('body').html( '<div id="iframe-wrap">' + t.val() + '</div>' );
				
			});// end each
			
		}, // end update_content
		
		
		update_layout : function(){
		
			tk_builder.layout.update_content( false );
			
			tk_builder.layout.update_chidren();
			
			tk_builder.layout.resize_layout();
			
			tk_builder.layout.set_frame_height(false);
			
		}, // end update_layout
		
		apply_events : function( container ){
			
			tk_builder.layout.apply_sort( container );
			
			tk_builder.layout.update_content( container );
			
		}, // end apply events
		
		
		set_frame_height : function( container ){
			
			if ( ! container ){
				
				container = tk_builder.layout.wrap;
				
			} // end if
			
			container.find( 'iframe.content-iframe' ).each( function(){
				
				var ifrm = jQuery( this );
				
				var h = ifrm.contents().find('#iframe-wrap').outerHeight();
				
				ifrm.height( h );
			
			}); // end each
			
		}, // end 
		
		
		add_row: function( ic , show_form ){
			
			container = tk_builder.layout.wrap.children('.child-items');
			
			data = ic.serialize();
			
			tk_builder.layout.get_part( data , container, show_form );
			
		},
		
		get_part:function( data , container , show_form ){
			
			data = data + '&action=tk_editor_get_part';
			
			//data = { action : 'tk_editor_get_part' };
			
			jQuery.post(
				ajaxurl,
				data,
				function( response ){
					
					console.log( response );
					
					tk_builder.layout.insert_part( response , container );
					
					tk_builder.forms.insert( response.forms );
					
					tk_builder.layout.apply_events( jQuery('#' + response.id ) );
					
				},
				'json'
			);
			
			
		}, // end get_part
		
		
		insert_part: function( json , container ){
			
			container.append( json.editor );
			
			tk_builder.layout.update_layout();
			
		}, // end insert_part 
		
		/***************************************
		Testing
		***************************************/
		/*enable_drop: function(){
			
			jQuery('#tk-builder-add-row fieldset').draggable({
      			connectToSortable: "#lb-layout-editor .child-items",
      			helper: "clone",
      			revert: "invalid"
    			});
			
		},*/
		
		/* End Testing */
		  
		
	}, // end layout
	
	forms : {
		
		form_wrap : jQuery('#lb-form-editor'),
		
		insert : function( forms ){
			
			if ( forms ){
				
				for ( var key in forms ) {
					
					if ( ! forms.hasOwnProperty( key ) ) continue;
					
					if ( forms[key].type == 'text' ) {
					
						tk_builder.forms.editor_form( forms[key].id , forms[key].item_id );
					
					} else {
						
						tk_builder.forms.form_wrap.prepend( forms[key].form );  
						
					} // end if
					
				} // end for
				
			} // end if
			
		}, // end insert
		
		close_edit : function( btn ){
			
			var form = btn.closest( '.tk-builder-form' );
			
			if ( form.hasClass( 'tk-form-type-text' ) ){
				
				var content = tk_builder.forms.get_text_content( form );
				
			} else {
			} // end if
			
		}, // end close_edit
		
		
		get_text_content: function( form ){
			
			alert(form.find( 'iframe').attr('id') );
			
			var content = tinyMCE.get( form.find( 'textarea').attr('id') ).getContent();
			
			return content;
			
		}, // end get text content
		
		editor_form : function( form_id , item_id ){
			
			alert( form_id , item_id );
		
			var editor = jQuery('.inactive-editor').first();
			
			editor.find('textarea').attr('name' , '_content_' + item_id );
			
			editor.attr( 'id' , form_id ).removeClass( 'inactive-editor');
			
		}, // end editor_form
		
		get_content : function(){
		}, // end get content
		
		
		
	}, // end forms

	
	modal : {
		
		modal_bg : false,
		
		init: function(){
			
			tk_builder.modal.set_modal_bg();
			
			jQuery('body').on( 'click' , '.close-modal-action' , function( event ){ event.preventDefault(); tk_builder.modal.close_modal(); });
			
		}, // end init
		
		set_modal_bg : function(){
			
			jQuery('body').append('<div id="lb-modal-bg" class="close-modal-action"></div>');
			
			tk_builder.modal.modal_bg = jQuery('#lb-modal-bg');
			
		}, // end set_modal_bg
		
		close_modal : function(){
			
			var m = tk_builder.lb.find('.tk-builder-modal-wrap.active');
			
			m.removeClass('active');
			
			tk_builder.modal.modal_bg.fadeOut('fast');
			
		}, // end close_modal
		
		open_modal : function( form_id ){
			
			tk_builder.modal.modal_bg.fadeIn('fast');
			
			tk_builder.lb.find('#' + form_id ).closest('.tk-builder-modal-wrap').addClass('active');
			
		}
		
	}, // end modal
	
}

tk_builder.init();

