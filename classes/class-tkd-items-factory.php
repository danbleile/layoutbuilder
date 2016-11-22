<?php

class TKD_Items_Factory {
	
	protected $forms;
	
	//@var array Defined layouts
	protected $layouts = array(
		'single'     => array( 'columns' => 1, 'label' => 'Single' ),
		/*'side-right' => array( 'columns' => 2, 'label' => 'Sidebar Right' ),
		'side-left'  => array( 'columns' => 2, 'label' => 'Sidebar Left' ), */
		'half'       => array( 'columns' => 2, 'label' => 'Halves' ),
		'third'      => array( 'columns' => 3, 'label' => 'Thirds' ),
		'quarter'    => array( 'columns' => 4, 'label' => 'Quarters' ),
	);
	
	public function __construct( $forms ){
		
		$this->forms =  $forms;
		
	} // end __construct
	
	
	public function get_layouts(){
		
		return $this->layouts;
		
	} // end get_layouts
	
	
	public function get_item( $slug , $settings = array() , $content = '' , $get_children = true , $clean_item = false ){
		
		$item = false;
		
		$item_array = $this->get_the_item_aray( $slug );
		
		if ( $item_array && ! empty( $item_array['path'] ) && ! empty( $item_array['class'] ) ){
			
			if ( file_exists( $item_array['path'] ) ){
				
				require_once $item_array['path'];
				
				if ( class_exists( $item_array['class'] ) ){
					
					$item = new $item_array['class']( $this->forms );
					
					$item->set_item( $settings , $content , $clean_item );
					
					if ( $get_children ){
						
						$children = $this->get_items_from_content( 
							$content, 
							$item->get_allowed_children(), 
							$item->get_default_children() 
							);
							
						if ( 'tkdrow' == $item->get_slug() ){
							
							$this->check_row_columns( $item , $children );
							
						} // end if
						
						foreach( $children as $index => $child ){
							
							$children[ $index ]->set_index( $index );
							
						} // end foreach
						
						$item->set_children( $children );
						
					} // end if
					
				} // end if
				
			} // end if
			
		} // end if
		
		return $item;
		
	} // end get_item
	
	
	public function check_row_columns( $item, &$children ){  
		
		$layout = $item->get_setting('layout');
		
		$layouts = $this->get_layouts();
		
		if ( array_key_exists( $layout , $layouts ) ){
			
			$layout = $layouts[ $layout ];
			
			if ( count( $children ) < $layout['columns'] ){ // Less columns than it should
				
				$t = $layout['columns'] - count( $children );
				
				for( $i = 0; $i < $t; $i++ ){
					
					$children[] = $this->get_item( 'tkdcolumn' );
					
				} // end for
				
			} else if ( count( $children ) > $layout['columns'] ){ // More columns than it should
			
				$t = count( $children ) - $layout['columns'];
				
				$over_content = '';
				
				for( $i = $layout['columns']; $i <= count( $children ); $i++ ){
					
					$ci = ( $i - 1 );
					
					$over_content .= $children[ $ci ]->get_content();
					
				} // end for
				
			} // end if
			
		} // end if
		
	} // end check_row_columns
	
	
	public function get_items_from_content( $content , $allowed , $default = false ){
		
		$items = array();
		
		if ( 'content' == $allowed ){
			
			$allowed = $this->get_the_items_array( true , true );
			
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
	
	
	public function get_items_from_save( $items_ids ){
		
		$items = array();
		
		$item_ids = explode( ',' , $items_ids );
		
		if ( $item_ids ){
			
			foreach( $item_ids as $id ){
				
				$item_post = 
				
				$id_info = explode( '_' , $id );
				
				if ( ! empty( $_POST[ $this->forms->get_prefix() ][ $id ]['settings'] ) ){
					
					$settings = $_POST[ $this->forms->get_prefix() ][ $id ]['settings'];
					
				} else {
					
					$settings = array();
					
				} // end if
				
				if ( ! empty( $_POST[ $this->forms->get_content_prefix() . $id ] ) ){
					
					$content = $_POST[ $this->forms->get_content_prefix() . $id ];
					
				} else {
					
					$content = '';
					
				} // end if
				
				$item = $this->get_item( $id_info[0] , $settings , $content , false , true );
				
				if ( ! empty( $_POST[ $this->forms->get_prefix() ][ $id ]['items'] ) ){
					
					$children = $this->get_items_from_save( $_POST[ $this->forms->get_prefix() ][ $id ]['items'] );
					
					$item->set_children( $children );
					
				} // end if;
				
				$items[] = $item;
				
			} // end foreach
			
		} // end if
		
		return $items;
		
	} // end get_items_from_save
	
	
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
	
	public function get_the_item_aray( $slug ){
		
		$items = $this->get_the_items_array();
		
		if ( ! empty( $items[ $slug ] ) ){
			
			return $items[ $slug ];
			
		} else {
			
			return false;
			
		} // end if
		
	} // end if
	
	
	public function get_the_items_array( $is_content = false , $slugs_only = false ){
		
		$items = array(
			'tkdrow'    => array(
				'class'       => 'TKD_Item_Row',
				'path'        => plugin_dir_path( dirname( __FILE__ ) ) . 'items/class-tkd-item-row.php',
				'register'    => true,
				'is_layout'   => true,
			),
			'tkdcolumn' => array(
				'class'       => 'TKD_Item_Column',
				'path'        => plugin_dir_path( dirname( __FILE__ ) ) . 'items/class-tkd-item-column.php',
				'register'    => true,
				'is_layout'   => true,
			),
			'tkdtext' => array(
				'class'       => 'TKD_Item_Text',
				'path'        => plugin_dir_path( dirname( __FILE__ ) ) . 'items/class-tkd-item-text.php',
				'register'    => true,
			),
			'tkdsubtitle' => array(
				'class'       => 'TKD_Item_Subtitle',
				'path'        => plugin_dir_path( dirname( __FILE__ ) ) . 'items/class-tkd-item-subtitle.php',
				'register'    => true,
			),
			'tkdvideo' => array(
				'class'       => 'TKD_Item_Video',
				'path'        => plugin_dir_path( dirname( __FILE__ ) ) . 'items/class-tkd-item-video.php',
				'register'    => true,
			),
		
		);
		
		if ( $is_content ){
			
			foreach( $items as $slug => $info ){
				
				if ( ! empty( $info['is_layout'] ) ){
					
					unset( $items[ $slug ] );
					
				} // end if
				
			} // end foreach
			
		} // end if
		
		if ( $slugs_only ){
			
			$items = array_keys( $items );
			
		} // end if
		
		return $items;
		
	} // end set_shortcodes
	
	
} // end TKD_Post_Editor