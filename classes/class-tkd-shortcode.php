<?php
class TKD_Shortcode {
	
	protected $items_factory;
	
	public function __construct( $items_factory ){
		
		$this->items_factory = $items_factory;
		
	} // end __construct
	
	
	public function init(){
		
		$items_array = $this->items_factory->get_the_items_array();
		
		foreach( $items_array as $slug => $item_info ){
			
			if ( ! isset( $item_info['register'] ) || ! empty( $item_info['register'] ) ){
				
				add_shortcode( $slug , array( $this , 'do_shortcode') );
				
			} // end if
			
		} // end foreach
		
	}
	
	
	public function do_shortcode( $atts , $content , $tag ){
		
		$html = '';
		
		$item = $this->items_factory->get_item( $tag );
		
		if ( $item ){
			
			$item->set_item( $atts , $content );
			
			$html .= $item->get_the_item();
			
		} // enf if
		
		return $html;
		
	} // end do_shortcode

	
}