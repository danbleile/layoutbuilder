var tkd_builder = {
	
	init:function(){
		
		tkd_builder.layout.equal_columns();
		tkd_builder.layout.full_bleed();
		tkd_builder.layout.background_bleed();
		tkd_builder.bind_events();
		
	},
	
	bind_events:function(){
		
		jQuery( window ).resize( 
			function(){
				tkd_builder.layout.equal_columns();
				tkd_builder.layout.full_bleed();
				tkd_builder.layout.background_bleed();
			}
		);
		
	},
	
	layout: {
		
		equal_columns: function(){
			
			jQuery('.tkd-row').each( 
				function(){
					var c_height = 0;
					var row = jQuery( this );
					var columns = row.find('.tkd-column');
					
					if ( columns.length > 1 ){
					
						columns.each(
							function(){
								var h = jQuery( this ).outerHeight();
								if ( h > c_height ){
									
									c_height = h;
									
								} // end if
								
							} // end function
						); // end each
						
						columns.css('min-height', c_height + 'px' );
					
					} // end if
					
				}
			);
			
			
		}, // end equal_columns
		
		full_bleed : function(){
			jQuery( '.tkd-full-bleed-right, .tkd-full-bleed-left').each( 
				function(){
					
					var c = jQuery( this );
					var style = '';
					if ( c.hasClass('tkd-background-image') ) {
						style_bg = c.css('background-image');
						style += 'background-image: url(' + style_bg.replace('url(','').replace(')','').replace(/\"/gi, "") + ');';
					}
					if ( c.hasClass('tkd-background-color') ) style += 'background-color:' + c.css('background-color') + ';';
					
					if ( c.hasClass('tkd-full-bleed-left') ){
						
						var w = c.offset().left;
						style += 'left:-' +  w  + 'px;';
						
					}
					
					if ( c.hasClass('tkd-full-bleed-right') ){
						
						var w = ( jQuery( window ).width() - ( c.offset().left + c.outerWidth()));
						style += ';right: -' + w + 'px;';
						
					} // end if
					
					
					
					console.log( w );
					
					c.prepend( '<div class="tkd-bleed-bg-item" style="' + style + '"></div>' );
					
				}
			);
			
			
			
		
		},
		
		background_bleed : function(){
			jQuery( '.tkd-background-bleed-right, .tkd-background-bleed-left').each( 
				function(){
					
					var c = jQuery( this );
					var style = '';
					if ( c.hasClass('tkd-background-image') ) {
						style_bg = c.css('background-image');
						style += 'background-image: url(' + style_bg.replace('url(','').replace(')','').replace(/\"/gi, "") + ');';
					}
					if ( c.hasClass('tkd-background-color') ) style += 'background-color:' + c.css('background-color') + ';';
					
					if ( c.hasClass('tkd-background-bleed-left') ){
						
						var w = c.offset().left;
						style += 'left:-' +  w  + 'px;';
						
					}
					
					if ( c.hasClass('tkd-background-bleed-right') ){
						
						var w = ( jQuery( window ).width() - ( c.offset().left + c.outerWidth()));
						style += ';right: -' + w + 'px;';
						
					} // end if
					
					
					
					console.log( w );
					
					c.prepend( '<div class="tkd-bleed-bg-item" style="' + style + '"></div>' );
					
				}
			);
			
			
			
		
		}
		
	},
	
}// JavaScript Document

tkd_builder.init();

