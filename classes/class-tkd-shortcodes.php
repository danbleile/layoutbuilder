<?php

class TKD_Shortcodes {
	
	protected $shortcodes;
	
	
	public function __construct(){
		
		$this->set_shortcodes();
		
	} // end __construct
	
	
	public function get_shortcode( $slug ){
		
		$shortcodes = $this->get_shortcodes();
		
		if ( array_key_exists( $slug , $shortcodes ) ){
			
			return $shortcodes[ $slug ];
			
		} else {
			
			return false;
			
		} // end if
		
	} // end get_shortcode
	
	
	public function get_shortcodes(){
		
		return $this->shortcodes;
		
	} // end get_shortcodes
	
	
	public function set_shortcodes(){
		
		$sc = array(
			'row'    => array(
				'class'     => 'TKD_Item_Row',
				'path'      => plugin_dir_path( dirname( __FILE__ ) ) . 'items/class-tkd-item-row.php',
				'register'  => true,
				'is_layout' => true,
			),
			'column' => array(
				'class'     => 'TKD_Item_Column',
				'path'      => plugin_dir_path( dirname( __FILE__ ) ) . 'items/class-tkd-item-column.php',
				'register'  => true,
				'is_layout' => true,
			),
			'text' => array(
				'class'     => 'TKD_Item_Text',
				'path'      => plugin_dir_path( dirname( __FILE__ ) ) . 'items/class-tkd-item-text.php',
				'register'  => true,
			),
		
		);
		
		$this->shortcodes = $sc;
		
	} // end set_shortcodes
	
	
	public function get_content_items_shortcodes( $only_slugs = true ){
		
		$shortcodes = $this->get_shortcodes();
		
		$column_shortcodes = array();
		
		foreach( $shortcodes as $slug => $info ){
			
			if ( empty( $info['is_layout'] ) ){
				
				$column_shortcodes[ $slug ] = $info;
				
			} // end if
			
		} // end foreach
		
		if ( $only_slugs ){
			
			return array_keys( $column_shortcodes );
			
		} else {
			
			return $column_shortcodes;
			
		} // end if
		
	} // end get_column_shortcodes
	
	
	public function get_item_shortcode( $item ){
		
		$delim = '"';
		
		$content = '';
		
		$settings_array = array();
		
		$settings = $item->get_settings();
		
		$children = $item->get_children();
		
		if ( ! empty( $children ) ){
			
			foreach( $children as $child ){
				
				$content .= $this->get_item_shortcode( $child );
				
			} // end foreach
			
		} else {
			
			$content = $item->get_content();
			
		} // end if
		
		if ( ! empty( $settings ) ){
			
			foreach( $settings as $key => $value ){
				
				if ( is_array( $value ) ){
					
					$delim = '\'';
					
					$settings[ $key ] = json_encode( $value , JSON_HEX_APOS ); 
					
				} // end if
				
			} // end foreach
			
			foreach( $settings as $key => $value ){
				
				$settings_array[] = $key . '=' . $delim . $value . $delim;
				
			} // end foreach
			
		} // end if
		
		$shortcode = '[' . $item->get_slug();
		
		if ( ! empty( $settings_array ) ){
			
			$shortcode .= ' ' .  implode( ' ' , $settings_array );
			
		} // end if
		
		if ( ! $content ){
			
			$shortcode .= ']';
			
		} else {
			
			$shortcode .= ']' . $content . '[/' . $item->get_slug() . ']';
			
		}// end if
		
		return $shortcode;
		
	} // end get_item_shortcode
	
	
} // end TKD_Post_Editor