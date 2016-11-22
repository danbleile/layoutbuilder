<?php

class TKD_Save {
	
	protected $items_factory;
	
	protected $shortcodes;
	
	public function __construct( $items_factory ){
		
		$this->items_factory = $items_factory;
		
	} // end __construct
	
	
	public function init(){
		
		add_filter( 'content_save_pre' , array( $this , 'save_content' ) , 99 );
		
	} // end init
	
	
	public function save_content( $content ){
		
		if ( isset( $_POST['_tkd_builder']['layout']['items'] ) ){
		
			// If this is an autosave, our form has not been submitted, so we don't want to do anything.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
	
				return $content;
	
			} // end if
			
			// If this is an autosave, our form has not been submitted, so we don't want to do anything.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
	
				return $content;
	
			} // end if
			
			$items = $this->items_factory->get_items_from_save( $_POST['_tkd_builder']['layout']['items'] );
			
			var_dump( $_POST );
			
			//var_dump( $items );
			
			//var_dump( $items );
			
			if ( empty( $items ) ) $items = array();
			
			$shortcode_content = '';  
			
			foreach( $items as $item ){
				
				if ( is_object (  $item ) ){
				
					$shortcode_content .= $item->get_the_item_shortcode();
				
				} // end if
				
			} // end foreach
			
			return $shortcode_content;
			
			//return $content;
			
		} else {
			
			return $content;
			
		}// end if
		
	} // end save_content
	
	
	
} // end TKD_Save