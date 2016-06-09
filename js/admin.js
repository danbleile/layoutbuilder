var LayoutBuilder = {
	
	lb : jQuery('#layout-builder'),
	
	
	lb_editor : jQuery('#lb-layout-editor'),
	
	
	init : function(){
		
		LayoutBuilder.layout.apply_sort( false );
		
		LayoutBuilder.events.bind();
		
		LayoutBuilder.layout.update_layout();
		
		LayoutBuilder.modal.init();
		
	}, // init
	
	
	events : {
		
		bind : function(){
			
			jQuery( window ).on( 'resize' , function(){ LayoutBuilder.layout.resize_layout()  } );
			
			LayoutBuilder.layout.wrap.on( 'click' , '.action-remove-item' , function( event ){ event.preventDefault(); LayoutBuilder.layout.remove_item( jQuery( this ) )});
			
			LayoutBuilder.lb.on( 'click' , '.action-edit-item' , function( event ){ event.preventDefault(); LayoutBuilder.layout.edit_item( jQuery( this ) ); });
			
		}
		
	}, // end events
	
	
	layout : {
		
		
		wrap : jQuery('#lb-layout-editor'),
		
		resize_layout : function(){
			
			LayoutBuilder.layout.equalize_columns();
			
		}, // end resize_layout
		
		
		edit_item : function( ic ) {
			
			var id = ic.closest('.layout-item').attr('id');
			
			LayoutBuilder.modal.open_modal( id );
			
		}, // end edit item
		
		
		apply_sort : function( wrapper ){
			
			if ( ! wrapper ) {
				
				wrapper = LayoutBuilder.layout.wrap;
				
				wrapper.children('.child-items').sortable({
				stop: function( event , ui ){ 
					LayoutBuilder.layout.update_layout(); 
					}, 
				});
				
			} // end if
			
			wrapper.find( '.row > .child-items' ).sortable({
				stop: function( event , ui ){ 
					LayoutBuilder.layout.update_layout();
				 }, 
			});
			
			wrapper.find( '.column > .child-items' ).sortable( {
				connectWith: '.column > .child-items',
				stop: function( event , ui ){ 
					LayoutBuilder.layout.update_layout();
					}, 
			});
			
		}, // end apply_sort
		
		
		equalize_columns : function(){
			
			LayoutBuilder.layout.wrap.find('.row').each( function(){
			
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
			  
			 	 LayoutBuilder.layout.update_chidren();
			  
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
		
		
		update_content : function(){
		
			LayoutBuilder.layout.wrap.find('textarea.content-textarea').each( function(){
				
				var t = jQuery( this );
				
				var frm = t.siblings('iframe');
				
				frm.contents().find('body').html( '<div id="iframe-wrap">' + t.val() + '</div>' );
				
			});// end each
			
		}, // end update_content
		
		
		update_layout : function(){
		
			LayoutBuilder.layout.update_content();
			
			LayoutBuilder.layout.update_chidren();
			
			LayoutBuilder.layout.resize_layout();
			
			LayoutBuilder.layout.set_frame_height();
			
		}, // end update_layout
		
		
		set_frame_height : function(){
			
			LayoutBuilder.layout.wrap.find( 'iframe.content-iframe' ).each( function(){
				
				var ifrm = jQuery( this );
				
				var h = ifrm.contents().find('#iframe-wrap').outerHeight();
				
				ifrm.height( h );
			
			}); // end each
			
		}, // end 
		  
		
	}, // end layout
	
	
	modal : {
		
		modal_bg : false,
		
		init: function(){
			
			LayoutBuilder.modal.set_modal_bg();
			
			jQuery('body').on( 'click' , '.close-modal-action' , function( event ){ event.preventDefault(); LayoutBuilder.modal.close_modal(); });
			
		}, // end init
		
		set_modal_bg : function(){
			
			jQuery('body').append('<div id="lb-modal-bg" class="close-modal-action"></div>');
			
			LayoutBuilder.modal.modal_bg = jQuery('#lb-modal-bg');
			
		}, // end set_modal_bg
		
		close_modal : function(){
			
			var m = LayoutBuilder.lb.find('.tk-builder-modal-wrap.active');
			
			m.removeClass('active');
			
			LayoutBuilder.modal.modal_bg.fadeOut('fast');
			
		}, // end close_modal
		
		open_modal : function( form_id ){
			
			LayoutBuilder.modal.modal_bg.fadeIn('fast');
			
			LayoutBuilder.lb.find('#form-' + form_id ).closest('.tk-builder-modal-wrap').addClass('active');
			
		}
		
	}, // end modal
	
}

LayoutBuilder.init();

