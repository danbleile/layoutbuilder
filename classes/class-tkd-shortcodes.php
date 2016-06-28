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
	
	
	public function get_column_shortcodes( $only_slugs = true ){
		
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
	
} // end TKD_Post_Editor