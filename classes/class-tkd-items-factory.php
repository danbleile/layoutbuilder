<?php

class TKD_Items_Factory {
	
	protected $shortcodes;
	
	public function __construct( $shortcodes ){
		
		$this->shortcodes = $shortcodes;
		
	} // end __construct
	
	
	public function get_item( $slug , $settings = array() , $content = '' , $get_children = true ){
		
		$item = false;
		
		$shortcode = $this->shortcodes->get_shortcode( $slug );
		
		if ( $shortcode && ! empty( $shortcode['path'] ) && ! empty( $shortcode['class'] ) ){
			
			if ( file_exists( $shortcode['path'] ) ){
				
				require_once $shortcode['path'];
				
				if ( class_exists( $shortcode['class'] ) ){
					
					$item = new $shortcode['class']( $settings , $content );
					
					if ( $get_children ){
						
						$children = $this->get_items_from_content( 
							$content, 
							$item->get_allowed_children(), 
							$item->get_default_children() 
							);
						
						$item->set_children( $children , $this );
						
					} // end if
					
				} // end if
				
			} // end if
			
		} // end if
		
		return $item;
		
	} // end get_item
	

	
	
	public function get_items_from_content( $content , $allowed , $default = false ){
		
		$items = array();
		
		if ( 'column-items' == $allowed ){
			
			$allowed = $this->shortcodes->get_column_shortcodes();
			
		} // end if
		
		if ( $allowed ){
		
			$regex = $this->get_shortcode_regex( $allowed );
			
			$split_content = $this->get_split_shortcodes( $content , $regex );
			
			$array_items = array();
			
			foreach( $split_content as $s_content ){
				
				$temp_item = $this->get_content_item_array( $s_content , $regex , $default );
				
				if ( $temp_item ){
					
					$array_items[] = $temp_item;
					
				} // end if
				
			} // end foreach
			
			foreach( $array_items as $array_item ){
				
				$item = $this->get_item( 
					$array_item['slug'], 
					$array_item['settings'], 
					$array_item['content']
					);
					
				if ( $item ){
					
					$items[] = $item;
					
				} // end if
				
			} // end foreach 
			
			return $items;
			
		} else {
			
			return array();
			
		}// end if
		
	} // end get_items_from_content
	
	
	public function get_content_item_array( $content, $regex , $default = false ){
		
		$item = false;
			
		preg_match( $regex , $content , $matches , PREG_OFFSET_CAPTURE );
		
		if ( ! empty( $matches ) ){
			
			$settings = shortcode_parse_atts( $matches[3][0] );
			
			if ( ! is_array( $settings ) ) {
				
				$settings = array();
				
			} // end if
			
			$item = array(
				'slug'     => $matches[2][0],
				'settings' => $settings,
				'content'  => $matches[5][0],
			);
			
		} else if ( empty( $matches ) && ! empty( $content ) && $default ){
			
			$item = array(
				'slug'     =>  $default,
				'settings' => array(),
				'content'  => $content,
			);
			
		} // end if
		
		return $item;
		
	} // endget_content_item_array
	
	
	protected function get_split_shortcodes( $content , $regex ) {
		
		if ( '' == $content ) $content = ' ';
	
		// Add Delimiter to content. This is required to account for content outside of shortcodes
		$split_set = preg_replace_callback( 
			$regex, 
			function( $matches ) { return '|||' . $matches[0] . '|||'; }, 
			$content 
			);
	
		// Split into an array of content and shortcodes
		$split_set = preg_split( '/\|\|\|/', $split_set, -1 , PREG_SPLIT_NO_EMPTY);
	
		return $split_set;
		
	} // end get_split_shortcodes
	
	
	protected function get_shortcode_regex( $shortcodes ) {

		$sc = array();
	
		foreach( $shortcodes as $shortcode ) {
	
			$sc[$shortcode] = true;
	
		} // end foreach
	
		global $shortcode_tags;
	
		$temp = $shortcode_tags;
	
		$shortcode_tags = $sc;
	
		$regex = '/' . get_shortcode_regex()  . '/';
	
		$shortcode_tags = $temp;
	
		return $regex;
	
	} // end get_item_regex
	
	
} // end TKD_Post_Editor