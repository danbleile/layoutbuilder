<?php

class LB_Shortcode_Factory {
	
	protected $items_factory;
	
	
	public function __construct( $items_factory ){
		
		$this->items_factory = $items_factory;
		
	}
	
	public function register_item_shortcodes(){
		
		$items_array = $this->items_factory->get_items_array();
		
		foreach( $items_array as $item ){
			
			if ( ! isset( $item['register'] )  || ( isset( $item['register'] ) &&  $item['register'] ) ){
				
				add_shortcode( 'foobar', array( $this , 'do_shortcode' ) );
				
			} // end if
			
		} // end foreach
		
		//var_dump( $items_array );
		
	} // end register_shortcodes
	
	
	public function do_shortcode( $atts , $content = '' , $shortcode ){
	} // end do_shortcode
	
	
	public function get_shortcodes_recursive( $items ){
		
		$shortcodes = '';
		
		if ( ! empty( $items ) ){
			
			foreach( $items as $item ){
				
				$sh = '[' . $item->get_slug() . ' ' . $this->get_shortcode_settings( $item ) . ' ]';
				
				$content = $item->get_content();
				
				$children = $item->get_children();
				
				if ( ! empty( $children  ) ){
					
					$sh .= $this->get_shortcodes_recursive( $children );
					
					$sh .= '[/' . $item->get_slug() . ']';
					
				} else if ( ! empty( $content ) ){
					
					$sh .= $content;
					
					$sh .= '[/' . $item->get_slug() . ']';
					
				} // end if
				
				$shortcodes .= $sh;
				
			}
			
		} // end if
		
		return $shortcodes;
		
	}
	
	
	protected function get_shortcode_settings( $item ){
		
		return '';
		
	}
	
}