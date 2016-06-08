<?php

class LB_Items_Factory {
	
	protected $prefix = '_layout_builder';
	
	protected $content_prefix = '_content_';
	
	
	public function get_prefix(){
		
		return $this->prefix;
		
	}
	
	public function get_content_prefix(){
		
		return $this->content_prefix;
		
	}
	
	
	public function get_item( $slug ){
		
		$item = false;
		
		$items_array = $this->get_items_array();
		
		if ( array_key_exists( $slug , $items_array ) ){
			
			$item_obj = $this->get_item_object( $items_array[ $slug ]['file_path'] , $items_array[ $slug ]['class_name'] );
			
			if ( $item_obj ){
				
				$item = $item_obj;
				
			} // end if
			
		} // end if
		
		return $item;
		
	} // end if
		
	
	public function get_items(){
		
		$items_array = $this->get_items_array();
		
		$items = array();
		
		foreach( $items_array as $key => $i ){
			
			$item_obj = $this->get_item_object( $i['file_path'] , $i['class_name'] );
			
			if ( $item_obj ){
				
				$items[ $key ] = $item_obj;
				
			} // end if
			
		} // end foreach
		
		$items = apply_filters( 'lb_items_get_items' , $items );
		
		return $items;
		
	} // end get_items
	
	
	protected function get_item_object( $file_path , $class_name ){
		
		$item = false;
		
		if ( file_exists ( $file_path ) ){
				
			require_once $file_path;
			
			if ( class_exists( $class_name ) ){
				
				$item = new $class_name;
				
			} // end if 
			
		} // end if
		
		return $item;
		
	} // end get_item_object
	
	
	public function get_items_array(){
		
		$item_path = plugin_dir_path( dirname( __FILE__ ) );
		
		$items_array = array(
			'text' => array(
				'file_path'    => $item_path . 'items/class-lb-item-text.php',
				'class_name'   => 'LB_Item_Text',
				'register'     => true,
				'order'        => 0,
				'content_item' => true,
				),
			'row' => array(
				'file_path'    => $item_path . 'items/class-lb-item-row.php',
				'class_name'   => 'LB_Item_Row',
				'register'     => true,
				'order'        => 10,
				'content_item' => false,
				),
			'column' => array(
				'file_path'    => $item_path . 'items/class-lb-item-column.php',
				'class_name'   => 'LB_Item_Column',
				'register'     => true,
				'order'        => 10,
				'content_item' => false,
				),
		);
		
		$items_array = apply_filters( 'lb_items_get_items_array' , $items_array );
		
		uasort( $items_array , function( $a , $b ){ return $a['order'] - $b['order']; });
		
		return $items_array;
		
	} // end get_items_array
	
	
	public function get_content_items_recursive( $content , $allowed , $default ){
		
		$items = array();
		
		if ( in_array( 'content-items' , $allowed ) ){
			
			$allowed = $this->get_column_items_array();
			
		} // end if
		
		$cia = $this->get_content_items_array( $content , $allowed , $default );
		
		foreach( $cia as $item_array ){
			
			$item = $this->get_item( $item_array['slug'] );
			
			if ( $item ){
				
				$item->set_item( $item_array['settings'] , $item_array['content'] );
				
				if ( $item->get_allow_children() ){
					
					
					$item->set_children( $this->get_content_items_recursive( $item_array['content'] , $item->get_allow_children() , $item->get_default_child() ) );
					
				} // end if
				
				$items[] = $item;
				
			} // end if
			
		} // end foreach
		
		return $items;
		
	} // end get_content_items_recursive
	
	
	public function get_content_items_array( $content , $allowed , $default = false ){
		
		$items = array();
		
		$regex = $this->get_shortcode_regex( $allowed );
		
		$sections = $this->get_split_shortcodes( $content , $regex );
		
		foreach ( $sections as $section ){
			
			$item = false;
			
			preg_match( $regex , $section , $matches , PREG_OFFSET_CAPTURE );
			
			if ( ! empty( $matches ) ){
				
				$item = array(
					'slug'     =>  $matches[2][0],
					'settings' => shortcode_parse_atts( $matches[3][0] ),
					'content'  => $matches[5][0],
				);
				
			} else if ( empty( $matches ) && ! empty( $section ) && $default ){
				
				$item = array(
					'slug'     =>  $default,
					'settings' => array(),
					'content'  => $section,
				);
				
			} // end if
			
			if ( $item ) {
				
				$items[] = $item;
				
			} // end if
			
		} // end foreach
		
		return $items;
		
	}
		
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
	
	
	protected function get_split_shortcodes( $content , $regex ) {
		
		if ( '' == $content ) $content = ' ';
	
		// Add Delimiter to content. This is required to account for content outside of shortcodes
		$split_set = preg_replace_callback( $regex, function( $matches ) { return '|||' . $matches[0] . '|||'; }, $content );
	
		// Split into an array of content and shortcodes
		$split_set = preg_split( '/\|\|\|/', $split_set, -1 , PREG_SPLIT_NO_EMPTY);
	
		return $split_set;
		
	} // end get_split_shortcodes
	
	
	public function get_post_item_recursive( $item_id ){
		
		$item = $this->get_item_from_id( $item_id );
		
		if ( $item ){
			
			$settings = ( ! empty( $_POST[ $this->get_prefix() ][ $item_id ]['settings'] ) )? $_POST[ $this->get_prefix() ][ $item_id ]['settings'] : array();
			
			$content = ( ! empty( $_POST[ $this->get_content_prefix() . $item_id ]  ) ) ? $_POST[ $this->get_content_prefix() . $item_id ] : '';
			
			$item->set_item( $settings, $content, $item_id , $clean = true );
			
			if ( ! empty( $_POST[ $this->get_prefix() ][ $item->get_id() ]['items'] ) ){
				
				$children = $_POST[ $this->get_prefix() ][ $item->get_id() ]['items'];
				
				$children = explode( ',' , $children );
				
				$item_children = array();
				
				foreach( $children as $child_id ){
					
					$child = $this->get_post_item_recursive( $child_id );
					
					if ( $child ){
						
						$item_children[] = $child;
						
					} // end if
					
				} // end foreach
				
				$item->set_children( $item_children );
				
			} // end if
			
		} // end if 
		
		return $item;
		
	}
	
	
	public function get_item_from_id( $id ){
		
		$id_array = explode( '_' , $id );
		
		$item = $this->get_item( $id_array[0] );
		
		return $item;
		
	}
	
	public function get_column_items_array(){
		
		$c_items = array();
		
		$items_array = $this->get_items_array();
		
		foreach( $items_array as $slug => $item ){
			
			if ( ! empty( $item['content_item'] ) && $item['content_item'] ){
				
				$c_items[] = $slug;
				
			} // end if
			
		} // end foreach
		
		return $c_items;
		
	} 
	
	
	
}