<?php

class LB_Save {
	
	protected $items_factory;
	
	protected $shortcode_factory;
	
	public function __construct( $items_factory , $shortcode_factory ){
		
		$this->items_factory = $items_factory;
		
		$this->shortcode_factory = $shortcode_factory;
		
	} // end construct
	
	
	public function save_content( $content ){
		
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

			return $content;

		} // end if
		
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

			return $content;

		} // end if
		
		if ( isset( $_POST[ $this->items_factory->get_prefix() ]['layout'] ) ){
			
			$items = array();
			
			$post_items = explode( ',' , $_POST[ $this->items_factory->get_prefix() ]['layout'] );
				
			$content = $this->get_save_content( $post_items );
			
			//var_dump( $this->get_save_content( $post_items ) );
			
		} // end if
		
		return $content;
		
	} // end get_save_content
	
	
	public function get_save_content( $post_items ){
		
		$content = '';
		
		$items = array();
		
		foreach( $post_items as $item_id ){
			
			$item = $this->items_factory->get_post_item_recursive( $item_id );
			
			if ( $item ){
				
				$items[] = $item;
				
			} // end if
			
		} // end foreach
			
		return $this->shortcode_factory->get_shortcodes_recursive( $items );
		
	} // end get_save_content
	
	
}